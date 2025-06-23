<?php
@include 'config.php';
if(isset($_POST['add_to_cart'])){
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = 1;
   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");
   if(mysqli_num_rows($select_cart) > 0){
      $message[] = 'product already added to cart';
   }else{
      $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
      $message[] = 'product added to cart succesfully';
   }

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
<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};
?>
<section id="header">
        <a href="about.php"><img src="Images/logo (2).jpg" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search for products..." required>
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
            </li>
                <li><a href="index.php">Home</a></li>
                <li><a class="active" href="menu.php">Menu</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="cart.php" class="cart-icon"><i class="fa fa-shopping-cart"></i>
                </a></li>
            </ul>
        </div>
    </section>
    <section id="page-header">
        <h2>#stayhome</h2>
        <p>Save more with coupons & upto 20% off! </p>
    </section>
<div class="container">
<section class="products">
   <h1 class="heading">Donuts</h1>
   <div class="box-container">
   <?php
@include 'config.php';
$select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 20 OFFSET 40");
if (mysqli_num_rows($select_products) > 0) {
    while ($fetch_product = mysqli_fetch_assoc($select_products)) {
?>
        <form action="" method="post">
            <div class="box">
                <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">
                <h3><a href="SingleProduct.php?id=<?php echo $fetch_product['id']; ?>"><?php echo $fetch_product['name']; ?></a></h3>
                </a>
                <div class="price">₹<?php echo $fetch_product['price']; ?>/-</div>
                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                <a href="SingleProduct.php?id=<?php echo $fetch_product['id']; ?>" class="btn">View Product</a>
            </div>
        </form>
<?php
    }
}
?>

   </div>
</section>
</div>
    <section id="pagination" class="section-p1">
        <a href="menu.php">1</a>
        <a href="menu2.php">2</a>
        <a href="menu3.php">3</a>
        <a href="menu4.php"><i class="fas fa-long-arrow-alt-right"></i></a>
    </section>
    <section id="newsletter" class="section-p1 section-m1">
    <div class="newstext">
        <h4>Sign Up For Newsletters</h4>
        <p>Get E-mail updates about our latest product and <span>special offers</span></p>
    </div>
    <div class="form">
        <input type="email" id="emailInput" placeholder="Your email address" required>
        <button class="normal" id="subscribeBtn">Subscribe</button>
    </div>
    <p id="subscribeMessage" style="color: green; font-weight: bold; display: none;"></p>
</section>
<script>
document.getElementById("subscribeBtn").addEventListener("click", function () {
    let email = document.getElementById("emailInput").value;
    fetch("subscribe.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "email=" + encodeURIComponent(email)
    })
    .then(response => response.json())  // Expecting JSON response
    .then(data => {
        let messageElement = document.getElementById("subscribeMessage");
        messageElement.style.display = "block";
        messageElement.style.color = data.status === "success" ? "#39FF14" : "red";
        messageElement.innerText = data.message;
    })
    .catch(error => console.error("Error:", error));
});
</script>
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