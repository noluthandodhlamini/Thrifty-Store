<?php

include('admin/config.php');
include('includes/header.php');


if (!isset($_GET['id'])) {
    die("No product selected.");
}

$id = $_GET['id'];

// Get the product from the database
$sql = "SELECT * FROM products WHERE product_id = '$id'";
$result = mysqli_query($conn, $sql);

// Check if query returned a product
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die("Product not found.");
}

?>

<div class="card-body">

    <h3><?php echo $product['title']; ?></h3>

    <p>
        <?php echo $product['description']; ?>
    </p>

    <h4>R<?php echo $product['price']; ?></h4>

    <br>

    <a href="add-to-cart.php?id=<?php echo $product['product_id']; ?>"
       class="btn btn-success">
       Add to Cart
    </a>

    <a href="contact-seller.php?id=<?php echo $product['user_id']; ?>"
       class="btn btn-primary">
       Contact Seller
    </a>

    <a href="products.php"
       class="btn btn-secondary">
       Back to Products
    </a>

</div>


<?php include('includes/footer.php'); ?>