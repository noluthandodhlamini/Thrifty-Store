<?php

include('includes/config.php');
include('includes/auth.php');

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn,
"SELECT * FROM products
WHERE user_id='$user_id'");

include('includes/header.php');
?>

<h2>My Listings</h2>

<table class="table">

<tr>
<th>Title</th>
<th>Price</th>
<th>Actions</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)) { ?>

<tr>
<td><?php echo $row['title']; ?></td>
<td>R<?php echo $row['price']; ?></td>
<td class="listing-actions">
  <button
    type="button"
    class="btn-small btn-edit"
    onclick="window.location.href='edit-listings.php?id=<?php echo $row['product_id']; ?>'">
    Edit
  </button>

  <button
    type="button"
    class="btn-small btn-delete"
    onclick="if (confirm('Are you sure you want to delete this item?')) { window.location.href='delete-listings.php?id=<?php echo $row['product_id']; ?>'; }">
    Delete
  </button>
</td>
</tr>

<?php } ?>

</table>

<?php include('includes/footer.php'); ?>
