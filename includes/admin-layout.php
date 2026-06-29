<?php

function admin_require_login()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['admin'])) {
        header('Location: login.php');
        exit();
    }
}

function admin_nav_items()
{
    return [
        'dashboard' => ['label' => 'Dashboard', 'icon' => '📊', 'href' => 'dashboard.php'],
        'users' => ['label' => 'Users', 'icon' => '👥', 'href' => 'users.php'],
        'products' => ['label' => 'Products', 'icon' => '👕', 'href' => 'products.php'],
        'orders' => ['label' => 'Orders', 'icon' => '📦', 'href' => 'orders.php'],
        'reports' => ['label' => 'Reports', 'icon' => '📈', 'href' => 'reports.php'],
    ];
}

function admin_header($pageTitle, $pageSubtitle = '', $activePage = 'dashboard')
{
    require_once __DIR__ . '/paths.php';

    $adminEmail = htmlspecialchars($_SESSION['admin'] ?? 'Admin');
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | Thrifty Store Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo asset_url('assets/css/admin.css'); ?>?v=<?php echo CSS_VERSION; ?>">
</head>
<body class="admin-body">

<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-brand">
            <span class="admin-brand-mark">TS</span>
            <div>
                <strong>Thrifty Store</strong>
                <small>Admin Portal</small>
            </div>
        </div>

        <nav class="admin-nav">
            <?php foreach (admin_nav_items() as $key => $item): ?>
                <a href="<?php echo $item['href']; ?>"
                   class="admin-nav-link<?php echo $activePage === $key ? ' active' : ''; ?>">
                    <span class="admin-nav-icon"><?php echo $item['icon']; ?></span>
                    <?php echo $item['label']; ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="admin-sidebar-footer">
            <a href="<?php echo site_url('index.php'); ?>" class="admin-nav-link admin-nav-link-muted">
                <span class="admin-nav-icon">🏠</span>
                View Storefront
            </a>
            <a href="logout.php" class="admin-nav-link admin-nav-link-danger">
                <span class="admin-nav-icon">⎋</span>
                Logout
            </a>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <button type="button" class="admin-menu-toggle" id="adminMenuToggle" aria-label="Toggle menu">
                ☰
            </button>

            <div class="admin-topbar-copy">
                <h1><?php echo htmlspecialchars($pageTitle); ?></h1>
                <?php if ($pageSubtitle !== ''): ?>
                    <p><?php echo htmlspecialchars($pageSubtitle); ?></p>
                <?php endif; ?>
            </div>

            <div class="admin-user-chip">
                <span class="admin-user-avatar">A</span>
                <div>
                    <strong>Administrator</strong>
                    <small><?php echo $adminEmail; ?></small>
                </div>
            </div>
        </header>

        <main class="admin-content">
    <?php
}

function admin_footer()
{
    ?>
        </main>
    </div>
</div>

<script>
document.getElementById('adminMenuToggle')?.addEventListener('click', function () {
    document.getElementById('adminSidebar')?.classList.toggle('open');
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
    <?php
}

function admin_role_badge($role)
{
    $role = strtolower(trim($role));
    $class = 'admin-badge-buyer';

    if ($role === 'seller') {
        $class = 'admin-badge-seller';
    } elseif ($role === 'admin') {
        $class = 'admin-badge-admin';
    }

    return '<span class="admin-badge ' . $class . '">' . htmlspecialchars(ucfirst($role)) . '</span>';
}

function admin_stat_card($label, $value, $icon, $accent = 'blue')
{
    ?>
    <div class="col-md-4 col-sm-6">
        <article class="admin-stat-card admin-stat-<?php echo htmlspecialchars($accent); ?>">
            <div class="admin-stat-icon"><?php echo $icon; ?></div>
            <div>
                <span class="admin-stat-label"><?php echo htmlspecialchars($label); ?></span>
                <strong class="admin-stat-value"><?php echo htmlspecialchars((string)$value); ?></strong>
            </div>
        </article>
    </div>
    <?php
}
