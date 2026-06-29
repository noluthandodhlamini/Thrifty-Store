<?php

session_start();

include('includes/config.php');

$error = '';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);

    $query = mysqli_query($conn,
        "SELECT * FROM users
         WHERE email='$email'
         AND password='$password'");

    if (mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['fullname'] = $user['fullname'];

        header("Location: dashboard.php");
        exit();
    } else {
        $error = 'Invalid email or password.';
    }
}

include('includes/header.php');
?>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width:500px;">

        <h2 class="text-center mb-4">Login</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter your email address"
                       required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter your password"
                       required>
            </div>

            <div class="mb-3">
                <a href="forgot-password.php">
                    Forgot Password?
                </a>
            </div>

            <button type="submit" name="login" class="btn btn-primary w-100">
                Login
            </button>

        </form>

        <hr>

        <p class="text-center">
            Don't have an account?
            <a href="register.php">
                Register here
            </a>
        </p>

    </div>
</div>

<?php include('includes/footer.php'); ?>
