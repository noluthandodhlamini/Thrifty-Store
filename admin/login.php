<?php
session_start();

include('../includes/config.php');

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND role='admin'";
    $result = mysqli_query($conn, $query);

    $user = mysqli_fetch_assoc($result);

    if ($user && $password === $user['password']) {

        $_SESSION['admin'] = $user['email'];
        $_SESSION['admin_id'] = $user['user_id'];

        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Invalid admin credentials";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Login | Thrifty Store</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    min-height:100vh;
    background:linear-gradient(135deg,#0f172a,#1e3a8a,#2563eb);
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:Arial, sans-serif;
}

.admin-container{
    width:90%;
    max-width:1200px;
    display:grid;
    grid-template-columns:1fr 450px;
    gap:50px;
    align-items:center;
}

.left-panel{
    color:white;
}

.logo{
    font-size:18px;
    letter-spacing:2px;
    margin-bottom:30px;
}

.logo span{
    color:#60a5fa;
}

.left-panel h1{
    font-size:80px;
    font-weight:900;
    line-height:0.9;
}

.left-panel h1 span{
    color:#60a5fa;
}

.left-panel p{
    margin-top:30px;
    font-size:18px;
    max-width:500px;
    opacity:.9;
}

.features{
    margin-top:40px;
}

.features li{
    margin-bottom:15px;
    list-style:none;
}

.features li::before{
    content:"✓";
    color:#60a5fa;
    margin-right:10px;
}

.login-card{
    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:0 20px 50px rgba(0,0,0,.3);
}

.login-card h2{
    font-weight:700;
    margin-bottom:10px;
}

.login-card p{
    color:gray;
    margin-bottom:25px;
}

.form-control{
    padding:12px;
    margin-bottom:20px;
}

.btn-login{
    width:100%;
    background:#2563eb;
    color:white;
    border:none;
    padding:12px;
    border-radius:10px;
    font-weight:bold;
}

.btn-login:hover{
    background:#1d4ed8;
}

.links{
    text-align:center;
    margin-top:20px;
}

.links a{
    text-decoration:none;
    color:#2563eb;
}

@media(max-width:900px){

.admin-container{
    grid-template-columns:1fr;
}

.left-panel{
    text-align:center;
}

.left-panel h1{
    font-size:50px;
}

}

</style>
</head>
<body>

<div class="admin-container">

    <div class="left-panel">

        <div class="logo">
            THRIFTY <span>STORE</span>
            <small style="display:block;font-size:12px;">
                ADMIN PORTAL
            </small>
        </div>

        <h1>
            ADMIN<br>
            <span>DASHBOARD</span>
        </h1>

        <p>
            Manage users, products, orders and reports
            from one secure administration centre.
        </p>

        <ul class="features">
            <li>Manage registered users</li>
            <li>Review product listings</li>
            <li>Monitor orders and revenue</li>
            <li>Generate reports and analytics</li>
        </ul>

    </div>

    <div class="login-card">

        <h2>Admin Login</h2>

        <p>Secure administrator access</p>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">

            <input
            type="email"
            name="email"
            class="form-control"
            placeholder="Admin Email"
            required>

            <input
            type="password"
            name="password"
            class="form-control"
            placeholder="Password"
            required>

            <button
            type="submit"
            name="login"
            class="btn-login">
                Login to Dashboard
            </button>

        </form>

        <div class="links">
            <a href="forgot-password.php">
                Forgot Password?
            </a>
            <br><br>
            <a href="../index.php">
                Back to Website
            </a>
        </div>

    </div>

</div>

</body>
</html>