// Cargar tema guardado al iniciar la página
window.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme');
    const themeSwitch = document.getElementById('themeSwitch');
    
    if (savedTheme === 'dark') {
        document.body.classList.add('dark');
        if (themeSwitch) {
            themeSwitch.checked = true;
        }
    }
    
    // Agregar event listener al switch
    if (themeSwitch) {
        themeSwitch.addEventListener('change', toggleTheme);
    }
});

// Función para cambiar el tema
function toggleTheme() {
    document.body.classList.toggle('dark');
    
    // Guardar el tema en localStorage
    if (document.body.classList.contains('dark')) {
        localStorage.setItem('theme', 'dark');
    } else {
        localStorage.setItem('theme', 'light');
    }
}