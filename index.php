<?php
require_once __DIR__ . '/middleware/auth.php';
require_once __DIR__ . '/helpers/Avatar.php';
include __DIR__ . '/includes/themeSwitch.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inicio</title>
<link rel="stylesheet" href="/css/auth/auth-common.css">
<link rel="stylesheet" href="/css/index.css">
<link rel="stylesheet" href="/css/includes/modules.css">
</head>
<body>

<!-- SIDEBAR / Módulos -->
<aside class="modules-sidebar" id="modulesSidebar">
    <?php include __DIR__ . '/includes/modules.php'; ?>
</aside>

<!-- HEADER SUPERIOR -->
<header class="dashboard-header">
    <button class="menu-btn" id="menuBtn">&#9776;</button>
    <div class="header-right">
        <a href="" class="avatar-link">
            <img src="<?php echo htmlspecialchars(Avatar::get_avatar_url()); ?>" alt="Avatar de <?php echo htmlspecialchars($_SESSION['username']); ?>" style="width: 40px; height: 40px; border-radius: 50%;">
        </a>
        <a href="/handlers/auth/logout_handler.php" class="logout-btn">Cerrar Sesión</a>
    </div>
</header>

<!-- CONTENIDO PRINCIPAL -->
<main class="main-content">
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>Selecciona un módulo desde el menú.</p>
</main>

<script src="/js/utils/toggle_theme.js"></script>
<script>
    const menuBtn = document.getElementById('menuBtn');
    const sidebar = document.getElementById('modulesSidebar');

    menuBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });
</script>
</body>
</html>
