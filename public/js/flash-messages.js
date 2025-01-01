function showFlashMessage(type, message) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    const icons = {
        'success': 'success',
        'error': 'error',
        'warning': 'warning',
        'info': 'info'
    };

    Toast.fire({
        icon: icons[type] || 'info',
        title: message
    });
}

// Fonction pour gérer les messages flash de Symfony
document.addEventListener('DOMContentLoaded', function() {
    const flashMessages = document.querySelectorAll('.flash-message');
    flashMessages.forEach(function(flashMessage) {
        const type = flashMessage.dataset.type;
        const message = flashMessage.textContent;
        showFlashMessage(type, message);
        flashMessage.remove(); // Supprimer l'élément après affichage
    });
});
