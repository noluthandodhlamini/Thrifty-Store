<?php

include('admin/config.php');
include('includes/header.php');

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE user_id = '$id'";
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
                <?php echo $seller['fullname']; ?>
            </p>

            <p>
                <strong>Email:</strong>
                <?php echo $seller['email']; ?>
            </p>

            <a href="mailto:<?php echo $seller['email']; ?>"
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