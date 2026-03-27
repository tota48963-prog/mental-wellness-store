<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

$products = $conn->query("SELECT * FROM products ORDER BY id");
?>

<div class="container my-5">
    <h2 class="text-center mb-5" style="color: #89CFF0;">🛍️ All Products</h2>
    <div class="row g-4">
        <?php while($product = $products->fetch_assoc()): ?>
        <div class="col-md-6 col-lg-4">
            <div class="card product-card h-100">
                <a href="details.php?id=<?php echo $product['id']; ?>" class="text-decoration-none">
                    <img src="assets/images/<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" onerror="this.src='https://via.placeholder.com/300'">
                    <div class="card-body text-center">
                        <h5 class="card-title text-dark"><?php echo $product['name']; ?></h5>
                    </div>
                </a>
                <div class="card-body text-center pt-0">
                    <p class="card-text text-primary fw-bold fs-4"><?php echo $product['price']; ?> EGP</p>
                    <form action="cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="action" value="add">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-cart-plus"></i> Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>