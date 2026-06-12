<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "thrift_store");

// ✅ TOTAL USERS
$userQuery = "SELECT COUNT(*) AS totalUsers FROM users";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$totalUsers = $userData['totalUsers'];

// ✅ TOTAL PRODUCTS
$productQuery = "SELECT COUNT(*) AS totalProducts FROM products";
$productResult = mysqli_query($conn, $productQuery);
$productData = mysqli_fetch_assoc($productResult);
$totalProducts = $productData['totalProducts'];

// ✅ Check admin session
if (!isset($_SESSION['admin'])) {
    header("Location: login.php"); // ✅ FIXED
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

    <div class="sidebar">
    <h2>Admin Panel</h2>

    <a href="#" class="active">Dashboard</a>
    <a href="admin/user.php">Users</a>
    <a href="admin/product.php">Products</a>
    <a href="admin/orders.php">Orders</a>
    <a href="admin/report.php">Reports</a>

    <a href="logout.php" class="logout">Logout</a>
	</div>

    <!-- MAIN CONTENT -->
    <div class="main">

        <h1 class="fw-bold">Admin Dashboard</h1>
        <p class="text-muted">Welcome back, Admin 👋</p>

        <!-- STATS -->
        <div class="row mt-4">

            <div class="col-md-4 mb-3">
                <div class="card p-3 shadow-sm border-0">
                    <small class="text-muted">Total Users</small>
                    <h3 class="fw-bold"><?php echo $totalUsers; ?></h3>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card p-3 shadow-sm border-0">
                    <small class="text-muted">Active Listings</small>
                    <h3 class="fw-bold"><?php echo $totalProducts; ?></h3>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card p-3 shadow-sm border-0">
                    <small class="text-muted">Pending Approvals</small>
                    <h3 class="fw-bold">0</h3>
                </div>
            </div>

        

        <!-- TABLE SECTION -->
        <div class="card mt-4 shadow-sm border-0">
            <div class="card-body">

                <h5 class="mb-3">Recent Users</h5>

                <table class="table table-borderless align-middle">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $query = "SELECT * FROM users LIMIT 5";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
							echo "<tr>";
							echo "<td>" . ($row['id'] ?? '-') . "</td>";
							echo "<td>" . ($row['name'] ?? 'N/A') . "</td>";
							echo "<td>" . $row['email'] . "</td>";
							echo "<td><span class='status active'>Active</span></td>";
							echo "</tr>";
						}
                        ?>
                    </tbody>

                </table>

            </div>
        </div>

    </div>

</div>

<script>
function animateValue(id, start, end, duration) {

    let range = end - start;
    let current = start;
    let increment = end > start ? 1 : -1;

    let stepTime = Math.abs(Math.floor(duration / range));

    let timer = setInterval(function () {

        current += increment;

        document.getElementById(id).innerHTML = current;

        if (current == end) {
            clearInterval(timer);
        }

    }, stepTime);
}

window.onload = function() {

    animateValue("userCount", 0,
        <?php echo $totalUsers; ?>, 1000);

    animateValue("productCount", 0,
        <?php echo $totalProducts; ?>, 1000);
}
</script>

</body>

</html>