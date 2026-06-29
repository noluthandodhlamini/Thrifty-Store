<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<?php
if (!function_exists('asset_url')) {
    require_once __DIR__ . '/paths.php';
}
if (!defined('CART_LIMIT')) { require_once __DIR__ . '/cart-helpers.php'; }
?>
<!DOCTYPE html>
<html>
<head>
<title>Thrifty Store</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="<?php echo asset_url('assets/css/style.css'); ?>?v=<?php echo CSS_VERSION; ?>">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo site_url('index.php'); ?>">Thrifty Store</a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <form class="d-flex ms-auto me-3" action="<?php echo site_url('products.php'); ?>" method="GET">
                <input class="form-control me-2"
                       type="search"
                       name="search"
                       placeholder="Search products">
            </form>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('index.php'); ?>">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('products.php'); ?>">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('sell-item.php'); ?>">Sell Item</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('cart.php'); ?>">
                        🛒 Cart
                        <?php
                        $navCartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                        if ($navCartCount > 0):
                        ?>
                            <span class="badge bg-success"><?php echo $navCartCount; ?>/<?php echo defined('CART_LIMIT') ? CART_LIMIT : 5; ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('dashboard.php'); ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('logout.php'); ?>">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('login.php'); ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('register.php'); ?>">Register</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('admin/login.php'); ?>">Admin Panel</a>
                </li>
            </ul>

        </div>
    </div>
</nav>
