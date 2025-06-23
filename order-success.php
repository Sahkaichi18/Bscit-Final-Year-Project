<?php
session_start();

// Check if order details exist in session
if (!isset($_SESSION['order_details']) || empty($_SESSION['order_details'])) {
    header("Location: menu.php"); // Redirect if no order details
    exit();
}

$order = $_SESSION['order_details'];
unset($_SESSION['order_details']); // Clear session after use
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Order Success</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>
   <section class="order-success">
      <div class="order-container">
         <h3 class="order-heading">Thank you for shopping!</h3>
         <div class="order-summary">
            <p class="product-count">Items Ordered: <span><?= isset($order['total_product']) ? htmlspecialchars($order['total_product']) : 'N/A'; ?></span></p>
            <p class="order-total">Total Amount: ₹<span><?= isset($order['final_price']) ? htmlspecialchars($order['final_price']) : 'N/A'; ?></span>/-</p>
         </div>
         <div class="customer-info">
            <p class="customer-detail">Your Name: <span><?= isset($order['name']) ? htmlspecialchars($order['name']) : 'N/A'; ?></span></p>
            <p class="customer-detail">Your Number: <span><?= isset($order['number']) ? htmlspecialchars($order['number']) : 'N/A'; ?></span></p>
            <p class="customer-detail">Your Email: <span><?= isset($order['email']) ? htmlspecialchars($order['email']) : 'N/A'; ?></span></p>
            <p class="customer-detail">Your Address: <span><?= isset($order['address']) ? htmlspecialchars($order['address']) : 'N/A'; ?></span></p>
            <p class="customer-detail">Payment Mode: <span><?= isset($order['method']) ? htmlspecialchars($order['method']) : 'N/A'; ?></span></p>
            <p class="payment-note">(*Pay when product arrives*)</p>
         </div>
         <a href="menu.php" class="continue-btn">Continue Shopping</a>
      </div>
   </section>
</body>
</html>
