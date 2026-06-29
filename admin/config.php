<?php
$conn = mysqli_connect(
    "sql306.infinityfree.com",
    "if0_42124175",
    "MiNahDhl983",
    "if0_42124175_db_name"
);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>