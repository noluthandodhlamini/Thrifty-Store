<!DOCTYPE html>
<html>
<head>
<title>Thrifty Store</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">

<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Thrifty Store</a>

        <button class="navbar-toggler" type="button"
				data-bs-toggle="collapse"
				data-bs-target="#navbarNav">
			<span class="navbar-toggler-icon"></span>
<		</button>

            <!-- Search Form -->
            <form class="d-flex ms-auto me-3" action="products.php" method="GET">
                <input class="form-control me-2"
                       type="search"
                       name="search"
                       placeholder="Search products">
                
            </form>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="products.php">Products</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="sell-item.php">Sell Item</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="cart.php">
                        🛒 Cart
                    </a>
                </li>
            </ul>
			
			 <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link" href="login.php">
                        Login
                    </a>
                </li>


            </ul>
			
			<ul class= "navbar-nav">
			
				<li class="nav-item">
					<a class="nav-link" a href="admin/dashboard.php">Admin Panel</a>
				</li>
			
			</ul>

        </div>
    </div>
</nav>

<div class="container mt-4">