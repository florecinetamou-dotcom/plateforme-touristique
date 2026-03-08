/**
 * TOURISME BÉNIN - FICHIER PRINCIPAL JAVASCRIPT
 * Projet de Licence
 */

// ===== ATTENDRE QUE LE DOM SOIT CHARGÉ =====
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialiser toutes les fonctions
    initNavbar();
    initTooltips();
    initPopovers();
    initScrollSpy();
    initBackToTop();
    initLazyLoading();
    initFormValidation();
    initAutoCloseAlerts();
    initSmoothScroll();
    initMobileMenu();
    
});

// ===== 1. NAVBAR SCROLL EFFECT =====
function initNavbar() {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 100) {
            navbar.classList.add('navbar-scrolled', 'shadow-sm');
        } else {
            navbar.classList.remove('navbar-scrolled', 'shadow-sm');
        }
    });
}

// ===== 2. TOOLTIPS BOOTSTRAP =====
function initTooltips() {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
}

// ===== 3. POPOVERS BOOTSTRAP =====
function initPopovers() {
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

// ===== 4. SCROLL SPY =====
function initScrollSpy() {
    const scrollSpy = document.querySelector('[data-bs-spy="scroll"]');
    if (scrollSpy) {
        bootstrap.ScrollSpy.getInstance(scrollSpy)?.refresh();
    }
}

// ===== 5. BOUTON RETOUR EN HAUT =====
function initBackToTop() {
    const backToTopBtn = document.createElement('button');
    backToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTopBtn.className = 'btn-back-to-top';
    backToTopBtn.setAttribute('aria-label', 'Retour en haut');
    backToTopBtn.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, #008751, #FFD600);
        color: white;
        border: none;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        transition: all 0.3s ease;
        z-index: 9999;
    `;
    
    document.body.appendChild(backToTopBtn);
    
    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            backToTopBtn.style.display = 'flex';
            backToTopBtn.style.animation = 'fadeIn 0.3s ease';
        } else {
            backToTopBtn.style.display = 'none';
        }
    });
    
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// ===== 6. CHARGEMENT LAZY DES IMAGES =====
function initLazyLoading() {
    const images = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('fade-in');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
}

// ===== 7. VALIDATION DE FORMULAIRES =====
function initFormValidation() {
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
}

// ===== 8. FERMETURE AUTOMATIQUE DES ALERTES =====
function initAutoCloseAlerts() {
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
}

// ===== 9. SCROLL SMOOTH POUR LES LIENS INTERNES =====
function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// ===== 10. MENU MOBILE AMÉLIORÉ =====
function initMobileMenu() {
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    
    if (navbarToggler && navbarCollapse) {
        // Fermer le menu quand on clique sur un lien
        navbarCollapse.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 992) {
                    navbarToggler.click();
                }
            });
        });
        
        // Empêcher la fermeture en cliquant dans le menu
        navbarCollapse.addEventListener('click', (e) => {
            e.stopPropagation();
        });
    }
}

// ===== 11. GESTIONNAIRE DE CHARGEMENT =====
const Loader = {
    show: function(container) {
        const loader = document.createElement('div');
        loader.className = 'loader-container';
        loader.innerHTML = '<div class="loader"></div>';
        loader.style.cssText = `
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
        `;
        
        container = container || document.body;
        container.style.position = 'relative';
        container.appendChild(loader);
        return loader;
    },
    
    hide: function(loader) {
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(() => loader.remove(), 300);
        }
    }
};

// ===== 12. FORMATAGE DES PRIX =====
function formatPrice(price) {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'XOF',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(price).replace('XOF', 'FCFA');
}

// ===== 13. FORMATAGE DES DATES =====
function formatDate(dateString) {
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    };
    return new Date(dateString).toLocaleDateString('fr-FR', options);
}

// ===== 14. TRONCATURE DE TEXTE =====
function truncateText(text, length = 100) {
    if (text.length <= length) return text;
    return text.substring(0, length) + '...';
}

// ===== 15. GESTION DES ERREURS AJAX =====
window.handleAjaxError = function(error) {
    console.error('Erreur AJAX:', error);
    
    let message = 'Une erreur est survenue. Veuillez réessayer.';
    
    if (error.responseJSON && error.responseJSON.message) {
        message = error.responseJSON.message;
    } else if (error.status === 401) {
        message = 'Votre session a expiré. Veuillez vous reconnecter.';
        setTimeout(() => window.location.href = '/login', 2000);
    } else if (error.status === 403) {
        message = 'Vous n\'avez pas les droits pour effectuer cette action.';
    } else if (error.status === 404) {
        message = 'Ressource non trouvée.';
    } else if (error.status === 500) {
        message = 'Erreur serveur. Veuillez réessayer plus tard.';
    }
    
    // Afficher une notification
    showNotification(message, 'danger');
};

// ===== 16. NOTIFICATIONS TOAST =====
function showNotification(message, type = 'success') {
    const toastContainer = document.querySelector('.toast-container');
    
    if (!toastContainer) {
        const container = document.createElement('div');
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white bg-${type} border-0`;
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                ${message}
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    `;
    
    document.querySelector('.toast-container').appendChild(toast);
    
    const bsToast = new bootstrap.Toast(toast, { delay: 5000 });
    bsToast.show();
    
    toast.addEventListener('hidden.bs.toast', () => toast.remove());
}

// ===== 17. CONFIRMATION DE SUPPRESSION =====
function confirmDelete(message = 'Êtes-vous sûr de vouloir supprimer cet élément ?') {
    return confirm(message);
}

// ===== 18. COPIER DANS LE PRESSE-PAPIERS =====
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        showNotification('Copié dans le presse-papiers !', 'success');
    }).catch(() => {
        showNotification('Erreur lors de la copie', 'danger');
    });
}

// ===== 19. DÉTECTION DE LA CONNEXION INTERNET =====
window.addEventListener('online', function() {
    showNotification('Connexion internet rétablie', 'success');
});

window.addEventListener('offline', function() {
    showNotification('Connexion internet perdue', 'warning');
});

// ===== 20. PRÉVENTION DU DOUBLE CLIC SUR LES FORMULAIRES =====
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function() {
        const submitBtn = this.querySelector('[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Traitement...';
        }
    });
});

// Exporter les fonctions globales
window.formatPrice = formatPrice;
window.formatDate = formatDate;
window.truncateText = truncateText;
window.showNotification = showNotification;
window.confirmDelete = confirmDelete;
window.copyToClipboard = copyToClipboard;
window.Loader = Loader;