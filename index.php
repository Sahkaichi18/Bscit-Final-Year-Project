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
        <a href="about.php"><img src="Images/logo (2).jpg" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
            <li class="search-container">
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
                <li><a href="cart.php" class="cart-icon"><i class="fa fa-shopping-cart"></i>
                </a></li>
            </ul>
        </div>
    </section>
    <section id="hero"onclick="window.location.href='menu.php';">
        <h4>Where Every Treat is a Celebration!</h4>
        <h2>Pure Delight</h2>
        <h1>Turning Moments into Sweet Memories</h1>
        <p>Save more with coupons & upto 20% off! </p>
        <button>Buy Now</button>
    </section>
    <div class="menu-container">
    <section class="menu-section">
        <div class="menu-item">
            <a href="menu.php">
                <img src="Images/Cake(Blender edited).png" alt="Cakes">
                <p>Cakes</p>
            </a>
        </div>
        <div class="menu-item">
            <a href="menu2.php">
                <img src="Images/Pastry(Blender edited).png" alt="Pastry">
                <p>Pastry</p>
            </a>
        </div>
        <div class="menu-item">
            <a href="menu3.php">
                <img src="Images/Donut(blender edited).png" alt="Donuts">
                <p>Donuts</p>
            </a>
        </div>
        <div class="menu-item">
            <a href="menu4.php">
                <img src="Images/Ice cream(Blender edited).png" alt="Ice-Cream">
                <p>Ice-Cream</p>
            </a>
        </div>
    </section>
</div>
<section id="product1" class="section-p1">
    <h2>Featured Products</h2>
    <p>Find Your Favourites Here!</p>
    <div class="pro-container">
        <?php
        $featured_products = [
            ["id" => 214, "image" => "Images/Donuts img/Double Trouble Rs 120_processed.jpg", "category" => "Donut", "name" => "Chocolate Donut", "price" => 50],
            ["id" => 91, "image" => "Images/Cake img/Red velvet Rs 575_processed.jpg", "category" => "Cake", "name" => "Designer Red Velvet Round", "price" => 575],
            ["id" => 205, "image" => "Images/Donuts img/Choco Bomb Rs 130_processed.jpg", "category" => "Pastry", "name" => "Choco Bomb", "price" => 130],
            ["id" => 182, "image" => "Images/Pastry img/Black_forest_Rs_85-removebg-preview (1).png", "category" => "Pastry", "name" => "Black Forest", "price" => 80],
            ["id" => 105, "image" => "Images/Cake img/Heavenly Rose Rs 500_processed.jpg", "category" => "Cake", "name" => "Heavenly Rose", "price" => 500],
            ["id" => 184, "image" => "Images/Pastry img/Butterscotch_Rs_65-removebg-preview.png", "category" => "Pastry", "name" => "Butterscotch Cake", "price" => 65],
            ["id" => 110, "image" => "Images/Cake img/Mango Delight Rs350 _processed.jpg", "category" => "Cake", "name" => "Mango Delight", "price" => 350],
            ["id" => 235, "image" => "Images/Ice cream img/Vanilla Rs20.png", "category" => "Ice cream", "name" => "Vanilla Cup", "price" => 20],
        ];   
        foreach ($featured_products as $product) {
        ?>
            <div class="pro">
                <img src="<?php echo $product['image']; ?>" alt="">
                <div class="des">
                    <span><?php echo $product['category']; ?></span>
                    <h5><?php echo $product['name']; ?></h5>
                    <h4>₹<?php echo $product['price']; ?></h4>
                </div>
                <!-- Fixed Link to Pass Correct Product ID -->
                <a href="SingleProduct.php?id=<?php echo $product['id']; ?>" class="view-btn">View Product</a>
            </div>
        <?php
        }
        ?>
    </div>
</section>
    <section id="banner" class="section-m1"onclick="window.location.href='menu.php';"> <!--optional.......and yeah here 2 or 3 more section according to video-->
        <h4>Apply code <span>"A1Tamore2025"</span> and get</h4>
        <h2>Up to <span>20% Off</span> on All Cakes, Pastries, Donuts & Ice-Cream</h2>
        <button class="normal">Explore More</button>
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