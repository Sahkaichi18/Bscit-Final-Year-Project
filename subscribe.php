<?php
@include 'config.php'; // Ensure this file connects to the "login" database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']); 

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["status" => "error", "message" => "Invalid email format!"]);
        exit;
    }

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT id FROM subscribers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "You are already subscribed!"]);
    } else {
        // Insert email into the subscribers table
        $stmt = $conn->prepare("INSERT INTO subscribers (email) VALUES (?)");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Subscription successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to subscribe!"]);
        }
    }
    $stmt->close();
    $conn->close();
}
?>
