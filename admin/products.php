<?php

include('../includes/config.php');
include('../includes/product-helpers.php');
include('../includes/admin-layout.php');

admin_require_login();

$result = mysqli_query($conn, 'SELECT * FROM products ORDER BY product_id DESC');

admin_header('Manage Products', 'Monitor and review product listings', 'products');
?>

<section class="admin-panel">
    <div class="admin-panel-header">
        <h2>Product Listings</h2>
    </div>
    <div class="admin-panel-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) {
                    $imageSrc = getProductImageSrc($row['image'], $row['title']);
                ?>
                    <tr>
                        <td><?php echo (int)$row['product_id']; ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($imageSrc); ?>"
                                 alt="<?php echo htmlspecialchars($row['title']); ?>"
                                 class="admin-product-thumb">
                        </td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td class="admin-price">R<?php echo number_format((float)$row['price'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['category'] ?? 'General'); ?></td>
                        <td class="admin-description"><?php echo htmlspecialchars($row['description']); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php admin_footer(); ?>
