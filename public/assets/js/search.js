/**
 * TOURISME BÉNIN - RECHERCHE DYNAMIQUE
 */

document.addEventListener('DOMContentLoaded', function() {
    initSearchForm();
    initAutocomplete();
    initFilters();
    initPriceSlider();
});

// ===== 1. FORMULAIRE DE RECHERCHE =====
function initSearchForm() {
    const searchForm = document.getElementById('searchForm');
    if (!searchForm) return;
    
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Récupérer les valeurs
        const destination = document.getElementById('destination')?.value;
        const dateArrivee = document.getElementById('dateArrivee')?.value;
        const dateDepart = document.getElementById('dateDepart')?.value;
        const voyageurs = document.getElementById('voyageurs')?.value;
        
        // Construire l'URL
        let url = '/hebergements?';
        const params = [];
        
        if (destination) params.push(`ville=${destination}`);
        if (dateArrivee) params.push(`arrivee=${dateArrivee}`);
        if (dateDepart) params.push(`depart=${dateDepart}`);
        if (voyageurs) params.push(`voyageurs=${voyageurs}`);
        
        window.location.href = url + params.join('&');
    });
    
    // Initialiser les datepickers
    initDatepickers();
}

// ===== 2. AUTCOMPLÉTION =====
function initAutocomplete() {
    const searchInput = document.getElementById('searchInput');
    if (!searchInput) return;
    
    let timeoutId;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(timeoutId);
        
        const query = this.value.trim();
        
        if (query.length < 2) {
            hideAutocomplete();
            return;
        }
        
        timeoutId = setTimeout(() => {
            fetch(`/api/search/autocomplete?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.length > 0) {
                        showAutocomplete(data.data);
                    } else {
                        hideAutocomplete();
                    }
                })
                .catch(() => hideAutocomplete());
        }, 300);
    });
    
    // Fermer au clic extérieur
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.autocomplete-container')) {
            hideAutocomplete();
        }
    });
}

function showAutocomplete(results) {
    let container = document.querySelector('.autocomplete-container');
    
    if (!container) {
        container = document.createElement('div');
        container.className = 'autocomplete-container';
        container.style.cssText = `
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 0 0 1rem 1rem;
            box-shadow: var(--shadow-lg);
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
        `;
        
        const searchInput = document.getElementById('searchInput');
        searchInput.parentElement.style.position = 'relative';
        searchInput.parentElement.appendChild(container);
    }
    
    let html = '<div class="list-group list-group-flush">';
    
    results.forEach(result => {
        html += `
            <a href="${result.url}" class="list-group-item list-group-item-action d-flex align-items-center">
                <i class="fas fa-${result.type === 'ville' ? 'city' : 'hotel'} text-benin me-3"></i>
                <div>
                    <div class="fw-bold">${result.text}</div>
                    <small class="text-muted">${result.subtext || ''}</small>
                </div>
            </a>
        `;
    });
    
    html += '</div>';
    container.innerHTML = html;
}

function hideAutocomplete() {
    const container = document.querySelector('.autocomplete-container');
    if (container) container.remove();
}

// ===== 3. FILTRES DYNAMIQUES =====
function initFilters() {
    const filterCheckboxes = document.querySelectorAll('.filter-checkbox');
    
    filterCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            applyFilters();
        });
    });
    
    // Prix min/max
    const prixMin = document.getElementById('prixMin');
    const prixMax = document.getElementById('prixMax');
    
    if (prixMin && prixMax) {
        [prixMin, prixMax].forEach(input => {
            input.addEventListener('change', applyFilters);
        });
    }
}

function applyFilters() {
    const url = new URL(window.location);
    
    // Types d'hébergement
    const selectedTypes = [];
    document.querySelectorAll('.filter-type:checked').forEach(cb => {
        selectedTypes.push(cb.value);
    });
    
    if (selectedTypes.length) {
        url.searchParams.set('type', selectedTypes.join(','));
    } else {
        url.searchParams.delete('type');
    }
    
    // Équipements
    const selectedEquipements = [];
    document.querySelectorAll('.filter-equipement:checked').forEach(cb => {
        selectedEquipements.push(cb.value);
    });
    
    if (selectedEquipements.length) {
        url.searchParams.set('equipements', selectedEquipements.join(','));
    } else {
        url.searchParams.delete('equipements');
    }
    
    // Prix
    const prixMin = document.getElementById('prixMin')?.value;
    const prixMax = document.getElementById('prixMax')?.value;
    
    if (prixMin) url.searchParams.set('prix_min', prixMin);
    else url.searchParams.delete('prix_min');
    
    if (prixMax) url.searchParams.set('prix_max', prixMax);
    else url.searchParams.delete('prix_max');
    
    window.location.href = url.toString();
}

// ===== 4. SLIDER DE PRIX =====
function initPriceSlider() {
    const slider = document.getElementById('priceSlider');
    if (!slider) return;
    
    const min = parseInt(slider.dataset.min) || 0;
    const max = parseInt(slider.dataset.max) || 200000;
    
    noUiSlider.create(slider, {
        start: [min, max],
        connect: true,
        step: 5000,
        range: {
            'min': min,
            'max': max
        },
        format: {
            to: value => Math.round(value),
            from: value => Math.round(value)
        }
    });
    
    slider.noUiSlider.on('update', function(values) {
        document.getElementById('prixMin').value = values[0];
        document.getElementById('prixMax').value = values[1];
        document.getElementById('prixMinLabel').textContent = formatPrice(values[0]);
        document.getElementById('prixMaxLabel').textContent = formatPrice(values[1]);
    });
}

// ===== 5. DATEPICKERS =====
function initDatepickers() {
    const dateInputs = document.querySelectorAll('.datepicker');
    
    dateInputs.forEach(input => {
        flatpickr(input, {
            locale: 'fr',
            minDate: 'today',
            dateFormat: 'Y-m-d',
            onChange: function(selectedDates, dateStr, instance) {
                // Si c'est la date d'arrivée, mettre à jour la minDate du départ
                if (input.id === 'dateArrivee') {
                    const departInput = document.getElementById('dateDepart');
                    if (departInput && departInput._flatpickr) {
                        departInput._flatpickr.set('minDate', dateStr);
                    }
                }
            }
        });
    });
}

// ===== 6. TRI =====
function initSorting() {
    const sortSelect = document.getElementById('sortBy');
    
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const url = new URL(window.location);
            url.searchParams.set('sort', this.value);
            window.location.href = url.toString();
        });
    }
}

// ===== 7. VUE GRILLE/LISTE =====
function initViewToggle() {
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const resultsContainer = document.getElementById('resultsContainer');
    
    if (gridView && listView && resultsContainer) {
        gridView.addEventListener('click', () => {
            resultsContainer.classList.remove('list-view');
            resultsContainer.classList.add('grid-view');
            localStorage.setItem('viewMode', 'grid');
            updateActiveView('grid');
        });
        
        listView.addEventListener('click', () => {
            resultsContainer.classList.remove('grid-view');
            resultsContainer.classList.add('list-view');
            localStorage.setItem('viewMode', 'list');
            updateActiveView('list');
        });
        
        // Restaurer la préférence
        const savedMode = localStorage.getItem('viewMode');
        if (savedMode === 'list') {
            listView.click();
        }
    }
}

function updateActiveView(mode) {
    document.getElementById('gridView').classList.toggle('active', mode === 'grid');
    document.getElementById('listView').classList.toggle('active', mode === 'list');
}