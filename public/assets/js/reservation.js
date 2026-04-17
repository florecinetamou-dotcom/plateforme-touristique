/**
 * TOURISME BÉNIN - GESTION DES RÉSERVATIONS
 */

document.addEventListener('DOMContentLoaded', function() {
    initReservationForm();
    initPriceCalculator();
    initDisponibiliteChecker();
    initAnnulation();
    initPaiement();
});

// ===== 1. FORMULAIRE DE RÉSERVATION =====
function initReservationForm() {
    const form = document.getElementById('reservationForm');
    if (!form) return;
    
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!validateReservationForm()) {
            return;
        }
        
        // Afficher le loader
        const loader = Loader.show(form);
        
        try {
            const formData = new FormData(form);
            const response = await fetch('/api/reservations', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            Loader.hide(loader);
            
            if (data.success) {
                showNotification('Réservation effectuée avec succès !', 'success');
                setTimeout(() => {
                    window.location.href = `/reservation/${data.data.reservation.id}/confirmation`;
                }, 1500);
            } else {
                showNotification(data.error || 'Erreur lors de la réservation', 'danger');
            }
        } catch (error) {
            Loader.hide(loader);
            handleAjaxError(error);
        }
    });
}

// ===== 2. VALIDATION DU FORMULAIRE =====
function validateReservationForm() {
    const dateArrivee = document.getElementById('dateArrivee').value;
    const dateDepart = document.getElementById('dateDepart').value;
    const nbVoyageurs = parseInt(document.getElementById('nbVoyageurs').value);
    const capacite = parseInt(document.getElementById('capaciteMax')?.value || 999);
    
    let isValid = true;
    let errorMessage = '';
    
    // Vérifier les dates
    if (!dateArrivee || !dateDepart) {
        errorMessage = 'Veuillez sélectionner les dates de votre séjour.';
        isValid = false;
    } else {
        const arrivee = new Date(dateArrivee);
        const depart = new Date(dateDepart);
        const aujourdHui = new Date();
        aujourdHui.setHours(0, 0, 0, 0);
        
        if (arrivee < aujourdHui) {
            errorMessage = 'La date d\'arrivée doit être dans le futur.';
            isValid = false;
        } else if (depart <= arrivee) {
            errorMessage = 'La date de départ doit être postérieure à la date d\'arrivée.';
            isValid = false;
        }
    }
    
    // Vérifier le nombre de voyageurs
    if (nbVoyageurs > capacite) {
        errorMessage = `Capacité maximale dépassée. Maximum ${capacite} personne(s).`;
        isValid = false;
    }
    
    // Vérifier les conditions générales
    const conditions = document.getElementById('acceptConditions');
    if (conditions && !conditions.checked) {
        errorMessage = 'Vous devez accepter les conditions générales.';
        isValid = false;
    }
    
    if (!isValid) {
        showNotification(errorMessage, 'warning');
    }
    
    return isValid;
}

// ===== 3. CALCULATEUR DE PRIX =====
function initPriceCalculator() {
    const dateArrivee = document.getElementById('dateArrivee');
    const dateDepart = document.getElementById('dateDepart');
    const prixBase = parseFloat(document.getElementById('prixBase')?.value || 0);
    const optionsContainer = document.querySelectorAll('.option-checkbox');
    
    if (dateArrivee && dateDepart && prixBase) {
        [dateArrivee, dateDepart].forEach(input => {
            input.addEventListener('change', calculatePrice);
        });
        
        optionsContainer.forEach(option => {
            option.addEventListener('change', calculatePrice);
        });
    }
}

function calculatePrice() {
    const dateArrivee = document.getElementById('dateArrivee').value;
    const dateDepart = document.getElementById('dateDepart').value;
    const prixBase = parseFloat(document.getElementById('prixBase').value);
    const nbVoyageurs = parseInt(document.getElementById('nbVoyageurs').value) || 1;
    
    if (!dateArrivee || !dateDepart || !prixBase) return;
    
    // Calculer le nombre de nuits
    const arrivee = new Date(dateArrivee);
    const depart = new Date(dateDepart);
    const nbNuits = Math.ceil((depart - arrivee) / (1000 * 60 * 60 * 24));
    
    // Prix de base
    let total = nbNuits * prixBase;
    
    // Ajouter les options
    document.querySelectorAll('.option-checkbox:checked').forEach(option => {
        const prix = parseFloat(option.dataset.prix || 0);
        const type = option.dataset.type || 'nuit';
        
        if (type === 'nuit') {
            total += prix * nbNuits;
        } else if (type === 'personne') {
            total += prix * nbVoyageurs;
        } else {
            total += prix;
        }
    });
    
    // Mettre à jour l'affichage
    document.getElementById('nbNuits').textContent = nbNuits;
    document.getElementById('prixTotal').textContent = formatPrice(total);
    
    // Afficher le détail
    showPriceDetail(nbNuits, prixBase, total);
}

function showPriceDetail(nbNuits, prixBase, total) {
    const detailContainer = document.getElementById('priceDetail');
    if (!detailContainer) return;
    
    let html = `
        <div class="bg-light p-3 rounded-3">
            <div class="d-flex justify-content-between mb-2">
                <span>${prixBase.toLocaleString('fr-FR')} FCFA x ${nbNuits} nuit(s)</span>
                <span>${(prixBase * nbNuits).toLocaleString('fr-FR')} FCFA</span>
            </div>
    `;
    
    document.querySelectorAll('.option-checkbox:checked').forEach(option => {
        const label = option.closest('label')?.textContent?.trim() || 'Option';
        const prix = parseFloat(option.dataset.prix || 0);
        html += `
            <div class="d-flex justify-content-between mb-2 small text-muted">
                <span>${label}</span>
                <span>+${prix.toLocaleString('fr-FR')} FCFA</span>
            </div>
        `;
    });
    
    html += `
        <hr class="my-2">
        <div class="d-flex justify-content-between fw-bold">
            <span>Total</span>
            <span class="text-benin">${total.toLocaleString('fr-FR')} FCFA</span>
        </div>
        </div>
    `;
    
    detailContainer.innerHTML = html;
}

// ===== 4. VÉRIFICATEUR DE DISPONIBILITÉ =====
function initDisponibiliteChecker() {
    const checkBtn = document.getElementById('checkDisponibilite');
    
    if (checkBtn) {
        checkBtn.addEventListener('click', async function() {
            const hebergementId = this.dataset.hebergementId;
            const dateArrivee = document.getElementById('dateArrivee').value;
            const dateDepart = document.getElementById('dateDepart').value;
            
            if (!dateArrivee || !dateDepart) {
                showNotification('Veuillez sélectionner des dates', 'warning');
                return;
            }
            
            const loader = Loader.show(this);
            
            try {
                const response = await fetch(`/api/hebergements/${hebergementId}/disponibilite?date_arrivee=${dateArrivee}&date_depart=${dateDepart}`);
                const data = await response.json();
                
                Loader.hide(loader);
                
                if (data.success) {
                    if (data.data.disponible) {
                        showNotification('Ces dates sont disponibles !', 'success');
                        document.getElementById('btnReserver').disabled = false;
                    } else {
                        let message = 'Ces dates ne sont pas disponibles.';
                        if (data.data.jours_indisponibles?.length) {
                            message += ' Jours indisponibles : ' + data.data.jours_indisponibles.join(', ');
                        }
                        showNotification(message, 'warning');
                        document.getElementById('btnReserver').disabled = true;
                    }
                }
            } catch (error) {
                Loader.hide(loader);
                handleAjaxError(error);
            }
        });
    }
}

// ===== 5. GESTION DE L'ANNULATION =====
function initAnnulation() {
    const cancelBtns = document.querySelectorAll('.cancel-reservation');
    
    cancelBtns.forEach(btn => {
        btn.addEventListener('click', async function(e) {
            e.preventDefault();
            
            if (!confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) {
                return;
            }
            
            const reservationId = this.dataset.id;
            const loader = Loader.show(this);
            
            try {
                const response = await fetch(`/api/reservations/${reservationId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                
                Loader.hide(loader);
                
                if (data.success) {
                    showNotification('Réservation annulée avec succès', 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    showNotification(data.error || 'Erreur lors de l\'annulation', 'danger');
                }
            } catch (error) {
                Loader.hide(loader);
                handleAjaxError(error);
            }
        });
    });
}

// ===== 6. GESTION DU PAIEMENT =====
function initPaiement() {
    const paiementForm = document.getElementById('paiementForm');
    
    if (paiementForm) {
        paiementForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const loader = Loader.show(this);
            
            try {
                // Simulation de paiement (à remplacer par vrai paiement)
                await new Promise(resolve => setTimeout(resolve, 2000));
                
                Loader.hide(loader);
                
                showNotification('Paiement effectué avec succès !', 'success');
                setTimeout(() => {
                    window.location.href = '/reservations';
                }, 1500);
            } catch (error) {
                Loader.hide(loader);
                showNotification('Erreur lors du paiement', 'danger');
            }
        });
    }
}

// ===== 7. OPTIONS DE RÉSERVATION =====
function initReservationOptions() {
    const options = document.querySelectorAll('.reservation-option');
    
    options.forEach(option => {
        option.addEventListener('change', function() {
            const priceDetail = document.getElementById('optionsPriceDetail');
            if (priceDetail) {
                let totalOptions = 0;
                options.forEach(opt => {
                    if (opt.checked) {
                        totalOptions += parseFloat(opt.dataset.prix || 0);
                    }
                });
                
                if (totalOptions > 0) {
                    priceDetail.textContent = `+${totalOptions.toLocaleString('fr-FR')} FCFA`;
                } else {
                    priceDetail.textContent = '';
                }
            }
        });
    });
}

// ===== 8. RÉSERVATION RAPIDE =====
function initQuickReservation() {
    const quickReserveBtns = document.querySelectorAll('.quick-reserve');
    
    quickReserveBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const hebergementId = this.dataset.id;
            const prix = this.dataset.prix;
            
            // Remplir le formulaire de réservation rapide
            document.getElementById('hebergementId').value = hebergementId;
            document.getElementById('prixBase').value = prix;
            
            // Ouvrir la modal
            const modal = new bootstrap.Modal(document.getElementById('quickReservationModal'));
            modal.show();
        });
    });
}