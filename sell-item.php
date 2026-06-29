<?php

include('includes/config.php');
include('includes/auth.php');

if (!isset($_SESSION['role']) || strtolower($_SESSION['role']) !== 'seller') {
    header("Location: dashboard.php");
    exit();
}

$success = '';
$error = '';

if (isset($_POST['add'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = (float)$_POST['price'];
	$gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? 'Unisex');
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?? 'General');
    $selectedSize = trim($_POST['size'] ?? 'One Size');
    $customSize = trim($_POST['custom_size'] ?? '');
    $sizeValue = $selectedSize === 'custom' ? $customSize : $selectedSize;

    if ($selectedSize === 'custom' && $customSize === '') {
        $error = 'Please enter one custom size for this item.';
    } elseif ($sizeValue === '') {
        $error = 'Please choose one size for this item.';
    }

    $sizeValue = substr($sizeValue, 0, 30);
    $size = mysqli_real_escape_string($conn, $sizeValue);

    $image = '';

    if ($error === '' && !empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        $uploadDir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $uploadDir . $image
        );
    }

    if ($error === '') {
        mysqli_query($conn,
        "INSERT INTO products (user_id, title, description, price, gender, category, size, image)
         VALUES ('" . $_SESSION['user_id'] . "', '$title', '$description', '$price', '$gender', '$category', '$size', '$image')");

        $success = 'Your item was listed successfully!';
    }
}

include('includes/product-helpers.php');
include('includes/header.php');
?>

<div class="container mt-4">

<h2>Sell Item</h2>

<?php if ($success): ?>
    <div class="alert alert-success"><?php echo $success; ?></div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label>Product Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>

    <div class="mb-3">
        <label>Price</label>
        <input type="number" name="price" class="form-control" min="0" step="0.01" required>
    </div>

	<div class="mb-3">
		<label>Gender</label>
		<select name="gender" class="form-control" required>
			<option value="Unisex">Unisex</option>
        	<option value="Men">Men</option>
			<option value="Women">Women</option>
		</select>
	</div>
    <div class="mb-3">
        <label>Category</label>
        <select name="category" class="form-control" required>
            <option value="Tops">Tops</option>
            <option value="Bottoms">Bottoms</option>
            <option value="Dresses">Dresses</option>
            <option value="Outerwear">Outerwear</option>
            <option value="Shoes">Shoes</option>
            <option value="Accessories">Accessories</option>
            <option value="Bags">Bags</option>
            <option value="General">General</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Size</label>
        <select name="size" id="sizeSelect" class="form-control" required>
            <?php foreach (getSizeOptions() as $value => $label): ?>
                <option value="<?php echo htmlspecialchars($value); ?>">
                    <?php echo htmlspecialchars($label); ?>
                </option>
            <?php endforeach; ?>
            <option value="custom">Custom size</option>
        </select>
        <input type="text"
               name="custom_size"
               id="customSizeInput"
               class="form-control mt-2"
               maxlength="30"
               style="display: none;"
               placeholder="Enter one size, e.g. 32, Petite, EU 40">
        <small class="text-muted">Only one size can be listed for each thrift item.</small>
    </div>

    <div class="mb-3">
        <label>Product Image</label>
        <input type="file" name="image" class="form-control" accept="image/*">
    </div>

    <button type="submit" name="add" class="btn btn-success">
        Upload Item
    </button>

</form>

</div>

<script>
const sizeSelect = document.getElementById('sizeSelect');
const customSizeInput = document.getElementById('customSizeInput');

function toggleCustomSize() {
    const isCustom = sizeSelect.value === 'custom';
    customSizeInput.style.display = isCustom ? 'block' : 'none';
    customSizeInput.required = isCustom;

    if (!isCustom) {
        customSizeInput.value = '';
    }
}

sizeSelect.addEventListener('change', toggleCustomSize);
toggleCustomSize();
</script>

<?php include('includes/footer.php'); ?>
