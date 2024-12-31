document.addEventListener('DOMContentLoaded', function() {
    flatpickr('.js-yearpicker', {
        locale: 'fr',
        dateFormat: 'Y',
        altInput: true,
        altFormat: 'Y',
        plugins: [
            new monthSelectPlugin({
                shorthand: true,
                dateFormat: "Y",
                altFormat: "Y",
                theme: "material_blue"
            })
        ]
    });
});
