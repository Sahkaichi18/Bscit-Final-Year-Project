<?php
@include 'config.php';
session_start(); 

// Initialize discount
$discount_percentage = 0;

// Apply coupon
if(isset($_POST['apply_coupon'])){
    $coupon_code = $_POST['coupon_code'];
    if($coupon_code == "A1Tamore2025"){ 
        $_SESSION['coupon'] = "A1Tamore2025"; 
        $_SESSION['discount_percentage'] = 20;
        $_SESSION['cart_success_message'] = "Discount coupon code applied!";
    } else {
        $_SESSION['cart_error_message'] = "Invalid Coupon Code!";
        unset($_SESSION['coupon']); 
        unset($_SESSION['discount_percentage']);
    }
}

// Update quantity
if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE cart SET quantity = '$update_value' WHERE id = '$update_id'");
   if($update_quantity_query){
      $_SESSION['cart_success_message'] = "Product's quantity updated!";
      header('location:cart.php');
      exit();
   }
}

// Remove item from cart
if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM cart WHERE id = '$remove_id'");
   $_SESSION['cart_success_message'] = "Product deleted from the cart!";
   header('location:cart.php');
   exit();
}

// Delete all items from cart
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM cart");
   unset($_SESSION['coupon']); 
   unset($_SESSION['discount_percentage']);
   $_SESSION['cart_success_message'] = "All products deleted from the cart!";
   header('location:cart.php');
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" contents="width=device-width, initial-scale=1.0">
    <title> E-Commerce Website For Sweet Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php if(isset($_SESSION['cart_success_message'])): ?>
    <div class="cart-message-box cart-success">
        <p><?php echo $_SESSION['cart_success_message']; ?></p>
        <i class="fas fa-times cart-close-message" onclick="this.parentElement.style.display='none';"></i>
    </div>
    <?php unset($_SESSION['cart_success_message']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['cart_error_message'])): ?>
    <div class="cart-message-box cart-error">
        <p><?php echo $_SESSION['cart_error_message']; ?></p>
        <i class="fas fa-times cart-close-message" onclick="this.parentElement.style.display='none';"></i>
    </div>
    <?php unset($_SESSION['cart_error_message']); ?>
<?php endif; ?>

<section id="header">
    <a href="about.php"><img src="Images/logo (2).jpg" class="logo" alt=""></a>
    <div>
        <ul id="navbar">
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search for products..." required>
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
            <li><a href="index.php">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="blog.php">Blog</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a class="active" href="cart.php" class="cart-icon"><i class="fa fa-shopping-cart"></i></a></li>
        </ul>
    </div>
</section>
<section id="page-header" class="cart-header">
    <h2>#AddToCart</h2>
    <p>Fill up your cart!</p>
</section>
<section id="cart" class="section-p1">
    <h1 class="heading">Shopping Cart</h1>
    <table width="100%">
        <thead>
            <th>Image</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Action</th>
        </thead>
        <tbody>
            <?php 
            $select_cart = mysqli_query($conn, "SELECT * FROM cart");
            $grand_total = 0;
            if(mysqli_num_rows($select_cart) > 0){
                while($fetch_cart = mysqli_fetch_assoc($select_cart)){
                    $sub_total = floatval($fetch_cart['price']) * intval($fetch_cart['quantity']);
                    $grand_total += $sub_total;
            ?>
            <tr>
                <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
                <td><?php echo $fetch_cart['name']; ?></td>
                <td>₹<?php echo number_format($fetch_cart['price']); ?>/-</td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                        <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                        <input type="submit" value="Update" name="update_update_btn">
                    </form>   
                </td>
                <td>₹<?php echo number_format($sub_total); ?>/-</td>
                <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> Remove</a></td>
            </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
    <form action="" method="post" class="coupon-form">
    <input type="text" name="coupon_code" placeholder="Enter Coupon Code" required>
    <button type="submit" name="apply_coupon">Apply Coupon</button>
</form>

<?php
if(isset($_SESSION['discount_percentage'])){
    $discount_percentage = $_SESSION['discount_percentage'];
    $discount_amount = ($grand_total * $discount_percentage) / 100;
    $grand_total -= $discount_amount;
    echo "<p class='discount-message'>Discount Applied: -₹".number_format($discount_amount)."</p>";
}
?>
<h3>Grand Total: ₹<?php echo number_format($grand_total); ?>/-</h3>
<a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
<a href="cart.php?delete_all" onclick="return confirm('Are you sure you want to remove all items from the cart?')" class="delete-all-btn">Delete All</a>


</section>
<footer class="section-p1">
        <div class="col">
            <img class="logo" src="Images/logo (2).jpg" alt="">
            <h4>Contact</h4>
            <p><strong>Address : </strong> At Post Vikramgad, Main Road, Palghar, Maharashtra 401605</p>
            <p><strong>Phone : </strong> (+91)8976961783</p>
            <p><strong>Hours : </strong> 10:00am - 18:00pm, Mon - Sat</p>
            <div class="follow">
                <h4>Follow us</h4>
                <div class="icon">
                    <a href="https://www.instagram.com/a1_tamore_cake_house/" target="_blank">
                         <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://pin.it/4QooToZAU" target="_blank">
                        <i class="fab fa-pinterest"></i>
                    </a>
                    <a href="https://youtube.com/@a1tamorecakehouse401?si=i2676jBKnAiwBwrL" target="_blank">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <h4>About</h4>
            <a href="about.php">About us</a>
            <a href="contact.html">Contact Us</a>
        </div>
        <div class="col">
            <h4>My Account</h4>
            <a href="LoginRegistration.php">Sign In</a>
            <a href="cart.php">View Cart</a>
            <a href="order_tracking.php">Track My Order</a>
            <a href="logout.php">Logout</a>
        </div>
        <div class="copyright">
            <p>All Rights Reserved. Copyright © 2025 A1 Tamore Cake House</p> 
        </div>
    </footer>
<script src="script.js"></script>
</body>
</html>