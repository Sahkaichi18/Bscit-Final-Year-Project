<?php
@include 'header.php';
$conn = new mysqli("localhost", "root", "", "shop_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php if (isset($_GET['deleted'])): ?>
    <div class="subscriber-message-container <?php echo ($_GET['deleted'] == 'success') ? 'success' : 'error'; ?>">
        <span><?php echo ($_GET['deleted'] == 'success') ? 'Subscriber deleted successfully!' : 'Error deleting subscriber!'; ?></span>
        <i onclick="this.parentElement.style.display='none';">✖</i>
    </div>
<?php endif; ?>

<div class="subscribers-container">
    <h2>Subscribers</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Subscribed At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id, email, subscribed_at FROM subscribers ORDER BY subscribed_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['subscribed_at'] . "</td>";
                    echo "<td>
                            <form action='delete_subscriber.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this subscriber?\");'>
                                <input type='hidden' name='subscriber_id' value='" . $row['id'] . "'>
                                <button type='submit' class='delete-btn'>Delete</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='empty'>No subscribers found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php
$conn->close();
?>
