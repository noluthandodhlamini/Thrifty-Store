<?php

session_start();
include('includes/config.php');

if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot-password.php");
    exit();
}

$error = '';
$success = '';

if (isset($_POST['save'])) {
    $email = $_SESSION['reset_email'];
    $password = md5($_POST['password']);

    if (mysqli_query($conn,
        "UPDATE users SET password='$password' WHERE email='$email'")) {
        unset($_SESSION['reset_email']);
        $success = 'Password updated successfully. You can now log in.';
    } else {
        $error = 'Could not update password. Please try again.';
    }
}

include('includes/header.php');
?>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width:500px;">

        <h2>Reset Password</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <a href="login.php" class="btn btn-primary w-100">Go to Login</a>
        <?php else: ?>

        <form method="POST">

            <div class="mb-3">
                <label>New Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Enter new password"
                       required>
            </div>

            <button type="submit" name="save" class="btn btn-success w-100">
                Save Password
            </button>

        </form>

        <?php endif; ?>

    </div>
</div>

<?php include('includes/footer.php'); ?>
