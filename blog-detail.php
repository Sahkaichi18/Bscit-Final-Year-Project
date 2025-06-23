<?php
include 'config.php'; 
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT title, content, image, created_at FROM blog WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $title = htmlspecialchars($row['title']);
        $content = nl2br(htmlspecialchars($row['content']));
        $image = htmlspecialchars($row['image']);
        $created_at = date('F j, Y', strtotime($row['created_at']));
        if (strpos($image, 'Cake img/') === 0) {
            $imagePath = "Images/Cake img/" . basename($image);
        } elseif (strpos($image, 'Pastry img/') === 0) {
            $imagePath = "Images/Pastry img/" . basename($image);
        } elseif (strpos($image, 'Donuts img/') === 0) {
            $imagePath = "Images/Donuts img/" . basename($image);
        } elseif (strpos($image, 'Ice cream img/') === 0) {
            $imagePath = "Images/Ice cream img/" . basename($image);
        } else {
            $imagePath = "Images/default.jpg"; 
        }
    } else {
        die("<p class='error-message'>Blog post not found!</p>");
    }
} else {
    die("<p class='error-message'>Invalid blog post!</p>");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section id="blog-page-header">
        <h2>Blog</h2>
    </section>

    <div class="blog-detail-container">
        <h1 class="blog-detail-title"><?php echo $title; ?></h1>
        <p class="blog-detail-meta"><small>Published on <?php echo $created_at; ?></small></p>
        <img src="<?php echo $imagePath; ?>" alt="Blog Image" class="blog-detail-image">
        <p class="blog-detail-content"><?php echo $content; ?></p>
    </div>
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

</body>
</html>
