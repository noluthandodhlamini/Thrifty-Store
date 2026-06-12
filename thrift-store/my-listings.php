<?php

session_start();
include('includes/config.php');
include('includes/header.php');

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn,
"SELECT * FROM products
WHERE user_id='$user_id'");

?>

<h2>My Listings</h2>

<table class="table">

<tr>
<th>Title</th>
<th>Price</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)) { ?>

<tr>
<td><?php echo $row['title']; ?></td>
<td>R<?php echo $row['price']; ?></td>
</tr>

<?php } ?>

</table>

<?php include('includes/footer.php'); ?>