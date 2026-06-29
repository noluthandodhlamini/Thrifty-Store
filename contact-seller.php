<?php

include('includes/config.php');
include('includes/header.php');

if (!isset($_GET['id'])) {
    die("No seller selected.");
}

$user_id = (int)$_GET['id'];

$sql = "SELECT fullname, email FROM users WHERE user_id=$user_id";
$result = mysqli_query($conn, $sql);
$seller = mysqli_fetch_assoc($result);

if (!$seller) {
    die("Seller not found.");
}

?>

<div class="container mt-4">

    <div class="card">
        <div class="card-body">

            <h2>Seller Information</h2>

            <p>
                <strong>Name:</strong>
                <?php echo htmlspecialchars($seller['fullname']); ?>
            </p>

            <p>
                <strong>Email:</strong>
                <?php echo htmlspecialchars($seller['email']); ?>
            </p>

            <a href="mailto:<?php echo htmlspecialchars($seller['email']); ?>"
               class="btn btn-success">
                Email Seller
            </a>

            <a href="products.php"
               class="btn btn-secondary">
                Back to Products
            </a>

        </div>
    </div>

</div>

<?php include('includes/footer.php'); ?>
