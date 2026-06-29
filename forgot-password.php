<?php

session_start();
include('includes/config.php');

$error = '';
$success = '';

if (isset($_POST['reset'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $query = mysqli_query($conn, "SELECT user_id FROM users WHERE email='$email'");

    if (mysqli_num_rows($query) > 0) {
        $_SESSION['reset_email'] = $email;
        header("Location: reset-password.php");
        exit();
    } else {
        $error = 'No account found with that email address.';
    }
}

include('includes/header.php');
?>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width:500px;">

        <h2>Forgot Password</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter your registered email"
                       required>
            </div>

            <button type="submit" name="reset" class="btn btn-success w-100">
                Continue to Reset Password
            </button>

        </form>

        <hr>

        <p class="text-center">
            <a href="login.php">Back to Login</a>
        </p>

    </div>
</div>

<?php include('includes/footer.php'); ?>
