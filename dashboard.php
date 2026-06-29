<?php

include('includes/config.php');
include('includes/cart-helpers.php');
include('includes/auth.php');

$user_id = (int)$_SESSION['user_id'];
$fullname = htmlspecialchars($_SESSION['fullname'] ?? 'User');
$role = ucfirst($_SESSION['role'] ?? 'buyer');

$listingsResult = mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM products WHERE user_id=$user_id");
$listingsData = mysqli_fetch_assoc($listingsResult);
$listingCount = (int)$listingsData['total'];

$cartCount = getCartCount();

include('includes/header.php');
?>

<div class="container dashboard-page py-4">

    <div class="dashboard-hero">
        <div>
            <p class="dashboard-eyebrow">Account Overview</p>
            <h1 class="dashboard-title">Welcome back, <?php echo $fullname; ?></h1>
            <p class="dashboard-subtitle">
                Manage your listings, track your activity, and keep shopping on Thrifty Store.
            </p>
        </div>
        <span class="dashboard-role-badge"><?php echo $role; ?></span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="dashboard-stat-card">
                <span class="stat-label">Active Listings</span>
                <span class="stat-value"><?php echo $listingCount; ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-stat-card">
                <span class="stat-label">Items in Cart</span>
                <span class="stat-value"><?php echo $cartCount; ?>/<?php echo CART_LIMIT; ?></span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-stat-card">
                <span class="stat-label">Account Type</span>
                <span class="stat-value stat-value-sm"><?php echo $role; ?></span>
            </div>
        </div>
    </div>

    <h2 class="dashboard-section-title">Quick Actions</h2>

    <div class="row g-3">
        <div class="col-md-6 col-lg-3">
             <a href="sell-item.php" class="action-button">
                <span class="action-icon">📦</span>
                <span class="action-title">Sell Item</span>
                <span class="action-desc">List a new product for sale</span>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="my-listings.php" class="action-button">
                <span class="action-icon">📋</span>
                <span class="action-title">My Listings</span>
                <span class="action-desc">View and manage your items</span>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="cart.php" class="action-button">
                <span class="action-icon">🛒</span>
                <span class="action-title">Shopping Cart</span>
                <span class="action-desc">Review items ready to buy</span>
            </a>
        </div>
        <div class="col-md-6 col-lg-3">
            <a href="edit-protect.php" class="action-button">
                <span class="action-icon">👤</span>
                <span class="action-title">Edit Profile</span>
                <span class="action-desc">Update your account details</span>
            </a>
        </div>
    </div>

    <div class="dashboard-footer-actions mt-4">
        <a href="products.php" class="btn btn-outline-dark">Browse Marketplace</a>
        <a href="logout.php" class="btn btn-link text-danger text-decoration-none">Sign Out</a>
    </div>

</div>

<?php include('includes/footer.php'); ?>
