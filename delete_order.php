<?php
@include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'])) {
    $shop_conn = new mysqli("localhost", "root", "", "shop_db");
    
    if ($shop_conn->connect_error) {
        die("Connection failed: " . $shop_conn->connect_error);
    }

    $order_id = $_POST['order_id'];
    $delete_query = "DELETE FROM `order` WHERE id = '$order_id'";

    if (mysqli_query($shop_conn, $delete_query)) {
        header("Location: orders.php?deleted=success");
    } else {
        header("Location: orders.php?deleted=error");
    }

    $shop_conn->close();
}
?>
