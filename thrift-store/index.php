<?php include('includes/header.php'); ?>

<div class="container">

    <div class="text-center mt-5">
        <h1>Welcome to Thrifty Store</h1>
        <p>Buy and sell second-hand clothing safely online.</p>

        <a href="products.php" class="btn btn-primary">
            Shop Now
        </a>
		
        <a href="register.php" class="btn btn-success">
            Start Selling
        </a>
		
    </div>

    <hr>

    <h2 class="mt-4">Featured Products</h2>

    <div class="row">
	
	<div class="col-md-4 mb-4">
    
    <div class="card">
		<a href="product-details.php?id=1">
			<img src="assets/images/vintage-jacket.jpeg" class="card-img-top">
		</a>

		<div class="card-body">
			<h5>
				<a href="product-details.php?id=1" class="text-dark text-decoration-none">
					Vintage Jacket
				</a>
			</h5>

			<p>R250</p>

			<a href="product-details.php?id=1" class="btn btn-primary">
				View Product
			</a>
			
			<a href="add-to-cart.php?id=<?php echo $row['product_id']; ?>" class="btn btn-success">
				Add to Cart
			</a>

		</div>
	</div>
	
	</div>

	<div class="col-md-4 mb-4">
	
    <div class="card">
		<a href="product-details.php?id=1">
			<img src="assets/images/summer-dress.jpeg" class="card-img-top">
		</a>

		<div class="card-body">
			<h5>
				<a href="product-details.php?id=1" class="text-dark text-decoration-none">
					Summer Dress
				</a>
			</h5>

			<p>R180</p>

			<a href="product-details.php?id=1" class="btn btn-primary">
				View Product
			</a>
			
			<a href="add-to-cart.php?id=<?php echo $row['product_id']; ?>" class="btn btn-success">
				Add to Cart
			</a>
			
		</div>
	</div>
	
	</div>

    <div class="col-md-4 mb-4">
	
    <div class="card">
		<a href="product-details.php?id=1">
			<img src="assets/images/NB sneakers.jpeg" class="card-img-top">
		</a>

		<div class="card-body">
			<h5>
				<a href="product-details.php?id=1" class="text-dark text-decoration-none">
					NB Sneakers
				</a>
			</h5>

			<p>R300</p>

			<a href="product-details.php?id=1" class="btn btn-primary">
				View Product
			</a>
			
			<a href="add-to-cart.php?id=<?php echo $row['product_id']; ?>" class="btn btn-success">
				Add to Cart
			</a>
			
		</div>
	</div>
	
	</div>

</div>

<?php include('includes/footer.php'); ?>
