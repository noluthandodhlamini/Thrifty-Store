<?php

session_start();

include('includes/header.php');

?>

<h2>User Dashboard</h2>

<div class="card p-4">

<p>Welcome to your dashboard.</p>

<a href="sell-item.php" class="btn btn-success">
Sell New Item
</a>

<a href="my-listings.php">My Listings</a>
<a href="logout.php">Logout</a>

</div>

<?php include('includes/footer.php'); ?>