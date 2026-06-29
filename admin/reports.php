<?php

include('../includes/config.php');
include('../includes/admin-layout.php');

admin_require_login();

$totalUsers = mysqli_num_rows(mysqli_query($conn, 'SELECT * FROM users'));
$totalProducts = mysqli_num_rows(mysqli_query($conn, 'SELECT * FROM products'));
$totalOrders = mysqli_num_rows(mysqli_query($conn, 'SELECT * FROM orders'));

admin_header('Reports', 'Platform overview and activity summary', 'reports');
?>

<div class="row g-4">
    <?php admin_stat_card('Total Users', $totalUsers, '👥', 'blue'); ?>
    <?php admin_stat_card('Total Products', $totalProducts, '👕', 'green'); ?>
    <?php admin_stat_card('Total Orders', $totalOrders, '📦', 'amber'); ?>
</div>

<section class="admin-panel mt-4">
    <div class="admin-panel-header">
        <h2>Summary</h2>
    </div>
    <div class="admin-panel-body">
        <div class="p-4">
            <p class="mb-2"><strong>Users:</strong> <?php echo $totalUsers; ?> registered accounts</p>
            <p class="mb-2"><strong>Products:</strong> <?php echo $totalProducts; ?> active listings</p>
            <p class="mb-0"><strong>Orders:</strong> <?php echo $totalOrders; ?> completed purchases</p>
        </div>
    </div>
</section>

<?php admin_footer(); ?>
