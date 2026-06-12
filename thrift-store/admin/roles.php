<?php

include('../includes/config.php');

if(isset($_POST['update']))
{
    $id = $_POST['user_id'];
    $role = $_POST['role'];

    mysqli_query($conn,
    "UPDATE users
    SET role='$role'
    WHERE user_id='$id'");
}

$result = mysqli_query($conn,
"SELECT * FROM users");

?>

<h1>Role Management</h1>

<table border="1">

<?php while($row=mysqli_fetch_assoc($result)) { ?>

<tr>

<form method="POST">

<td><?php echo $row['fullname']; ?></td>

<td>

<select name="role">

<option>buyer</option>
<option>seller</option>
<option>admin</option>

</select>

</td>

<td>

<input type="hidden"
name="user_id"
value="<?php echo $row['user_id']; ?>">

<button name="update">
Update
</button>

</td>

</form>

</tr>

<?php } ?>

</table>