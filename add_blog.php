<?php
include 'config.php'; // Ensure you have database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO blog (title, content, category, image, created_at) 
                VALUES ('$title', '$content', '$category', '$image', NOW())";

        if (mysqli_query($conn, $sql)) {
            echo "Blog added successfully!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Failed to upload image.";
    }
}
?>
