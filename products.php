<?php

include('includes/config.php');

include('includes/product-helpers.php');

include('includes/header.php');



$gender = $_GET['gender'] ?? 'all';

$category = $_GET['category'] ?? 'all';



$sql = "SELECT * FROM products WHERE 1";



if ($gender !== 'all') {

    $safe_gender = mysqli_real_escape_string($conn, $gender);

    $sql .= " AND gender = '$safe_gender'";

}



if ($category !== 'all') {

    $safe_category = mysqli_real_escape_string($conn, $category);

    $sql .= " AND category = '$safe_category'";

}



$sql .= " ORDER BY product_id DESC";



$result = mysqli_query($conn, $sql);

?>



<div class="container marketplace-page">



    <section class="marketplace-header">

        <h1>Marketplace</h1>



        <form method="GET" class="marketplace-filters">

            <select name="gender" class="filter-select" onchange="this.form.submit()">

                <option value="all" <?php if ($gender === 'all') echo 'selected'; ?>>All Genders</option>

                <option value="Men" <?php if ($gender === 'Men') echo 'selected'; ?>>Men</option>

                <option value="Women" <?php if ($gender === 'Women') echo 'selected'; ?>>Women</option>

                <option value="Unisex" <?php if ($gender === 'Unisex') echo 'selected'; ?>>Unisex</option>

            </select>



            <select name="category" class="filter-select" onchange="this.form.submit()">

                <option value="all" <?php if ($category === 'all') echo 'selected'; ?>>All Categories</option>

                <option value="Tops" <?php if ($category === 'Tops') echo 'selected'; ?>>Tops</option>

                <option value="Bottoms" <?php if ($category === 'Bottoms') echo 'selected'; ?>>Bottoms</option>

                <option value="Dresses" <?php if ($category === 'Dresses') echo 'selected'; ?>>Dresses</option>

                <option value="Outerwear" <?php if ($category === 'Outerwear') echo 'selected'; ?>>Outerwear</option>

                <option value="Shoes" <?php if ($category === 'Shoes') echo 'selected'; ?>>Shoes</option>

                <option value="Accessories" <?php if ($category === 'Accessories') echo 'selected'; ?>>Accessories</option>

                <option value="Bags" <?php if ($category === 'Bags') echo 'selected'; ?>>Bags</option>

            </select>

        </form>

    </section>



    <div class="row products-grid">

        <?php while ($row = mysqli_fetch_assoc($result)) {

            $imageSrc = getProductImageSrc($row['image'], $row['title']);

            $size = !empty($row['size']) ? $row['size'] : 'One Size';

        ?>

            <div class="col-md-4 col-sm-6 mb-4">

                <div class="card product-card">

                    <a href="product-details.php?id=<?php echo $row['product_id']; ?>">

                        <img src="<?php echo htmlspecialchars($imageSrc); ?>"

                             class="card-img-top"

                             alt="<?php echo htmlspecialchars($row['title']); ?>">

                    </a>



                    <div class="card-body">

                        <h5><?php echo htmlspecialchars($row['title']); ?></h5>

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



</div>



<?php include('includes/footer.php'); ?>


