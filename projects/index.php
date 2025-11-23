<?php
require_once __DIR__ . '/../middleware/auth.php';
include __DIR__ . '/../includes/themeSwitch.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
    <link rel="stylesheet" href="/css/auth/auth-common.css">
    <link rel="stylesheet" href="/css/includes/modules.css">
    <link rel="stylesheet" href="/css/projects/index.css">
</head>
<body>

<!-- SIDEBAR / Módulos -->
<aside class="modules-sidebar" id="modulesSidebar">
    <?php include __DIR__ . '/../includes/modules.php'; ?>
</aside>

<!-- HEADER SUPERIOR -->
<header class="dashboard-header">
    <button class="menu-btn" id="menuBtn">&#9776;</button>
    <div class="header-right">
        <a href="/handlers/auth/logout_handler.php" class="logout-btn">Cerrar Sesión</a>
    </div>
</header>

<!-- CONTENIDO PRINCIPAL -->
<main class="main-content">
    <div class="projects-header">
        <h1>Proyectos</h1>
        <button class="btn-manage-projects" id="btnNewProject">+ Nuevo Proyecto</button>
    </div>

    <div class="projects-grid" id="projectsGrid">
        <!-- Los proyectos se cargarán aquí con JavaScript -->
    </div>
</main>

<!-- MODAL CREAR/EDITAR PROYECTO -->
<div class="modal" id="projectModal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2 id="modalTitle">Nuevo Proyecto</h2>
        
        <form id="projectForm">
            <div class="form-group">
                <label for="projectName">Nombre del Proyecto</label>
                <input type="text" id="projectName" name="name" required>
            </div>

            <div class="form-group">
                <label for="projectDescription">Descripción</label>
                <textarea id="projectDescription" name="description" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="projectStatus">Estado</label>
                <select id="projectStatus" name="status">
                    <option value="activo">Activo</option>
                    <option value="pausado">Pausado</option>
                    <option value="completado">Completado</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Guardar Proyecto</button>
                <button type="button" class="btn-cancel" id="btnCancel">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL CONFIRMAR ELIMINACIÓN -->
<div class="modal" id="deleteModal">
    <div class="modal-content modal-small">
        <h2>Confirmar eliminación</h2>
        <p>¿Estás seguro de que deseas eliminar este proyecto?</p>
        <div class="form-actions">
            <button type="button" class="btn-submit btn-danger" id="btnConfirmDelete">Eliminar</button>
            <button type="button" class="btn-cancel" id="btnCancelDelete">Cancelar</button>
        </div>
    </div>
</div>

<script src="/js/utils/toggle_theme.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/js/utils/alerts_sweetalert.js"></script>
<script src="/js/projects/index.js"></script>

<script>
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('modulesSidebar');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });
</script>

</body>
</html>
