<?php

include('../includes/config.php');
include('../includes/admin-layout.php');

admin_require_login();

$userQuery = 'SELECT COUNT(*) AS totalUsers FROM users';
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$totalUsers = $userData['totalUsers'];

$productQuery = 'SELECT COUNT(*) AS totalProducts FROM products';
$productResult = mysqli_query($conn, $productQuery);
$productData = mysqli_fetch_assoc($productResult);
$totalProducts = $productData['totalProducts'];

$orderQuery = 'SELECT COUNT(*) AS totalOrders FROM orders';
$orderResult = mysqli_query($conn, $orderQuery);
$orderData = mysqli_fetch_assoc($orderResult);
$totalOrders = $orderData['totalOrders'] ?? 0;

admin_header('Admin Dashboard', 'Welcome back, Admin', 'dashboard');
?>

<div class="row g-4 mb-4">
    <?php admin_stat_card('Total Users', $totalUsers, '👥', 'blue'); ?>
    <?php admin_stat_card('Active Listings', $totalProducts, '👕', 'green'); ?>
    <?php admin_stat_card('Total Orders', $totalOrders, '📦', 'purple'); ?>
</div>

<section class="admin-panel">
    <div class="admin-panel-header">
        <h2>Recent Users</h2>
    </div>
    <div class="admin-panel-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = 'SELECT * FROM users ORDER BY user_id DESC LIMIT 5';
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . (int)$row['user_id'] . '</td>';
                        echo '<td>' . htmlspecialchars($row['fullname'] ?? 'N/A') . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . admin_role_badge($row['role']) . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php admin_footer(); ?>
