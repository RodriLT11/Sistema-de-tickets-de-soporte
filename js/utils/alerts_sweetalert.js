// Mostrar alerta de éxito
function showSuccess(message, redirectUrl = null) {
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: message,
        confirmButtonText: 'Aceptar'
    }).then(() => {
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
    });
}

// Mostrar alerta de error
function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        confirmButtonText: 'Aceptar'
    });
}

// Mostrar alerta de información
function showInfo(message) {
    Swal.fire({
        icon: 'info',
        title: 'Información',
        text: message,
        confirmButtonText: 'Aceptar'
    });
}
