<?php include('includes/header.php'); ?>

<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width:500px;">

        <h2>Forgot Password</h2>

        <form action="reset-password.php" method="POST">

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       placeholder="Enter your registered email"
                       required>
            </div>

            <button type="submit" class="btn btn-success">
                Reset Password
            </button>

        </form>

    </div>
</div>

<?php include('includes/footer.php'); ?>