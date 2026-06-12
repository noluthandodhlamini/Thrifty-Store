<?php

session_start();

include('includes/config.php');

if(isset($_POST['add']))
{
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $image = $_FILES['image']['name'];

    move_uploaded_file(
    $_FILES['image']['tmp_name'],
    "assets/images/".$image
    );

    mysqli_query($conn,
    "INSERT INTO products
    (user_id,title,description,price,image)
    VALUES
    ('".$_SESSION['user_id']."',
    '$title',
    '$description',
    '$price',
    '$image')");
}

include('includes/header.php');
?>

<h2>Sell Item</h2>

<form method="POST" enctype="multipart/form-data">

<div class="mb-3">
<label>Product Title</label>
<input type="text" name="title" class="form-control">
</div>

<div class="mb-3">
<label>Description</label>
<textarea name="description" class="form-control"></textarea>
</div>

<div class="mb-3">
<label>Price</label>
<input type="number" name="price" class="form-control">
</div>

<div class="mb-3">
<label>Product Image</label>
<input type="file" name="image" class="form-control">
</div>

<button name="add" class="btn btn-success">
Upload Item
</button>

</form>

<?php include('includes/footer.php'); ?>