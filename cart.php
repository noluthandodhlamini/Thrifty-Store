<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('includes/config.php');
include('includes/cart-helpers.php');

$cartData = getCartItems($conn);
$items = $cartData['items'];
$total = $cartData['total'];
$cartCount = getCartCount();
$message = getCartMessage();

require_once 'includes/product-helpers.php';
include('includes/header.php');
?>

<div class="container cart-page py-4">

    <div class="cart-header">
        <div>
            <h1 class="cart-title">Shopping Cart</h1>
            <p class="cart-subtitle">
                <?php echo $cartCount; ?> of <?php echo CART_LIMIT; ?> items
            </p>
        </div>
        <a href="products.php" class="btn btn-outline-dark">Continue Shopping</a>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo htmlspecialchars($message['type']); ?>">
            <?php echo htmlspecialchars($message['text']); ?>
        </div>
    <?php endif; ?>

    <?php if ($cartCount >= CART_LIMIT): ?>
        <div class="alert alert-warning">
            Your cart is full. Remove an item before adding more (max <?php echo CART_LIMIT; ?> items).
        </div>
    <?php endif; ?>

    <?php if (count($items) > 0): ?>

        <div class="row g-4">
            <div class="col-lg-8">
                <?php foreach ($items as $row): ?>
                    <div class="cart-item-card">
                        <div class="cart-item-image">
                            <img src="<?php echo htmlspecialchars(getProductImageSrc($row['image'], $row['title'])); ?>"
                                 alt="<?php echo htmlspecialchars($row['title']); ?>">
                        </div>
                        <div class="cart-item-details">
                            <h5><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="text-muted mb-1">Size: <?php echo htmlspecialchars($row['selected_size'] ?? 'One Size'); ?></p>
                            <p class="text-muted mb-2">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </p>
                            <p class="cart-item-price mb-0">R<?php echo number_format($row['price'], 2); ?></p>
                        </div>
                        <div class="cart-item-actions">
                            <a href="remove-cart.php?id=<?php echo $row['product_id']; ?>"
                               class="btn btn-outline-danger btn-sm">
                                Remove
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="col-lg-4">
                <div class="cart-summary-card">
                    <h3>Order Summary</h3>

                    <div class="summary-row">
                        <span>Items (<?php echo count($items); ?>)</span>
                        <span>R<?php echo number_format($total, 2); ?></span>
                    </div>

                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span>R<?php echo number_format($total, 2); ?></span>
                    </div>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="checkout.php" class="btn btn-success w-100 mt-3">
                            Proceed to Checkout
                        </a>
                    <?php else: ?>
                        <p class="text-muted small mt-3 mb-2">Please log in to complete your purchase.</p>
                        <a href="login.php" class="btn btn-primary w-100">Login to Checkout</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php else: ?>

        <div class="cart-empty-state">
            <p>Your cart is empty.</p>
            <a href="products.php" class="btn btn-primary">Browse Products</a>
        </div>

    <?php endif; ?>

</div>

<?php include('includes/footer.php'); ?>
