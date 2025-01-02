/* document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[name="departement"]');
    const dateInput = document.querySelector('#departement_dateCreation');

    if (form && dateInput) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Récupérer la valeur de l'input date
            let dateValue = dateInput.value;
            
            if (dateValue) {
                try {
                    // Créer un objet Date à partir de la valeur
                    const date = new Date(dateValue);
                    
                    // Formater la date au format ISO string (compatible avec DateTime)
                    dateInput.value = date.toISOString();
                    
                    // Soumettre le formulaire
                    form.submit();
                } catch (error) {
                    console.error('Erreur lors de la conversion de la date:', error);
                }
            } else {
                console.error('La date est requise');
            }
        });
    }
}); */
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[name="departement"]');
    const dateInput = document.querySelector('#departement_dateCreation');

    if (form && dateInput) {
        // Initialiser Flatpickr
        const fp = flatpickr(dateInput, {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            onChange: function(selectedDates, dateStr) {
                if (selectedDates[0]) {
                    // Mettre à jour la valeur de l'input avec le format ISO
                    dateInput.setAttribute('data-date', selectedDates[0].toISOString());
                }
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Récupérer la date stockée
            const dateValue = dateInput.getAttribute('data-date');
            
            if (dateValue) {
                // Mettre à jour la valeur de l'input avec la date ISO
                dateInput.value = dateValue;
                
                // Soumettre le formulaire
                form.submit();
            } else {
                console.error('La date est requise');
                // Optionnellement, afficher un message d'erreur à l'utilisateur
            }
        });
    }
});
