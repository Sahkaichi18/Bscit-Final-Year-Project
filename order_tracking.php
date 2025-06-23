<?php
@include 'config.php';
session_start();
$order = null;
$message = '';

if (isset($_POST['track_order'])) {
   if (!empty($_POST['id']) && is_numeric($_POST['id'])) {
      $order_id = mysqli_real_escape_string($conn, $_POST['id']);
      $query = "SELECT * FROM `order` WHERE id = '$order_id'";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) > 0) {
         $order = mysqli_fetch_assoc($result);
         $_SESSION['order'] = $order;
         $_SESSION['order_message'] = "Your order details";
         header("Location: order_tracking.php?success=1");
         exit();
      } else {
         header("Location: order_tracking.php?error=notfound");
         exit();
      }
   } else {
      header("Location: order_tracking.php?error=" . (empty($_POST['id']) ? "empty" : "invalid"));
      exit();
   }
}

// Retrieve session message
if (isset($_SESSION['order_message'])) {
   $message = $_SESSION['order_message'];
   unset($_SESSION['order_message']);
}

// Retrieve order details if available
if (isset($_SESSION['order'])) {
   $order = $_SESSION['order'];
   unset($_SESSION['order']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Track Your Order</title>
   <link rel="stylesheet" href="style.css">
</head>
<body>
   <section class="order-tracking">
      <h1>Track Your Order</h1>

      <?php if (isset($_GET['error'])): ?>
         <div class="error-message">
            <?php 
               if ($_GET['error'] == "invalid") {
                  echo "Invalid Order ID. Please enter a valid numeric Order ID.";
               } elseif ($_GET['error'] == "notfound") {
                  echo " No order found with that Order ID. Please check your input and try again.";
               } elseif ($_GET['error'] == "empty") {
                  echo " Please enter an Order ID before tracking.";
               }
            ?>
         </div>
      <?php endif; ?>

      <form action="order_tracking.php" method="POST">
         <label for="id">Enter your Order ID to track:</label>
         <input type="text" name="id" placeholder="Order ID" required>
         <button type="submit" name="track_order" class="btn">Track Order</button>
      </form>
   </section>

   <?php if (!empty($message)): ?>
      <div class="order-message">
         <span><?= htmlspecialchars($message); ?></span>
         <i class="order-message-close" onclick="document.querySelector('.order-message').style.display='none';">✖</i>
      </div>
   <?php endif; ?>
   
   <?php if (isset($_SESSION['order_message'])): ?>
    <div class="order-message">
        <?= htmlspecialchars($_SESSION['order_message']); ?>
    </div>
    <?php unset($_SESSION['order_message']); ?>
<?php endif; ?>

   <?php if ($order): ?>
      <section class="order-details">
         <h2>Order Details</h2>
         <p><strong>Order ID:</strong> <?= htmlspecialchars($order['id']); ?></p>
         <p><strong>Name:</strong> <?= htmlspecialchars($order['name']); ?></p>
         <p><strong>Email:</strong> <?= htmlspecialchars($order['email']); ?></p>
         <p><strong>Phone:</strong> <?= htmlspecialchars($order['number']); ?></p>
         <p><strong>Address:</strong> <?= htmlspecialchars($order['flat'] . ", " . $order['street'] . ", " . $order['city'] . ", " . $order['state'] . ", " . $order['country'] . " - " . $order['pin_code']); ?></p>
         <p><strong>Payment Method:</strong> <?= htmlspecialchars($order['method']); ?></p>
         <p><strong>Total Products:</strong> <?= htmlspecialchars($order['total_products']); ?></p>
         <p><strong>Total Price:</strong> ₹<?= number_format($order['total_price']); ?> /-</p>
         <p><strong>Status:</strong> <?= htmlspecialchars($order['status']); ?></p>
      </section>
   <?php endif; ?>
</body>
</html>
