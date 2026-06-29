<?php

include('../includes/config.php');
include('../includes/admin-layout.php');

admin_require_login();

$result = mysqli_query($conn,
    'SELECT orders.*, users.fullname AS buyer_name, products.title AS product_title
     FROM orders
     LEFT JOIN users ON orders.buyer_id = users.user_id
     LEFT JOIN products ON orders.product_id = products.product_id
     ORDER BY orders.order_id DESC');

admin_header('Orders', 'View all marketplace orders', 'orders');
?>

<section class="admin-panel">
    <div class="admin-panel-header">
        <h2>Order History</h2>
    </div>
    <div class="admin-panel-body">
        <?php if (mysqli_num_rows($result) === 0): ?>
            <div class="admin-empty">No orders recorded yet.</div>
        <?php else: ?>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Buyer</th>
                        <th>Product</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo (int)$row['order_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['buyer_name'] ?? 'Unknown'); ?></td>
                        <td><?php echo htmlspecialchars($row['product_title'] ?? 'Unknown'); ?></td>
                        <td class="admin-price">R<?php echo number_format((float)$row['amount'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php admin_footer(); ?>
