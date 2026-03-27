<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$result = $conn->query("SELECT * FROM products WHERE id = $id");

if($result && $result->num_rows > 0) {
    $product = $result->fetch_assoc();
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="assets/images/<?php echo $product['image']; ?>" class="img-fluid rounded shadow" alt="<?php echo $product['name']; ?>" onerror="this.src='https://via.placeholder.com/400'">
        </div>
        <div class="col-md-6">
            <h1 class="display-5 fw-bold" style="color: #89CFF0;"><?php echo $product['name']; ?></h1>
            <p class="fs-2 text-primary fw-bold my-3"><?php echo $product['price']; ?> EGP</p>
            <p class="lead"><?php echo $product['description']; ?></p>
            <p class="text-success"><i class="fas fa-check-circle"></i> In Stock</p>
            <form action="cart.php" method="POST">
                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="action" value="add">
                <div class="mb-3">
                    <label class="form-label">Quantity:</label>
                    <input type="number" name="quantity" value="1" min="1" class="form-control w-25">
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100"><i class="fas fa-cart-plus"></i> Add to Cart</button>
            </form>
        </div>
    </div>
</div>

<?php
} else {
    echo '<div class="container my-5 text-center"><h2>Product Not Found</h2><a href="products.php" class="btn btn-primary mt-3">Back to Products</a></div>';
}

include 'includes/footer.php';
?>