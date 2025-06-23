<?php
include 'connect_feedback.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $decorative_wrap = $_POST['decorative_wrap'];

    $sql = "INSERT INTO feedback (name, email, address, subject, message, decorative_wrap) 
            VALUES ('$name', '$email', '$address', '$subject', '$message', '$decorative_wrap')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Feedback submitted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error submitting feedback"]);
    }
}
?>
