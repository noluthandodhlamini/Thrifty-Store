<?php
session_start();
include('../includes/config.php');

$message = "";

if(isset($_POST['reset_password'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $check = mysqli_query($conn,
        "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){

        $newPassword = "admin123";

        mysqli_query($conn,
            "UPDATE users
             SET password='$newPassword'
             WHERE email='$email'");

        $message = "<div class='alert alert-success'>
                        Password has been reset to:
                        <strong>admin123</strong>
                    </div>";

    }else{

        $message = "<div class='alert alert-danger'>
                        Email address not found.
                    </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:linear-gradient(135deg,#0f172a,#1e3a8a,#2563eb);
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    font-family:Arial,sans-serif;
}

.card-box{
    width:450px;
    background:#fff;
    padding:40px;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,.25);
}

h2{
    text-align:center;
    margin-bottom:10px;
}

p{
    text-align:center;
    color:#666;
    margin-bottom:25px;
}

.btn-reset{
    width:100%;
    background:#2563eb;
    color:white;
    border:none;
    padding:12px;
    border-radius:10px;
}

.btn-reset:hover{
    background:#1d4ed8;
}

.back-link{
    display:block;
    text-align:center;
    margin-top:20px;
    text-decoration:none;
}

</style>
</head>
<body>

<div class="card-box">

    <h2>Forgot Password</h2>

    <p>Enter your email address to reset your password.</p>

    <?php echo $message; ?>

    <form method="POST">

        <input
        type="email"
        name="email"
        class="form-control mb-3"
        placeholder="Enter your email"
        required>

        <button
        type="submit"
        name="reset_password"
        class="btn-reset">
            Reset Password
        </button>

    </form>

    <a href="login.php" class="back-link">
        ← Back to Login
    </a>

</div>

</body>
</html>