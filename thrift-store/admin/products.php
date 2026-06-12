<?php

include('admin/config.php');
include('includes/header.php');

$result = mysqli_query($conn,"SELECT * FROM products");

<h1>Manage Products</h1>

<table border="1">

<tr>
<th>ID</th>
<th>Title</th>
<th>Price</th>
</tr>

<?php while($row=mysqli_fetch_assoc($result)) { ?>

<tr>
<td><?php echo $row['product_id']; ?></td>
<td><?php echo $row['title']; ?></td>
<td>R<?php echo $row['price']; ?></td>
</tr>

<?php } ?>

</table>