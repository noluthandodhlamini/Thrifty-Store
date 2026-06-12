<?php

include('../includes/config.php');

$totalUsers =
mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM users"));

$totalProducts =
mysqli_num_rows(mysqli_query($conn,
"SELECT * FROM products"));

?>

<h1>Reports</h1>

<p>Total Users:
<?php echo $totalUsers; ?>
</p>

<p>Total Products:
<?php echo $totalProducts; ?>
</p>