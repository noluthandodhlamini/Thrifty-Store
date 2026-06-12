<?php

include('admin/config.php');
include('includes/header.php');

if(isset($_GET['search']))
{
    $search = $_GET['search'];

    $sql = "SELECT * FROM products
            WHERE title LIKE '%$search%'
            OR description LIKE '%$search%'";
}
else
{
    $sql = "SELECT * FROM products";
}

$result = mysqli_query($conn,$sql);
?>


<h2>Marketplace</h2>

<div class="row">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="col-md-4 mb-4">
    <div class="card">

        <img src="assets/images/<?php echo $row['image']; ?>"
             class="card-img-top"
             alt="<?php echo $row['title']; ?>">

        <div class="card-body">

            <h5><?php echo $row['title']; ?></h5>

            <p>R<?php echo $row['price']; ?></p>

            <a href="product-details.php?id=<?php echo $row['product_id']; ?>"
               class="btn btn-primary">
                View Product
            </a>
			
			<a href="add-to-cart.php?id=<?php echo $row['product_id']; ?>" class="btn btn-success">
				Add to Cart
			</a>
			

        </div>
    </div>
</div>

<?php } ?>

</div>

<?php include('includes/footer.php'); ?>