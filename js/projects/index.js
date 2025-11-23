// Variables globales
let projects = [];
let editingId = null;

// DOM Elements
const btnNewProject = document.getElementById('btnNewProject');
const projectModal = document.getElementById('projectModal');
const deleteModal = document.getElementById('deleteModal');
const closeModal = document.getElementById('closeModal');
const btnCancel = document.getElementById('btnCancel');
const projectForm = document.getElementById('projectForm');
const projectsGrid = document.getElementById('projectsGrid');
const modalTitle = document.getElementById('modalTitle');
const btnCancelDelete = document.getElementById('btnCancelDelete');
const btnConfirmDelete = document.getElementById('btnConfirmDelete');

// Inicializar
document.addEventListener('DOMContentLoaded', () => {
    loadProjects();
});

// Event Listeners
btnNewProject.addEventListener('click', openAddModal);
closeModal.addEventListener('click', closeProjectModal);
btnCancel.addEventListener('click', closeProjectModal);
btnCancelDelete.addEventListener('click', closeDeleteModal);
projectForm.addEventListener('submit', handleSubmit);

// Cerrar modal al hacer click fuera
window.addEventListener('click', (e) => {
    if (e.target === projectModal) closeProjectModal();
    if (e.target === deleteModal) closeDeleteModal();
});

// ===== FUNCIONES =====

function loadProjects() {
    // Aquí iría la llamada al servidor para obtener proyectos
    // Por ahora usamos datos de ejemplo desde localStorage
    projects = JSON.parse(localStorage.getItem('projects')) || [
        {
            id: 1,
            name: 'Proyecto Demo',
            description: 'Este es un proyecto de demostración para el sistema',
            status: 'activo',
            ticketsCount: 5
        },
        {
            id: 2,
            name: 'Sistema de Tickets',
            description: 'Plataforma de gestión de tickets y proyectos',
            status: 'activo',
            ticketsCount: 12
        }
    ];
    
    renderProjects();
}

function renderProjects() {
    projectsGrid.innerHTML = '';
    
    if (projects.length === 0) {
        projectsGrid.innerHTML = `
            <div class="empty-state" style="grid-column: 1 / -1;">
                <h2>No hay proyectos</h2>
                <p>Crea tu primer proyecto para comenzar</p>
                <button class="btn-manage-projects" onclick="document.getElementById('btnNewProject').click()">Nuevo Proyecto</button>
            </div>
        `;
        return;
    }

    projects.forEach(project => {
        const projectCard = document.createElement('div');
        projectCard.className = 'project-item';
        projectCard.innerHTML = `
            <h3>${escapeHtml(project.name)}</h3>
            <p class="project-description">${escapeHtml(project.description) || 'Sin descripción'}</p>
            <div class="project-meta">
                <span class="project-status status-${project.status}">${capitalize(project.status)}</span>
                <span class="project-count">${project.ticketsCount || 0} tickets</span>
            </div>
            <div class="project-actions">
                <button class="btn-edit" onclick="openEditModal(${project.id})">Editar</button>
                <button class="btn-delete" onclick="openDeleteModal(${project.id})">Eliminar</button>
            </div>
        `;
        projectsGrid.appendChild(projectCard);
    });
}

function openAddModal() {
    editingId = null;
    modalTitle.textContent = 'Nuevo Proyecto';
    projectForm.reset();
    projectForm.querySelector('button[type="submit"]').textContent = 'Crear Proyecto';
    projectModal.classList.add('show');
}

function openEditModal(id) {
    const project = projects.find(p => p.id === id);
    if (!project) return;

    editingId = id;
    modalTitle.textContent = 'Editar Proyecto';
    document.getElementById('projectName').value = project.name;
    document.getElementById('projectDescription').value = project.description;
    document.getElementById('projectStatus').value = project.status;
    projectForm.querySelector('button[type="submit"]').textContent = 'Guardar Cambios';
    projectModal.classList.add('show');
}

function closeProjectModal() {
    projectModal.classList.remove('show');
    projectForm.reset();
    editingId = null;
}

function openDeleteModal(id) {
    editingId = id;
    deleteModal.classList.add('show');
}

function closeDeleteModal() {
    deleteModal.classList.remove('show');
    editingId = null;
}

function handleSubmit(e) {
    e.preventDefault();

    const name = document.getElementById('projectName').value.trim();
    const description = document.getElementById('projectDescription').value.trim();
    const status = document.getElementById('projectStatus').value;

    if (!name) {
        showError('El nombre del proyecto es requerido');
        return;
    }

    if (editingId === null) {
        // Crear nuevo proyecto
        const newProject = {
            id: Date.now(),
            name,
            description,
            status,
            ticketsCount: 0
        };
        projects.push(newProject);
        showSuccess('Proyecto creado correctamente');
    } else {
        // Editar proyecto
        const project = projects.find(p => p.id === editingId);
        if (project) {
            project.name = name;
            project.description = description;
            project.status = status;
            showSuccess('Proyecto actualizado correctamente');
        }
    }

    saveProjects();
    renderProjects();
    closeProjectModal();
}

function deleteProject() {
    projects = projects.filter(p => p.id !== editingId);
    saveProjects();
    renderProjects();
    closeDeleteModal();
    showSuccess('Proyecto eliminado correctamente');
}

btnConfirmDelete.addEventListener('click', deleteProject);

function saveProjects() {
    localStorage.setItem('projects', JSON.stringify(projects));
}

// ===== UTILIDADES =====

function escapeHtml(text) {
    if (!text) return '';
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

function capitalize(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function showSuccess(message) {
    console.log('✓', message);
    // Puedes usar SweetAlert2 aquí si lo tienes disponible
}

function showError(message) {
    console.error('✗', message);
    // Puedes usar SweetAlert2 aquí si lo tienes disponible
}
