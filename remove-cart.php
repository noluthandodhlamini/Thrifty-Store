<?php

session_start();



include('includes/cart-helpers.php');



if (!isset($_GET['id'])) {

    header("Location: cart.php");

    exit();

}



removeFromCartSession((int)$_GET['id']);



header("Location: cart.php");

exit();


