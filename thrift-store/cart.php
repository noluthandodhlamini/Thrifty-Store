<?php
session_start();

include('admin/config.php');
include('includes/header.php');
?>

<div class="container mt-4">
<h2>Shopping Cart</h2>

<?php

if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {

    foreach ($_SESSION['cart'] as $id) {

        $query = mysqli_query($conn,
            "SELECT * FROM products WHERE product_id='$id'");

        $row = mysqli_fetch_assoc($query);

        if ($row) {
?>

<div class="card mb-3">
    <div class="card-body">

        <h5><?php echo $row['title']; ?></h5>

        <p>R<?php echo $row['price']; ?></p>

        <a href="remove-cart.php?id=<?php echo $row['product_id']; ?>"
           class="btn btn-danger">
            Remove
        </a>

    </div>
</div>

<?php
        }
    }

} else {

    echo "<p>Your cart is empty.</p>";

}

?>

</div>

<?php include('includes/footer.php'); ?>