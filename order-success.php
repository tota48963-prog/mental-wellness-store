<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

$order = $_SESSION['last_order'] ?? null;
if(!$order) {
    header("Location: index.php");
    exit();
}
unset($_SESSION['last_order']);
?>

<div class="container my-5">
    <div class="card shadow-lg text-center p-5">
        <div class="mb-4">
            <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
        </div>
        <h1 class="display-5 fw-bold text-success">Order Confirmed!</h1>
        <p class="lead">Thank you <?php echo htmlspecialchars($order['customer_name']); ?> for your purchase</p>
        <div class="alert alert-info mt-4">
            <h5>Order Number: <strong><?php echo $order['order_number']; ?></strong></h5>
            <p>Total Amount: <strong><?php echo $order['total']; ?> EGP</strong></p>
            <p class="mb-0">We will contact you soon to confirm your order.</p>
        </div>
        <div class="mt-4">
            <a href="index.php" class="btn btn-primary">Back to Home</a>
            <a href="products.php" class="btn btn-outline-primary ms-2">Continue Shopping</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>