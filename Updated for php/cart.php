<?php

@include 'config.php';

if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");
   if($update_quantity_query){
      header('location:cart.php');
   };
};

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
   header('location:cart.php');
};

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart`");
   header('location:cart.php');
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

   
    <section id="header">
        <a href="#"><img src="Images/logo (2).jpg" class="logo" alt=""></a>

        <div>
            <ul id="navbar">
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a class="active" href="cart.php" class="cart-icon"><i class="fa fa-shopping-cart"></i>
                </a></li>
            </ul>
        </div>
    </section>

    <section id="page-header" class="cart-header">
      
        <h2>#AddToCart</h2>
      
        <p>Fill up your cart!</p>
      
    </section>

    <section id="cart" class="section-p1">
        <table width="100%">
        <h1 class="heading">shopping cart</h1>

<table>

   <thead>
      <th>image</th>
      <th>name</th>
      <th>price</th>
      <th>quantity</th>
      <th>total price</th>
      <th>action</th>
   </thead>

   <tbody>

      <?php 
      
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
      $grand_total = 0;
      if(mysqli_num_rows($select_cart) > 0){
         while($fetch_cart = mysqli_fetch_assoc($select_cart)){
      ?>

      <tr>
         <td><img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" height="100" alt=""></td>
         <td><?php echo $fetch_cart['name']; ?></td>
         <td>₹<?php echo number_format($fetch_cart['price']); ?>/-</td>
         <td>
            <form action="" method="post">
               <input type="hidden" name="update_quantity_id"  value="<?php echo $fetch_cart['id']; ?>" >
               <input type="number" name="update_quantity" min="1"  value="<?php echo $fetch_cart['quantity']; ?>" >
               <input type="submit" value="update" name="update_update_btn">
            </form>   
         </td>
         <td>₹<?php echo $sub_total = number_format($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</td>
         <td><a href="cart.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
      </tr>
      <?php
      $clean_price = filter_var($fetch_cart['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
      $grand_total += floatval($clean_price) * intval($fetch_cart['quantity']);
        $grand_total += $sub_total;  
         };
      };
      ?>
      <tr class="table-bottom">
         <td><a href="menu.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td><!--i changed the products.php to menu.php -->
         <td colspan="3">grand total</td>
         <td>₹<?php echo $grand_total; ?>/-</td>
         <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
      </tr>

   </tbody>

</table>
    <section id="cart-add" class="section-p1">
        <div id="coupon">
            <h3>Apply Coupon</h3>
            <div>
                <input type="text" placeholder="Enter Your Coupon">
                <button class="normal">Apply</button>
            </div>
        </div>
        
        <div class="checkout-btn">
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">procced to checkout</a>
   </div>
           
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
                    <a href="https://www.facebook.com/yourpage" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.twitter.com/yourhandle" target="_blank">
                        <i class="fab fa-twitter"></i>
                    </a>
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
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact Us</a>
        </div>

        <div class="col">
            <h4>My Account</h4>
            <a href="#">Sign In</a>
            <a href="#">View Cart</a>
            <a href="#">My Wishlist</a>
            <a href="#">Track My Order</a>
            <a href="#">Help</a>
        </div>
        <div class="copyright">
            <p>All Rights Reserved. Copyright © 2025 A1 Tamore Cake House</p> 
        </div>
    </footer>


    <script src="script.js"></script>
</body>
</html>