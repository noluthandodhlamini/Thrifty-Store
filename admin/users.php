<?php

include('../includes/config.php');
include('../includes/admin-layout.php');

admin_require_login();

$result = mysqli_query($conn, 'SELECT * FROM users ORDER BY user_id DESC');

admin_header('User Management', 'Manage registered users on the platform', 'users');
?>

<section class="admin-panel">
    <div class="admin-panel-header">
        <h2>All Users</h2>
        <input type="text"
               id="searchUser"
               class="admin-search"
               placeholder="Search users by name or email"
               onkeyup="searchUsers()">
    </div>
    <div class="admin-panel-body">
        <div class="admin-table-wrap">
            <table class="admin-table" id="usersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($user = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo (int)$user['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><?php echo admin_role_badge($user['role']); ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
function searchUsers() {
    var input = document.getElementById('searchUser').value.toLowerCase();
    var rows = document.querySelectorAll('#usersTable tbody tr');

    rows.forEach(function(row) {
        row.style.display = row.textContent.toLowerCase().includes(input) ? '' : 'none';
    });
}
</script>

<?php admin_footer(); ?>
