<?php

include('includes/config.php');
include('includes/auth.php');

$orderCount = $_SESSION['last_order_count'] ?? 0;
$orderTotal = $_SESSION['last_order_total'] ?? 0;

if ($orderCount === 0) {
    header("Location: cart.php");
    exit();
}

unset($_SESSION['last_order_count'], $_SESSION['last_order_total']);

include('includes/header.php');
?>

<div class="container cart-page py-5">
    <div class="order-success-card text-center">
        <div class="success-icon">✓</div>
        <h1>Order Placed Successfully</h1>
        <p class="text-muted">
            You ordered <?php echo (int)$orderCount; ?> item(s) for a total of
            <strong>R<?php echo number_format($orderTotal, 2); ?></strong>.
        </p>
        <p class="text-muted">
            The seller will contact you to arrange payment and delivery.
        </p>

        <div class="d-flex gap-2 justify-content-center flex-wrap mt-4">
            <a href="products.php" class="btn btn-primary">Continue Shopping</a>
            <a href="dashboard.php" class="btn btn-outline-dark">Go to Dashboard</a>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
