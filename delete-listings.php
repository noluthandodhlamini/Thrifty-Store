<?php
include "db.php";

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM products WHERE id='$id'";

    if(mysqli_query($conn, $sql)) {
        header("Location: my-listings.php");
        exit();
    } else {
        echo "Delete failed";
    }
}
?>