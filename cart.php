<?php
require_once 'config/database.php';
include 'includes/header.php';
include 'includes/navbar.php';

$session_id = getSessionId();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = intval($_POST['product_id']);
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    
    if ($_POST['action'] === 'add') {
        $check = $conn->query("SELECT * FROM cart WHERE session_id = '$session_id' AND product_id = $product_id");
        if ($check->num_rows > 0) {
            $row = $check->fetch_assoc();
            $new_qty = $row['quantity'] + $quantity;
            $conn->query("UPDATE cart SET quantity = $new_qty WHERE id = {$row['id']}");
        } else {
            $conn->query("INSERT INTO cart (product_id, quantity, session_id) VALUES ($product_id, $quantity, '$session_id')");
        }
        header("Location: cart.php");
        exit();
    } 
    elseif ($_POST['action'] === 'update') {
        $cart_id = intval($_POST['cart_id']);
        $quantity = intval($_POST['quantity']);
        if ($quantity > 0) {
            $conn->query("UPDATE cart SET quantity = $quantity WHERE id = $cart_id AND session_id = '$session_id'");
        } else {
            $conn->query("DELETE FROM cart WHERE id = $cart_id AND session_id = '$session_id'");
        }
        header("Location: cart.php");
        exit();
    } 
    elseif ($_POST['action'] === 'remove') {
        $cart_id = intval($_POST['cart_id']);
        $conn->query("DELETE FROM cart WHERE id = $cart_id AND session_id = '$session_id'");
        header("Location: cart.php");
        exit();
    }
}

$items = $conn->query("SELECT c.id as cart_id, c.quantity, p.* FROM cart c JOIN products p ON c.product_id = p.id WHERE c.session_id = '$session_id'");
$cart_items = [];
$total = 0;
while($row = $items->fetch_assoc()) {
    $row['subtotal'] = $row['price'] * $row['quantity'];
    $total += $row['subtotal'];
    $cart_items[] = $row;
}
?>

<div class="container my-5">
    <h1 class="mb-4"><i class="fas fa-shopping-cart"></i> Shopping Cart</h1>
    
    <?php if(empty($cart_items)): ?>
    <div class="alert alert-info text-center">
        Your cart is empty. <a href="products.php" class="alert-link">Start shopping</a>
    </div>
    <?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Action</th> </tr>
            </thead>
            <tbody>
                <?php foreach($cart_items as $item): ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['price']; ?> EGP</td>
                    <td>
                        <form action="cart.php" method="POST" class="d-flex gap-2">
                            <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                            <input type="hidden" name="action" value="update">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control w-50">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                    </td>
                    <td><?php echo $item['subtotal']; ?> EGP</td>
                    <td>
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                            <input type="hidden" name="action" value="remove">
                            <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total:</td>
                    <td colspan="2" class="fw-bold fs-5 text-primary"><?php echo $total; ?> EGP</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="d-flex justify-content-between mt-4">
        <a href="products.php" class="btn btn-outline-secondary">Continue Shopping</a>
        <a href="checkout.php" class="btn btn-success btn-lg">Proceed to Checkout</a>
    </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>