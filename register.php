<?php

session_start();

include('includes/config.php');

$error = '';

if (isset($_POST['register'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);
    $role = in_array($_POST['role'], ['buyer', 'seller']) ? $_POST['role'] : 'buyer';

    $check = mysqli_query($conn, "SELECT user_id FROM users WHERE email='$email'");

    if (mysqli_num_rows($check) > 0) {
        $error = 'An account with this email already exists.';
    } else {
        $sql = "INSERT INTO users(fullname, email, password, role)
                VALUES('$fullname', '$email', '$password', '$role')";

        if (mysqli_query($conn, $sql)) {
            header("Location: login.php");
            exit();
        } else {
            $error = 'Registration failed. Please try again.';
        }
    }
}

include('includes/header.php');
?>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width:500px;">

        <h2 class="text-center mb-4">Register</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="POST">

            <div class="mb-3">
                <label>Full Name</label>
                <input type="text"
                       name="fullname"
                       class="form-control"
                       placeholder="e.g. Noluthando Dhlamini"
                       required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="e.g. noluthando@gmail.com"
                       required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       placeholder="Create a password"
                       required>
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="">Select role</option>
                    <option value="buyer">Buyer</option>
                    <option value="seller">Seller</option>
                </select>
            </div>

            <button type="submit" name="register" class="btn btn-success w-100">
                Register
            </button>

        </form>

        <hr>

        <p class="text-center">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

    </div>
</div>

<?php include('includes/footer.php'); ?>
