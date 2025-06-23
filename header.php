<?php
// Connect to shop_db (for cart, orders, products)
$shop_conn = new mysqli("localhost", "root", "", "shop_db");
if ($shop_conn->connect_error) {
    die("Connection failed to shop_db: " . $shop_conn->connect_error);
}

// Connect to feedback database (for feedback table)
$feedback_conn = new mysqli("localhost", "root", "", "feedback");
if ($feedback_conn->connect_error) {
    die("Connection failed to feedback: " . $feedback_conn->connect_error);
}
?>

<header class="admin-header">
    <a href="admin.php"><img src="Images/logo (2).jpg" class="logo" alt="Logo"></a>

    <div class="nav-container">
        <ul>
            <li><a class="active" href="admin.php">Add Product</a></li>
            <li><a href="adminblog.php">Add Blogs</a></li>
            <li><a href="Users.php">Users</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="Subscribers.php">Subscribers</a></li>
            <li><a href="admin_feedback.php">Feedback</a></li>
        </ul>
    </div>
</header>
