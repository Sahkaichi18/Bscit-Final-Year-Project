<?php
session_start();
@include 'config.php';
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}
if(isset($_POST['order_btn'])){
   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   $flat = $_POST['flat'];
   $street = $_POST['street'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $country = $_POST['country'];
   $pin_code = $_POST['pin_code'];
   $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
   $price_total = 0;
   $product_name = [];
   if(mysqli_num_rows($cart_query) > 0){
      while($product_item = mysqli_fetch_assoc($cart_query)){
         $product_name[] = $product_item['name'] .' ('. $product_item['quantity'] .') ';
         $product_price = floatval($product_item['price']) * intval($product_item['quantity']);
         $price_total += $product_price;
      }
   }
   $discount_amount = 0;
   if(isset($_SESSION['coupon']) && isset($_SESSION['discount_percentage'])){
       $discount_amount = ($price_total * $_SESSION['discount_percentage']) / 100;
   }
   $final_price = $price_total - $discount_amount;

   $total_product = implode(', ', $product_name);
   $detail_query = mysqli_query($conn, "INSERT INTO `order`
      (name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) 
      VALUES
      ('$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','$total_product','$final_price')") 
      or die('query failed');
      if ($cart_query && $detail_query) {
         // Store order details in session variables
         $_SESSION['order_details'] = [
             'total_product' => $total_product,
             'final_price' => $final_price,
             'name' => $name,
             'number' => $number,
             'email' => $email,
             'address' => "$flat, $street, $city, $state, $country - $pin_code",
             'method' => $method
         ];
     
         // Redirect to payment_success.php
         header("Location: payment_success.php");
         exit();
     }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">
</head>
<body> 
<section id="header">
        <a href="#"><img src="Images/logo (2).jpg" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search for products..." required>
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
            </li>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a class="active" href="cart.php" class="cart-icon"><i class="fa fa-shopping-cart"></i></a></li>
            </ul>
        </div>
    </section>
   <div class="container">
      <section class="checkout-form">
         <h1 class="heading">Complete Your Order</h1>
         <form action="" method="post">
            <div class="display-order">
               <?php
                  $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
                  $total = 0;
                  $grand_total = 0;
                  if(mysqli_num_rows($select_cart) > 0){
                     while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                        $total_price = floatval($fetch_cart['price']) * intval($fetch_cart['quantity']);
                        $grand_total += $total_price;
               ?>
               <span><?= $fetch_cart['name']; ?> (<?= $fetch_cart['quantity']; ?>)</span>
               <?php
                     }
                  } else {
                     echo "<div class='display-order'><span>Your cart is empty!</span></div>";
                  }

                  $discount_amount = 0;
                  if(isset($_SESSION['coupon']) && isset($_SESSION['discount_percentage'])){
                      $discount_percentage = $_SESSION['discount_percentage'];
                      $discount_amount = ($discount_percentage / 100) * $grand_total;
                  }
                  $final_total = $grand_total - $discount_amount;
               ?>
               <span class="grand-total">Grand Total: ₹<?= number_format($grand_total); ?>/-</span>
               <?php if($discount_amount > 0): ?>
                  <p style="color: green;">Discount Applied (<?= $discount_percentage; ?>% Off)</p>
                  <p><strong>Final Total: ₹<?= number_format($final_total); ?>/-</strong></p>
               <?php endif; ?>
            </div>

            <div class="flex">
               <div class="inputBox">
                  <span>Your Name</span>
                  <input type="text" placeholder="Enter your name" name="name" required>
               </div>
               <div class="inputBox">
                  <span>Your Number</span>
                  <input type="number" placeholder="Enter your number" name="number" required>
               </div>
               <div class="inputBox">
                  <span>Your Email</span>
                  <input type="email" placeholder="Enter your email" name="email" required>
               </div>
               <div class="inputBox">
                  <span>Payment Method</span>
                  <select name="method">
                     <option value="cash on delivery" selected>Cash on Delivery</option>
                     <option value="Razorpay">Razorpay</option>
                  </select>
               </div>
               <div class="inputBox">
                  <span>Address Line 1</span>
                  <input type="text" placeholder="e.g. Flat No." name="flat" required>
               </div>
               <div class="inputBox">
                  <span>Address Line 2</span>
                  <input type="text" placeholder="e.g. Street Name" name="street" required>
               </div>
               <div class="inputBox">
                  <span>City</span>
                  <input type="text" placeholder="e.g. Mumbai" name="city" required>
               </div>
               <div class="inputBox">
                  <span>State</span>
                  <input type="text" placeholder="e.g. Maharashtra" name="state" required>
               </div>
               <div class="inputBox">
                  <span>Country</span>
                  <input type="text" placeholder="e.g. India" name="country" required>
               </div>
               <div class="inputBox">
                  <span>Pin Code</span>
                  <input type="text" placeholder="e.g. 123456" name="pin_code" required>
               </div>
            </div>
            <input type="submit" value="Order Now" name="order_btn" class="btn">
         </form>

      </section>
   </div>

<script src="js/script.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let paymentMethod = document.querySelector("select[name='method']");
    let orderButton = document.querySelector("input[name='order_btn']");

    orderButton.addEventListener("click", function (event) {
        if (paymentMethod.value === "Razorpay") {
            event.preventDefault(); // Prevent form submission

            let options = {
                "key": "rzp_test_ydqgL6CYQN56aS", // Replace with your Razorpay API key
                "amount": <?= $final_total * 100; ?>, // Amount in paise
                "currency": "INR",
                "name": "SweetShop",
                "description": "Order Payment",
                "image": "Images/logo (2).jpg",
                "handler": function (response) {
                    // Send payment details to the server
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "razorpay_order_handler.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                    let data = `payment_id=${response.razorpay_payment_id}&status=Completed`;

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            // Redirect to payment_success.php after storing the payment details
                            window.location.href = "payment_success.php?payment_id=" + response.razorpay_payment_id;
                        }
                    };

                    xhr.send(data);
                },
                "prefill": {
                    "name": "<?= $_POST['name'] ?? ''; ?>",
                    "email": "<?= $_POST['email'] ?? ''; ?>",
                    "contact": "<?= $_POST['number'] ?? ''; ?>"
                },
                "theme": {
                    "color": "#3399cc"
                },
                "modal": {
                    "ondismiss": function () {
                        alert("Payment process was canceled. Please try again.");
                        window.location.href = "checkout.php";
                    }
                }
            };

            let rzp = new Razorpay(options);
            rzp.open();
        }
    });
});
</script>
</body> 
</html>
