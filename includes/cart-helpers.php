<?php



define('CART_LIMIT', 10);



function getCartCount()

{

    return isset($_SESSION['cart']) && is_array($_SESSION['cart'])

        ? count($_SESSION['cart'])

        : 0;

}



function isCartFull()

{

    return getCartCount() >= CART_LIMIT;

}



function getCartItems($conn)

{

    require_once __DIR__ . '/product-helpers.php';



    $items = [];

    $total = 0;



    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {

        return ['items' => $items, 'total' => $total];

    }



    foreach ($_SESSION['cart'] as $entry) {

        $line = normalizeCartEntry($entry);

        $id = $line['product_id'];



        if ($id <= 0) {

            continue;

        }



        $result = mysqli_query($conn, "SELECT * FROM products WHERE product_id=$id");



        if ($row = mysqli_fetch_assoc($result)) {

            $row['selected_size'] = $line['size'];

            $items[] = $row;

            $total += (float)$row['price'];

        }

    }



    return ['items' => $items, 'total' => $total];

}



function setCartMessage($type, $message)

{

    $_SESSION['cart_message'] = ['type' => $type, 'text' => $message];

}



function getCartMessage()

{

    if (!isset($_SESSION['cart_message'])) {

        return null;

    }



    $message = $_SESSION['cart_message'];

    unset($_SESSION['cart_message']);



    return $message;

}



function addToCartSession($productId, $size = 'One Size', $qty = 1)

{

    if (!isset($_SESSION['cart'])) {

        $_SESSION['cart'] = [];

    }



    $spaceLeft = CART_LIMIT - getCartCount();

    $toAdd = min($qty, $spaceLeft);



    for ($i = 0; $i < $toAdd; $i++) {

        $_SESSION['cart'][] = [

            'product_id' => (int)$productId,

            'size' => $size !== '' ? $size : 'One Size',

        ];

    }



    return $toAdd;

}



function removeFromCartSession($productId)

{

    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {

        return;

    }



    require_once __DIR__ . '/product-helpers.php';

    $productId = (int)$productId;



    foreach ($_SESSION['cart'] as $key => $entry) {

        $line = normalizeCartEntry($entry);



        if ($line['product_id'] === $productId) {

            unset($_SESSION['cart'][$key]);

            $_SESSION['cart'] = array_values($_SESSION['cart']);

            return;

        }

    }

}


