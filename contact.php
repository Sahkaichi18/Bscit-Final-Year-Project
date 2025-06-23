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
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search for products..." required>
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
            </li>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a class="active" href="contact.php">Contact</a></li>
                <li><a href="cart.php" class="cart-icon"><i class="fa fa-shopping-cart"></i>
                </a></li>
            </ul>
        </div>
    </section>
    <section id="page-header" class="contact-header">
        <h2>#ContactUs</h2>
        <p>We would love to hear from you. Share your thoughts with us!</p>
    </section>
    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>GET IN TOUCH</span>
            <h2>Visit our shop or contact us today</h2>
            <h3>Location and other details</h3>
            <div>
                <li>
                   <i class="fas fa-map"></i>
                   <p>At Post Vikramgad, Main Road, Palghar, Maharashtra 401605</p>
                </li>
                <li>
                    <i class="far fa-envelope"></i>
                    <p>adityatamore92@gmail.com</p>
                 </li>
                 <li>
                    <i class="fas fa-phone-alt"></i>
                    <p>(+91)8976961783</p>
                 </li>
                 <li>
                    <i class="far fa-clock"></i>
                    <p>Monday to Saturday : 10:00am to 18:00pm</p>
                 </li>
            </div>
        </div>
        <div class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3397.1889834051663!2d73.09069037726266!3d19.796917781427886!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be76bc73ca40913%3A0x3e67e2846b93080c!2sA1%20Tamore%20Cake%20House!5e1!3m2!1sen!2sin!4v1735505439093!5m2!1sen!2sin" 
            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
    <section id="form-details">
    <form action="feedback.php" method="POST">
        <h2>We are intrigued about you!</h2>
        <h3>LEAVE A MESSAGE REGARDING CUSTOMISED ORDERS OR HOW YOU FEEL ABOUT US?</h3>
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="text" name="address" placeholder="Your address" required>
        <input type="text" name="subject" placeholder="Subject" required>
        <textarea name="message" cols="30" rows="10" placeholder="Your Message" required></textarea>
        <label>Decorative Wrap:</label>
         <input type="radio" name="decorative_wrap" value="Yes" required> Yes
         <input type="radio" name="decorative_wrap" value="No" required> No
        <button type="submit" class="normal">Submit</button>
    </form>
        <div class="people">
            <div>
                <img src="Images/Aditya.png" alt="">
                <p><span>Aditya Tamore</span> Chef and the owner of shop <br> Phone :(+91)8976961783 <br> Email : adityatamore92@gmail.com</p>
            </div>
            <div>
                <img src="Images/Pagal.png" alt="">
                <p><span>Sayli Tamore</span> Manager of shop <br> Phone :(+91)8828393202 <br> Email : saylibhosale2299@gmail.com</p>
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
<script>
document.querySelector("#form-details form").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent default form submission

    let formData = new FormData(this);

    fetch("feedback.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json()) // Expecting JSON response
    .then(data => {
        let messageBox = document.createElement("div");
        messageBox.className = "feedback-message";
        messageBox.innerHTML = `<i class="fas fa-times"></i> ${data.message}`;

        document.body.appendChild(messageBox);

        // Close message when clicking on 'X'
        messageBox.querySelector("i").addEventListener("click", () => {
            messageBox.remove();
        });

        // Auto remove after 3 seconds
        setTimeout(() => {
            messageBox.remove();
        }, 3000);
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