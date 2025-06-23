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
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search for products..." required>
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
            </li>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a class="active" href="about.html">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="cart.php" class="cart-icon"><i class="fa fa-shopping-cart"></i>
                </a></li>
            </ul>
        </div>
    </section>
    <section id="page-header" class="about-header">
        <h2>#AboutUs</h2>
        <p>Curious to Know about us?</p>
    </section>
    <section id="about-head" class="section-p1">
        <img src="Images/Shop/Republic day.png" alt="">
        <div>
            <h2>Who Are We?</h2>
            <p>Welcome to A1 Tamore Cake House, your trusted destination for exquisite baked delights in Vikramgad, Palghar. 
                Established on March 30, 2022, we have been crafting delicious treats for the past three years, 
                bringing sweetness to every special occasion. <br><br>
                Located at At Post Vikramgad, Main Road, Palghar - 401605, we take pride in offering a wide variety of cakes, 
                pastries, and frozen treats, made with the finest ingredients. 
                Our menu features a selection of customized and personalized cakes, perfect for birthdays, weddings, and celebrations.
                We are also exclusively known for our Ice Cream Rolls, a unique delight available only at our shop. <br><br>
                At A1 Tamore Cake House, we believe in making every moment memorable with our delectable treats. 
                Whether you’re looking for a beautifully crafted cake, a refreshing ice cream, or a delightful pastry, 
                we have something special for you. <br><br>
                Satisfy your sweet cravings today—order online or visit us in-store for a taste of happiness!
            </p>
                <br><br>
                <marquee bgcolor="purple" loop="-1" scrollamount="5" width="100%">We bake it right, great taste in every bite!</marquee>
        </div>
    </section>
    <section id="para" class="section-p1">
         <div>
        <h2>Our Moral Responsibility</h2>
        <h1>Food Safety ISO 2020</h1>
        <p><b><span>Food Processing Sanitation/Hygiene</span></b><br><br>
            The philosophical viewpoint of the Food and Drug Administration is that they would prefer to see industries bring their plants into compliance 
            voluntarily rather than to force compliance through FDA action.
            The government rarely takes legal action against a processor without first making an inspection. 
            The simplest examples are the finding of food products containing whole insects, very large fragments, 
            whole rodent pellets or hairs, or in general, extraneous matter characterized by large size, 
            indicating that the filth did not come from the raw ingredients.<br><br>
            
            <b><span>Our standards</span></b><br><br>
            We are a HACCP & ISO : 22000 certified company. We believe in ensuring the highest degree of sanitation and hygiene. 
            We also follow Good Manufacturing practices levied by the AIB (The American Institute of Baking).<br><br>
            
            <b><span>Our values</span></b><br><br>
            We at A1 Tamore cake house take a moral responsibility of upholding all the Laws levied by the FDA. 
            We believe in using the highest quality of raw materials and ingredients in our manufactured goods. 
            We take pride in our processes which ensure consistency and ensure safety from hazardous mishaps.
            We believe in being honest and fair to all our stake holders. 
            We strictly do not give credit nor encourage the idea of credit related transactions. 
            Our company is a 100% interest free company. 
            One of the very few companies in today’s times which could actually claim to be 100% interest free. 
            We do not take interest not lend on interest.<br><br>
            
            <b><span>Our Belief</span></b><br><br>
            We believe in good intentions in all our practices. For we believe that good intentions will always yield good products and services. 
            If the intent is unworthy there in an inherent flaw from the start.</p>

        </div>
    </section>

    <section id="product1" class="section-p1">
        <h2>Our Promise</h2>
    <div class="features">
        <div class="feature-box">
            <img src="Images/cupcake.jpg" alt="Cupcake">
            <h3>AUTHENTIC RECIPES</h3>
            <p>Our products are based on traditional home-style recipes, using fresh ingredients.</p>
        </div>
        <div class="feature-box">
            <img src="Images/heart.jpg" alt="Heart">
            <h3>BAKED WITH LOVE</h3>
            <p>Our passion for baking is poured into every recipe, serving smiles on a plate every day.</p>
        </div>
        <div class="feature-box">
            <img src="Images/pricetag.jpg" alt="Price Tag">
            <h3>HONESTLY PRICED</h3>
            <p>We constantly strive to offer the best products at the right prices.</p>
        </div>
        <div class="feature-box">
            <img src="Images/cupcake1.jpg" alt="Cupcake">
            <h3>COMMITTED TO QUALITY</h3>
            <p>From our ingredients to our kitchen operations & guest services, we always prioritize quality.</p>
        </div>
    </div>
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
    .then(response => response.json()) 
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