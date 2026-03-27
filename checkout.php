<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

$session_id = getSessionId();
$items = $conn->query("SELECT c.id as cart_id, c.quantity, p.* FROM cart c JOIN products p ON c.product_id = p.id WHERE c.session_id = '$session_id'");
$cart_items = [];
$total = 0;
while($row = $items->fetch_assoc()) {
    $row['subtotal'] = $row['price'] * $row['quantity'];
    $total += $row['subtotal'];
    $cart_items[] = $row;
}

if(empty($cart_items)) {
    header("Location: cart.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['full_name']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $notes = $conn->real_escape_string($_POST['notes'] ?? '');
    $order_number = 'ORD-' . date('Ymd') . '-' . rand(1000,9999);
    
    $conn->query("INSERT INTO orders (order_number, customer_name, customer_phone, customer_address, total_amount, notes) VALUES ('$order_number', '$name', '$phone', '$address', $total, '$notes')");
    $order_id = $conn->insert_id;
    
    foreach($cart_items as $item) {
        $pname = $conn->real_escape_string($item['name']);
        $conn->query("INSERT INTO order_items (order_id, product_id, product_name, quantity, price) VALUES ($order_id, {$item['id']}, '$pname', {$item['quantity']}, {$item['price']})");
    }
    
    $conn->query("DELETE FROM cart WHERE session_id = '$session_id'");
    $_SESSION['last_order'] = ['order_number' => $order_number, 'customer_name' => $name, 'total' => $total];
    header("Location: order-success.php");
    exit();
}
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user"></i> Shipping Information</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Full Name *</label>
                            <input type="text" name="full_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number *</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Address *</label>
                            <textarea name="address" rows="3" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Additional Notes</label>
                            <textarea name="notes" rows="2" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100 btn-lg">Confirm Order</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-secondary text-white">
                    <h4 class="mb-0"><i class="fas fa-shopping-bag"></i> Order Summary</h4>
                </div>
                <div class="card-body">
                    <?php foreach($cart_items as $item): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span><?php echo $item['name']; ?> x <?php echo $item['quantity']; ?></span>
                        <span><?php echo $item['subtotal']; ?> EGP</span>
                    </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total:</span>
                        <span class="text-primary"><?php echo $total; ?> EGP</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>