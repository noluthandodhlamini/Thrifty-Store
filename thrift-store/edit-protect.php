<?php

session_start();
include('includes/config.php');

$user_id = $_SESSION['user_id'];

$result = mysqli_query($conn,
"SELECT * FROM users WHERE user_id='$user_id'");

$user = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];

    mysqli_query($conn,
    "UPDATE users
    SET fullname='$fullname',
    email='$email'
    WHERE user_id='$user_id'");

    header("Location: dashboard.php");
}

include('includes/header.php');
?>

<h2>Edit Profile</h2>

<form method="POST">

<input type="text"
name="fullname"
value="<?php echo $user['fullname']; ?>"
class="form-control mb-3">

<input type="email"
name="email"
value="<?php echo $user['email']; ?>"
class="form-control mb-3">

<button name="update"
class="btn btn-success">
Update Profile
</button>

</form>

<?php include('includes/footer.php'); ?>