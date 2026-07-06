/**
 * Scripts JavaScript pour Gestion Académique
 */

// Notification système
function showNotification(message, type = 'success') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.setAttribute('role', 'alert');
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    const container = document.querySelector('main') || document.body;
    container.insertBefore(alertDiv, container.firstChild);
    
    // Retrait automatique après 5 secondes
    setTimeout(() => {
        const bsAlert = new bootstrap.Alert(alertDiv);
        bsAlert.close();
    }, 5000);
}

// Confirmation de suppression
function confirmDelete(message = 'Êtes-vous sûr de vouloir supprimer cet élément ?') {
    return confirm(message);
}

// Validation de formulaire
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    
    let isValid = true;
    const inputs = form.querySelectorAll('input, textarea, select');
    
    inputs.forEach(input => {
        if (!validateInput(input)) {
            isValid = false;
        }
    });
    
    return isValid;
}

// Validation d'un champ individuel
function validateInput(input) {
    const value = input.value.trim();
    
    // Vérifier si le champ est requis
    if (input.hasAttribute('required') && value === '') {
        showFieldError(input, 'Ce champ est obligatoire');
        return false;
    }
    
    // Validation par type
    if (input.type === 'email' && value !== '') {
        if (!isValidEmail(value)) {
            showFieldError(input, 'Email invalide');
            return false;
        }
    }
    
    if (input.dataset.type === 'phone' && value !== '') {
        if (!isValidPhone(value)) {
            showFieldError(input, 'Téléphone invalide');
            return false;
        }
    }
    
    if (input.dataset.type === 'number' && value !== '') {
        if (isNaN(value)) {
            showFieldError(input, 'Doit être un nombre');
            return false;
        }
    }
    
    clearFieldError(input);
    return true;
}

// Vérifier format email
function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Vérifier format téléphone
function isValidPhone(phone) {
    const re = /^[0-9\-\+\s\(\)]{9,}$/;
    return re.test(phone);
}

// Afficher erreur de champ
function showFieldError(input, message) {
    input.classList.add('is-invalid');
    
    let errorDiv = input.nextElementSibling;
    if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        input.parentNode.insertBefore(errorDiv, input.nextSibling);
    }
    
    errorDiv.textContent = message;
}

// Effacer erreur de champ
function clearFieldError(input) {
    input.classList.remove('is-invalid');
}

// Aperçu des photos
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Recherche instantanée
function instantSearch(inputId, tableId) {
    const searchInput = document.getElementById(inputId);
    const table = document.getElementById(tableId);
    
    if (!searchInput || !table) return;
    
    searchInput.addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });
}

// Calcul automatique des moyennes
function calculateAverage(cc, tp, exam) {
    // CC: 30%, TP: 30%, Examen: 40%
    return (parseFloat(cc) * 0.3 + parseFloat(tp) * 0.3 + parseFloat(exam) * 0.4).toFixed(2);
}

// Calculer le reste à payer
function calculateRemaining(total, paid) {
    return (parseFloat(total) - parseFloat(paid)).toFixed(2);
}

// Format monétaire
function formatCurrency(amount) {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'XOF'
    }).format(amount);
}

// Format date
function formatDate(dateString) {
    const options = { year: 'numeric', month: '2-digit', day: '2-digit' };
    return new Date(dateString).toLocaleDateString('fr-FR', options);
}

// Menu responsive
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du menu mobile
    const navToggle = document.querySelector('.navbar-toggler');
    if (navToggle) {
        navToggle.addEventListener('click', function() {
            const navMenu = document.querySelector('#navbarNav');
            navMenu.classList.toggle('show');
        });
    }
    
    // Fermer le menu au clic sur un lien
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            const navMenu = document.querySelector('#navbarNav');
            if (navMenu) {
                navMenu.classList.remove('show');
            }
        });
    });
});

// Export vers Excel
function exportToExcel(tableId, filename = 'export.xlsx') {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    let excel = '<table>';
    const rows = table.querySelectorAll('tr');
    
    rows.forEach(row => {
        excel += '<tr>';
        const cols = row.querySelectorAll('td, th');
        cols.forEach(col => {
            excel += '<td>' + col.innerText + '</td>';
        });
        excel += '</tr>';
    });
    
    excel += '</table>';
    
    const link = document.createElement('a');
    link.href = 'data:application/vnd.ms-excel,' + encodeURIComponent(excel);
    link.download = filename;
    link.click();
}

// Imprimer un élément
function printElement(elementId) {
    const element = document.getElementById(elementId);
    if (!element) return;
    
    const printWindow = window.open('', '', 'height=600, width=800');
    printWindow.document.write('<html><head><title>Impression</title>');
    printWindow.document.write('<link rel="stylesheet" href="' + window.location.origin + '/assets/css/style.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write(element.innerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}
