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

$qty = isset($_GET['qty']) ? max(1, (int)$_GET['qty']) : 1;

$size = trim($_GET['size'] ?? 'One Size');

$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'cart.php';



$result = mysqli_query($conn, "SELECT product_id FROM products WHERE product_id=$id");



if (mysqli_num_rows($result) === 0) {

    setCartMessage('danger', 'Product not found.');

    header("Location: products.php");

    exit();

}



$added = addToCartSession($id, $size, $qty);



if ($added > 0) {

    setCartMessage('success', $added . ' item(s) added to your cart.');

} elseif ($qty > 0) {

    setCartMessage('warning', 'Cart limit reached. You can only add up to ' . CART_LIMIT . ' items.');

}



header("Location: $redirect");

exit();


