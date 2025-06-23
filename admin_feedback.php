<?php
@include 'header.php';
 // Use correct database connection

$query = "SELECT * FROM feedback";
@include 'connect_feedback.php'; // Ensure the connection file is included
$result = mysqli_query($conn, $query) or die('Query Failed: ' . mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Feedback</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
session_start();
if (isset($_SESSION['message'])) {
    echo "<div class='message'>".$_SESSION['message']." <i onclick='this.parentElement.style.display=\"none\";'>&times;</i></div>";
    unset($_SESSION['message']); // Clear message after displaying
}
?>


<div class="admin-feedback-container">
    <h2>Customer Feedback</h2>
    <table class="admin-feedback-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Decorative Wrap</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['subject']; ?></td>
                    <td><?php echo $row['message']; ?></td>
                    <td><?php echo $row['decorative_wrap']; ?></td>
                    <td>
                        <form action="delete_feedback.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                            <input type="hidden" name="feedback_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php
$feedback_conn->close();
?>
