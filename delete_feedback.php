<?php
@include 'connect_feedback.php'; // Ensure the connection file is included
session_start(); // Start session to store messages

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback_id'])) {
    $feedback_id = $_POST['feedback_id'];

    if ($stmt = $conn->prepare("DELETE FROM feedback WHERE id = ?")) {
        $stmt->bind_param("i", $feedback_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "Feedback deleted successfully!";
        } else {
            $_SESSION['message'] = "Failed to delete feedback.";
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = "Failed to prepare the delete statement.";
    }

    header("Location: admin_feedback.php");
    exit(); // Stop further execution
}
?>
