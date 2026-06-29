<?php

include('includes/config.php');

include('includes/product-helpers.php');

include('includes/header.php');



$featured = mysqli_query($conn, "SELECT * FROM products ORDER BY product_id DESC LIMIT 3");

?>



<div class="container mt-4 home-page">



    <div class="text-center mt-5 home-hero">

        <h1>Welcome to Thrifty Store</h1>

        <p>Buy and sell second-hand clothing safely online.</p>



        <a href="<?php echo site_url('products.php'); ?>" class="btn btn-primary">

            Shop Now

        </a>



        <a href="<?php echo site_url('register.php'); ?>" class="btn btn-success">

            Start Selling

        </a>

    </div>



    <hr>



    <section class="featured-products">

        <h2 class="section-title">Featured Products</h2>



        <div class="row products-grid">

            <?php while ($row = mysqli_fetch_assoc($featured)) {

                $imageSrc = getProductImageSrc($row['image'], $row['title']);

                $size = !empty($row['size']) ? $row['size'] : 'One Size';

            ?>

                <div class="col-md-4 col-sm-6 mb-4">

                    <div class="card product-card">

                        <a href="<?php echo site_url('product-details.php?id=' . $row['product_id']); ?>">

                            <img src="<?php echo htmlspecialchars($imageSrc); ?>"

                                 class="card-img-top"

                                 alt="<?php echo htmlspecialchars($row['title']); ?>"

                                 loading="lazy">

                        </a>



                        <div class="card-body">

                            <h5>

                                <a href="product-details.php?id=<?php echo $row['product_id']; ?>"

                                   class="text-dark text-decoration-none">

                                    <?php echo htmlspecialchars($row['title']); ?>

                                </a>

                            </h5>



                            <p class="card-price">R<?php echo number_format((float)$row['price'], 2); ?></p>

                            <p class="card-size">Size: <?php echo htmlspecialchars($size); ?></p>



                            <div class="card-actions">

                                <a href="product-details.php?id=<?php echo $row['product_id']; ?>"

                                   class="btn btn-primary btn-sm">

                                    View Product

                                </a>



                                <a href="add-to-cart.php?id=<?php echo $row['product_id']; ?>&size=<?php echo urlencode($size); ?>"

                                   class="btn btn-success btn-sm">

                                    Add to Cart

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            <?php } ?>

        </div>

    </section>

</div>



<?php include('includes/footer.php'); ?>


