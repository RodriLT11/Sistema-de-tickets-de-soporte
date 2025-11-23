<style>
.dashboard-header {
    display: flex;
    align-items: center;
    justify-content: space-between; /* izquierda - centro - derecha */
    padding: 10px 20px;
    background: var(--card-bg);
    border-bottom: 1px solid #ccc;
}

/* El centro debe ocupar espacio y alinear su contenido */
.header-center {
    flex: 1;
    text-align: center;
}

.menu-btn {
    font-size: 22px;
    background: none;
    border: none;
    cursor: pointer;
    color: var(--text);
}

.logout-btn {
    color: var(--text);
    text-decoration: none;
    font-weight: bold;
}

.user-name {
    font-weight: bold;
    color: var(--text);
}
</style>
<!-- HEADER SUPERIOR -->
<header class="dashboard-header">
    <button class="menu-btn" id="menuBtn">&#9776;</button>

    <div class="header-center">
        <span class="user-name">
            <?php echo htmlspecialchars($_SESSION['username']); ?>
        </span>
    </div>

    <a href="/handlers/auth/logout_handler.php" class="logout-btn">Cerrar Sesión</a>
</header>

