<?php



if (session_status() === PHP_SESSION_NONE) {

    session_start();

}



include('includes/config.php');

include('includes/cart-helpers.php');



if (!isset($_GET['id'])) {

    header("Location: products.php");

    exit();

}



$id = (int)$_GET['id'];

$qty = isset($_GET['qty']) ? max(1, min(CART_LIMIT, (int)$_GET['qty'])) : 1;

$size = trim($_GET['size'] ?? 'One Size');



$result = mysqli_query($conn, "SELECT product_id FROM products WHERE product_id=$id");



if (mysqli_num_rows($result) === 0) {

    setCartMessage('danger', 'Product not found.');

    header("Location: products.php");

    exit();

}



$_SESSION['cart'] = [];

addToCartSession($id, $size, $qty);



if (!isset($_SESSION['user_id'])) {

    setCartMessage('info', 'Please log in to complete your purchase.');

    header("Location: login.php");

    exit();

}



header("Location: checkout.php");

exit();


