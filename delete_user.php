<?php
$conn = new mysqli("localhost", "root", "", "login");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user_id"])) {
    $user_id = intval($_POST["user_id"]);
    
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        header("Location: Users.php?deleted=success");
        exit();
    } else {
        header("Location: Users.php?deleted=error");
        exit();
    }
    
    $stmt->close();
}
$conn->close();
?>
