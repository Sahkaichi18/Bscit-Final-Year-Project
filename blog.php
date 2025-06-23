<?php
include 'config.php'; 
$query = "SELECT id, title, content, image FROM blog ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Delights Blog | A1 Tamore Cake House</title>
    <meta name="description" content="Explore our blog for the latest insights on cake, pastries, and ice cream. Learn how our sweet treats are made!">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section id="header">
        <a href="about.php"><img src="Images/logo (2).jpg" class="logo" alt="A1 Tamore Cake House"></a>
        <div>
            <ul id="navbar">
                <form action="search.php" method="GET" class="search-form">
                    <input type="text" name="query" placeholder="Search for products..." required>
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a class="active" href="blog.php">Blog</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="cart.php" class="cart-icon"><i class="fa fa-shopping-cart"></i></a></li>
            </ul>
        </div>
    </section>
    <section id="page-header" class="blog-header">
        <h2>#ReadMore</h2>
        <p>Discover the secrets behind your favorite sweets!</p>
    </section>
    <section id="blog">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="blog-box">
                <div class="blog-img">
                    <?php 
                    // Determine the correct folder for the image
                    $imagePath = "Images/" . htmlspecialchars($row['image']);
                    ?>
                    <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                </div>
                <div class="blog-details">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><?php echo substr(htmlspecialchars($row['content']), 0, 100) . "..."; ?></p>
                    <a href="blog-detail.php?id=<?php echo $row['id']; ?>" class="read-more">Read More</a>
                </div>
            </div>
        <?php } ?>
    </section>
    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Sign Up For Newsletters</h4>
            <p>Get E-mail updates about our latest products and <span>special offers</span></p>
        </div>
        <div class="form">
            <input type="email" id="emailInput" placeholder="Your email address" required>
            <button class="normal" id="subscribeBtn">Subscribe</button>
        </div>
        <p id="subscribeMessage" style="display: none;"></p>
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
        <p>All Rights Reserved. Copyright © 2025 A1 Tamore Cake House</p>
    </footer>
</body>
</html>