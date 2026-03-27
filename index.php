<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

$featured = $conn->query("SELECT * FROM products LIMIT 4");
?>

<section class="hero bg-light text-center py-5">
    <div class="container p-5  text-primary text-center">
        <h1 class="display-4 fw-bold">Take care of your mind 💙</h1>
        <p class="lead text-muted">Discover tools to help you relax and improve your mental well-being</p>
        <a href="products.php" class="btn btn-light btn-lg rounded-pill px-4">Shop Now</a>
    </div>
</section>

<div class="container my-5">
    <h2 class="text-center mb-5" style="color: #89CFF0;">🌟 Featured Products</h2>
    <div class="row g-4">
        <?php while($product = $featured->fetch_assoc()): ?>
        <div class="col-md-6 col-lg-3">
            <div class="card product-card h-100">
                <img src="assets/images/<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>" onerror="this.src='https://via.placeholder.com/300'">
                <div class="card-body text-center">
                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                    <p class="card-text text-primary fw-bold"><?php echo $product['price']; ?> EGP</p>
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