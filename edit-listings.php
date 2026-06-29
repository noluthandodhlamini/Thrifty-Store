<?php
include('includes/config.php');
include('includes/auth.php');

$user_id = $_SESSION['user_id'];
$product_id = $_GET['id'] ?? 0;

$product_id = mysqli_real_escape_string($conn, $product_id);

$result = mysqli_query($conn, "
    SELECT * FROM products
    WHERE product_id = '$product_id'
    AND user_id = '$user_id'
");

$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found.";
    exit();
}

if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $price = (float) $_POST['price'];

    mysqli_query($conn, "
        UPDATE products
        SET title = '$title',
            price = '$price'
        WHERE product_id = '$product_id'
        AND user_id = '$user_id'
    ");

    header("Location: my-listings.php");
    exit();
}

include('includes/header.php');
?>

<div class="edit-page">
  <div class="edit-card">
    <div class="edit-header">
      <p class="eyebrow">Seller Dashboard</p>
      <h1>Edit Listing</h1>
    </div>

    <form method="POST" class="edit-form">
      <div class="form-group">
        <label for="title">Product Title</label>
        <input
          type="text"
          id="title"
          name="title"
          value="<?php echo htmlspecialchars($product['title']); ?>"
          required
        >
      </div>

      <div class="form-group">
        <label for="price">Price</label>
        <input
          type="number"
          id="price"
          name="price"
          min="0"
          step="0.01"
          value="<?php echo htmlspecialchars($product['price']); ?>"
          required
        >
      </div>

      <div class="form-actions">
        <button type="button" class="btn-secondary" onclick="window.location.href='my-listings.php'">
          Cancel
        </button>

        <button type="submit" name="update" class="btn-primary">
          Save Changes
        </button>
      </div>
    </form>
  </div>
</div>

<?php include('includes/footer.php'); ?>