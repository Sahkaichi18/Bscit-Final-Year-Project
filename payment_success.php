<?php
session_start();
include 'config.php'; // Connect to shop_db

// Check if order details are available in the session (for COD)
if (isset($_SESSION['order_details'])) {
    $order_details = $_SESSION['order_details'];
    $payment_mode = $order_details['method'];
    $is_cod = ($payment_mode === 'cash on delivery');
} else {
    $is_cod = false;
}

// Check if payment ID is provided (for Razorpay)
$payment_id = $_GET['payment_id'] ?? null;

// Override $is_cod if payment_id is present (indicating Razorpay payment)
if ($payment_id) {
    $is_cod = false; // Razorpay payment, not COD
}

// Redirect to checkout page if neither COD nor Razorpay payment is valid
if (!$is_cod && !$payment_id) {
    header("Location: checkout.php?error=missing_payment_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="payment-success">
            <?php if ($is_cod): ?>
                <h2>Order Placed Successfully!</h2>
                <p>Thank you for shopping with us.</p>
                <div class="order-detail">
                    <span>Products: <?= $order_details['total_product']; ?></span>
                    <span class="total">Total: ₹<?= number_format($order_details['final_price']); ?> /-</span>
                </div>
                <div class="customer-details">
                    <p>Your Name: <span><?= $order_details['name']; ?></span></p>
                    <p>Your Number: <span><?= $order_details['number']; ?></span></p>
                    <p>Your Email: <span><?= $order_details['email']; ?></span></p>
                    <p>Your Address: <span><?= $order_details['address']; ?></span></p>
                    <p>Payment Mode: <span><?= $order_details['method']; ?></span></p>
                    <p>(*Pay when product arrives*)</p>
                </div>
            <?php else: ?>
                <h2>Payment Successful!</h2>
                <p>Thank you for your order.</p>
                <p>Your Payment ID: <strong><?= htmlspecialchars($payment_id); ?></strong></p>
                <p>We have received your payment and your order is being processed.</p>
            <?php endif; ?>
            <a href="menu.php" class="btn">Continue Shopping</a>
        </div>
    </div>
</body>
</html>