<?php
session_start();

$conn = mysqli_connect("localhost", "root", "", "thrift_store");

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE email='$email' AND role='admin'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && $password === $user['password']) {

        // ✅ SET SESSION
        $_SESSION['admin'] = $user['email'];

        // ✅ CORRECT REDIRECT
        header("Location: dashboard.php");
        exit();

    } else {
        $error = "Invalid admin credentials";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

<div class="container mt-5">

<h2>Admin Login</h2>

<?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

<form method="POST">

<input type="email"
name="email"
placeholder="Admin Email"
class="form-control mb-3"
required>

<input type="password"
name="password"
placeholder="Password"
class="form-control mb-3"
required>

<button name="login"
class="btn btn-dark">
Login
</button>

</form>

</div>

</body>
</html>