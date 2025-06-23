<?php
@include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['subscriber_id'])) {
    $conn = new mysqli("localhost", "root", "", "shop_db");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $subscriber_id = $_POST['subscriber_id'];
    $delete_query = "DELETE FROM `subscribers` WHERE id = '$subscriber_id'";

    if (mysqli_query($conn, $delete_query)) {
        header("Location: Subscribers.php?deleted=success");
    } else {
        header("Location: Subscribers.php?deleted=error");
    }

    $conn->close();
}
?>
