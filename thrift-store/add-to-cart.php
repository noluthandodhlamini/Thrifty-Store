<?php
session_start();

// Check if a product ID was passed
if (!isset($_GET['id'])) {
    die("No product selected.");
}

$id = $_GET['id'];

// Create the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add the product ID to the cart
$_SESSION['cart'][] = $id;

// Redirect to cart page
header("Location: cart.php");
exit();
?>