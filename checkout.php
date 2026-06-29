<?php

include('includes/config.php');
include('includes/auth.php');
include('includes/cart-helpers.php');

$cartData = getCartItems($conn);
$items = $cartData['items'];
$total = $cartData['total'];

if (count($items) === 0) {
    setCartMessage('info', 'Your cart is empty. Add items before checking out.');
    header("Location: cart.php");
    exit();
}

$error = '';

if (isset($_POST['place_order'])) {
    $buyer_id = (int)$_SESSION['user_id'];
    $success = true;

    foreach ($items as $item) {
        $product_id = (int)$item['product_id'];
        $amount = (float)$item['price'];

        $insert = mysqli_query($conn,
            "INSERT INTO orders (buyer_id, product_id, amount)
             VALUES ($buyer_id, $product_id, $amount)");

        if (!$insert) {
            $success = false;
            break;
        }
    }

    if ($success) {
        $_SESSION['last_order_total'] = $total;
        $_SESSION['last_order_count'] = count($items);
        $_SESSION['cart'] = [];

        header("Location: order-success.php");
        exit();
    }

    $error = 'Checkout failed. Please try again.';
}

include('includes/header.php');
?>

<div class="container cart-page py-4">

    <div class="cart-header mb-4">
        <div>
            <h1 class="cart-title">Checkout</h1>
            <p class="cart-subtitle">Review your order before placing it</p>
        </div>
        <a href="cart.php" class="btn btn-outline-dark">Back to Cart</a>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="cart-summary-card">
                <h3>Your Items</h3>

                <?php foreach ($items as $row): ?>
                    <div class="checkout-item">
                        <div>
                            <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                            <p class="text-muted small mb-0">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </p>
                        </div>
                        <span class="cart-item-price">R<?php echo number_format($row['price'], 2); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="cart-summary-card">
                <h3>Payment Summary</h3>

                <div class="summary-row">
                    <span>Items (<?php echo count($items); ?>)</span>
                    <span>R<?php echo number_format($total, 2); ?></span>
                </div>

                <div class="summary-row summary-total">
                    <span>Total Due</span>
                    <span>R<?php echo number_format($total, 2); ?></span>
                </div>

                <p class="text-muted small mt-3">
                    By placing this order, you agree to contact the seller to arrange payment and delivery.
                </p>

                <form method="POST">
                    <button type="submit" name="place_order" class="btn btn-success w-100 mt-2">
                        Place Order
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include('includes/footer.php'); ?>
