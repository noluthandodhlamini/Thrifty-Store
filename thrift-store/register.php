<?php

include('includes/config.php');

if(isset($_POST['register']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "INSERT INTO users(fullname,email,password,role)
            VALUES('$fullname','$email','$password','buyer')";

    mysqli_query($conn,$sql);

    header("Location: login.php");
}

include('includes/header.php');
?>

<h2>Register</h2>

<form action="register-process.php" method="POST">

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
        <select name="role" class="form-control">
            <option value="">Select role</option>
            <option value="buyer">Buyer</option>
            <option value="seller">Seller</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">
        Register
    </button>

</form>

<?php include('includes/footer.php'); ?>