// Variables globales
let projects = [];
let editingId = null;

// DOM Elements
const btnNewProject = document.getElementById('btnNewProject');
const projectModal = document.getElementById('projectModal');
const deleteModal = document.getElementById('deleteModal');
const addUserModal = document.getElementById('addUserModal');
const closeModal = document.getElementById('closeModal');
const closeAddUserModal = document.getElementById('closeAddUserModal');
const btnCancel = document.getElementById('btnCancel');
const btnCancelAddUser = document.getElementById('btnCancelAddUser');
const projectForm = document.getElementById('projectForm');
const addUserForm = document.getElementById('addUserForm');
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
closeAddUserModal.addEventListener('click', closeAddUserModalFunc);
btnCancel.addEventListener('click', closeProjectModal);
btnCancelAddUser.addEventListener('click', closeAddUserModalFunc);
btnCancelDelete.addEventListener('click', closeDeleteModal);
projectForm.addEventListener('submit', handleSubmit);
addUserForm.addEventListener('submit', handleAddUserSubmit);

// Cerrar modal al hacer click fuera
window.addEventListener('click', (e) => {
    if (e.target === projectModal) closeProjectModal();
    if (e.target === deleteModal) closeDeleteModal();
});

// ===== FUNCIONES =====

function loadProjects() {
    // Llamada al servidor para obtener proyectos del usuario autenticado
    fetch('/handlers/modules/projects/get_user_projects.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                projects = data.projects;
                renderProjects();
            } else {
                showError('Error al cargar proyectos');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error de conexión');
        });
}
function renderProjects() {
    projectsGrid.innerHTML = '';
    
    if (projects.length === 0) {
        projectsGrid.innerHTML = `
            <div class="empty-state" style="grid-column: 1 / -1;">
                <h2>No hay proyectos</h2>
                <p>Crea tu primer proyecto para comenzar</p>
                ${IS_ADMIN ? '<button class="btn-manage-projects" onclick="document.getElementById(\'btnNewProject\').click()">Nuevo Proyecto</button>' : ''}
            </div>
        `;
        return;
    }

    projects.forEach(project => {
        const projectCard = document.createElement('div');
        projectCard.className = 'project-item';
        const createdDate = new Date(project.created_at).toLocaleDateString('es-ES');
        projectCard.innerHTML = `
            <h3>${escapeHtml(project.name)}</h3>
            <p class="project-description">${escapeHtml(project.description) || 'Sin descripción'}</p>
            <div class="project-meta">
                <span class="project-count">Creado: ${createdDate}</span>
            </div>
            <div class="project-actions">
                ${IS_ADMIN ? `<button class="btn-edit" onclick="openEditModal(${project.id})">Editar</button>` : ''}
                ${IS_ADMIN ? `<button class="btn-add-user" onclick="openAddUserModal(${project.id})">+ Usuario</button>` : ''}
                ${IS_ADMIN ? `<button class="btn-delete" onclick="openDeleteModal(${project.id})">Eliminar</button>` : ''}
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

function openAddUserModal(projectId) {
    editingId = projectId;
    addUserModal.classList.add('show');
    loadAvailableUsers(projectId);
}

function closeAddUserModalFunc() {
    addUserModal.classList.remove('show');
    addUserForm.reset();
    editingId = null;
}

function loadAvailableUsers(projectId) {
    fetch('/handlers/modules/projects/get_available_users.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ project_id: projectId })
    })
    .then(response => response.json())
    .then(data => {
        const userSelect = document.getElementById('userSelect');
        userSelect.innerHTML = '<option value="">-- Selecciona un usuario --</option>';
        
        if (data.success && data.users.length > 0) {
            data.users.forEach(user => {
                const option = document.createElement('option');
                option.value = user.id;
                option.textContent = `${user.username} (${user.email})`;
                userSelect.appendChild(option);
            });
        } else {
            userSelect.innerHTML = '<option value="">No hay usuarios disponibles</option>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('Error al cargar usuarios');
    });
}

function handleAddUserSubmit(e) {
    e.preventDefault();

    const userId = document.getElementById('userSelect').value;
    const roleId = document.getElementById('roleSelect').value;

    if (!userId || !roleId) {
        showError('Debes seleccionar un usuario y un rol');
        return;
    }

    fetch('/handlers/modules/projects/add_user_to_project.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ project_id: editingId, user_id: userId, role_id: roleId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Usuario agregado al proyecto');
            closeAddUserModalFunc();
        } else {
            showError(data.message || 'Error al agregar usuario');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('Error de conexión');
    });
}

function handleSubmit(e) {
    e.preventDefault();

    const name = document.getElementById('projectName').value.trim();
    const description = document.getElementById('projectDescription').value.trim();

    if (!name) {
        showError('El nombre del proyecto es requerido');
        return;
    }

    if (editingId === null) {
        // Crear nuevo proyecto
        fetch('/handlers/modules/projects/create_project.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ name, description })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess('Proyecto creado correctamente');
                loadProjects();
                closeProjectModal();
            } else {
                showError(data.message || 'Error al crear proyecto');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error de conexión');
        });
    } else {
        // Editar proyecto
        fetch('/handlers/modules/projects/update_project.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: editingId, name, description })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess('Proyecto actualizado correctamente');
                loadProjects();
                closeProjectModal();
            } else {
                showError(data.message || 'Error al actualizar proyecto');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error de conexión');
        });
    }
}

function deleteProject() {
    fetch('/handlers/modules/projects/delete_project.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: editingId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('Proyecto eliminado correctamente');
            loadProjects();
            closeDeleteModal();
        } else {
            showError(data.message || 'Error al eliminar proyecto');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('Error de conexión');
    });
}

btnConfirmDelete.addEventListener('click', deleteProject);

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
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: message,
        confirmButtonText: 'Aceptar',
        timer: 3000,
        timerProgressBar: true
    });
}

function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: message,
        confirmButtonText: 'Aceptar'
    });
}
