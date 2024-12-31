document.addEventListener('DOMContentLoaded', function() {
    // Initialiser tous les datepickers
    flatpickr('.js-datepicker', {
        locale: 'fr',
        dateFormat: 'd F Y',
        altInput: true,
        altFormat: 'd F Y',
        formatDate: (date) => {
            return new Intl.DateTimeFormat('fr-FR', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }).format(date);
        }
    });
});
