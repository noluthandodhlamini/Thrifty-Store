<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include('includes/config.php');
include('includes/cart-helpers.php');
include('includes/product-helpers.php');

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$id = (int)$_GET['id'];

$sql = "SELECT p.*, u.fullname AS seller_name
        FROM products p
        JOIN users u ON p.user_id = u.user_id
        WHERE p.product_id = $id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header("Location: products.php");
    exit();
}

$category = (!empty($product['category'])) ? $product['category'] : 'General';
$productSize = !empty($product['size']) ? $product['size'] : 'One Size';
$imageSrc = getProductImageSrc($product['image'], $product['title']);
$reviewMessage = '';

if (isset($_POST['submit_review'])) {
    if (!isset($_SESSION['user_id'])) {
        $reviewMessage = 'error:Please log in to leave a review.';
    } else {
        $rating = (int)$_POST['rating'];
        $comment = mysqli_real_escape_string($conn, trim($_POST['comment']));
        $user_id = (int)$_SESSION['user_id'];

        if ($rating < 1 || $rating > 5) {
            $reviewMessage = 'error:Please select a rating between 1 and 5 stars.';
        } elseif ($comment === '') {
            $reviewMessage = 'error:Please write a review before submitting.';
        } else {
            $insert = mysqli_query($conn,
                "INSERT INTO reviews (product_id, user_id, rating, comment)
                 VALUES ($id, $user_id, $rating, '$comment')");

            if ($insert) {
                header("Location: product-details.php?id=$id&reviewed=1");
                exit();
            }
            $reviewMessage = 'error:Could not submit review. Please try again.';
        }
    }
}

$reviewsResult = mysqli_query($conn,
    "SELECT r.*, u.fullname
     FROM reviews r
     JOIN users u ON r.user_id = u.user_id
     WHERE r.product_id = $id
     ORDER BY r.created_at DESC");

$reviews = [];
while ($row = mysqli_fetch_assoc($reviewsResult)) {
    $reviews[] = $row;
}

include('includes/header.php');
?>

<div class="product-detail-page">

    <div class="container py-4">
        <div class="product-detail-grid">

            <div class="product-detail-image">
                <img src="<?php echo htmlspecialchars($imageSrc); ?>"
                     alt="<?php echo htmlspecialchars($product['title']); ?>">
            </div>

            <div class="product-detail-info">
                <h1 class="product-detail-title">
                    <?php echo htmlspecialchars(strtoupper($product['title'])); ?>
                </h1>

                <p class="product-detail-price">
                    R<?php echo number_format($product['price'], 2); ?>
                </p>

                <p class="product-detail-category">
                    Category: <?php echo htmlspecialchars(strtolower($category)); ?>
                </p>

                <p class="product-detail-description">
                    <?php echo htmlspecialchars($product['description']); ?>
                </p>

                <div class="seller-info-box">
                    <h3>Seller Information</h3>
                    <p>Seller: <?php echo htmlspecialchars($product['seller_name']); ?></p>
                </div>

                <div class="product-detail-actions">
                    <form action="add-to-cart.php" method="GET" class="product-qty-form" id="addToCartForm">
                        <input type="hidden" name="id" value="<?php echo $product['product_id']; ?>">
                        <input type="hidden" name="redirect" value="product-details.php?id=<?php echo $product['product_id']; ?>">

                        <div class="product-detail-size">
                            <label for="size">Size:</label>
                            <select id="size" name="size" class="size-select">
                                <option value="<?php echo htmlspecialchars($productSize); ?>" selected>
                                    <?php echo htmlspecialchars($productSize); ?>
                                </option>
                            </select>
                        </div>

                        <label for="qty">Quantity:</label>
                        <input type="number"
                               id="qty"
                               name="qty"
                               value="1"
                               min="1"
                               max="<?php echo CART_LIMIT; ?>"
                               class="qty-input">

                        <button type="submit" class="btn-product-action">Add to Cart</button>
                    </form>

                    <button type="button"
                            class="btn btn-success btn-lg"
                            id="buyNowBtn">
                        Buy Now
                    </button>

                    <button type="button"
                            class="btn btn-outline-primary btn-lg"
                            onclick="window.location.href='contact-seller.php?id=<?php echo $product['user_id']; ?>'">
                        Message Seller
                    </button>
                </div>
            </div>

        </div>

        <section class="product-reviews-section">
            <h2>Customer Reviews</h2>

            <?php if (isset($_GET['reviewed'])): ?>
                <div class="alert alert-success">Thank you! Your review has been submitted.</div>
            <?php endif; ?>

            <?php if ($reviewMessage): ?>
                <?php
                list($type, $text) = explode(':', $reviewMessage, 2);
                ?>
                <div class="alert alert-<?php echo $type === 'error' ? 'danger' : 'success'; ?>">
                    <?php echo htmlspecialchars($text); ?>
                </div>
            <?php endif; ?>

            <div class="review-form-card">
                <h3>Write a Review</h3>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <form method="POST" class="review-form">
                        <div class="star-rating">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" name="rating" id="star<?php echo $i; ?>" value="<?php echo $i; ?>" <?php echo $i === 5 ? 'checked' : ''; ?>>
                                <label for="star<?php echo $i; ?>">★</label>
                            <?php endfor; ?>
                        </div>

                        <textarea name="comment"
                                  class="review-textarea"
                                  placeholder="Share your experience..."
                                  required></textarea>

                        <button type="submit" name="submit_review" class="btn-product-action">
                            Submit Review
                        </button>
                    </form>
                <?php else: ?>
                    <p class="text-muted mb-3">
                        <a href="login.php">Log in</a> to write a review.
                    </p>
                <?php endif; ?>
            </div>

            <div class="reviews-list">
                <?php if (count($reviews) === 0): ?>
                    <p class="no-reviews">No reviews yet. Be the first!</p>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-item">
                            <div class="review-stars">
                                <?php echo str_repeat('★', (int)$review['rating']); ?>
                                <?php echo str_repeat('☆', 5 - (int)$review['rating']); ?>
                            </div>
                            <p class="review-author"><?php echo htmlspecialchars($review['fullname']); ?></p>
                            <p class="review-text"><?php echo htmlspecialchars($review['comment']); ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>

</div>

<script>
document.getElementById('buyNowBtn').addEventListener('click', function() {
    var qty = document.getElementById('qty').value;
    var size = document.getElementById('size').value;
    window.location.href = 'buy-now.php?id=<?php echo $product['product_id']; ?>&qty='
        + encodeURIComponent(qty)
        + '&size='
        + encodeURIComponent(size);
});
</script>

<?php include('includes/footer.php'); ?>
