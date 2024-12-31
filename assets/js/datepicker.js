import flatpickr from 'flatpickr';
import { French } from 'flatpickr/dist/l10n/fr.js';
import 'flatpickr/dist/flatpickr.min.css';

document.addEventListener('DOMContentLoaded', function() {
    const dateConfig = {
        locale: French,
        dateFormat: 'Y',
        altFormat: 'Y',
        allowInput: true,
        disableMobile: false,
        plugins: [],
        theme: 'light',
        onChange: function(selectedDates, dateStr, instance) {
            // Si c'est le champ de début, mettre à jour la date minimale du champ de fin
            if (instance.element.id === 'annee_academique_YearStart') {
                const endYearPicker = document.querySelector('#annee_academique_YearEnd')._flatpickr;
                if (selectedDates[0]) {
                    endYearPicker.set('minDate', selectedDates[0]);
                }
            }
        }
    };

    // Initialiser le picker pour l'année de début
    flatpickr('#annee_academique_YearStart', {
        ...dateConfig,
        defaultDate: new Date().getFullYear(),
    });

    // Initialiser le picker pour l'année de fin
    flatpickr('#annee_academique_YearEnd', {
        ...dateConfig,
        defaultDate: new Date().getFullYear() + 1,
    });
});
