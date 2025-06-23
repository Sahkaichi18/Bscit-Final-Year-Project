<?php
@include 'header.php';

$conn = new mysqli("localhost", "root", "", "login");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<?php if (isset($_GET['deleted'])): ?>
    <div class="user-message-container <?php echo ($_GET['deleted'] == 'success') ? 'success' : 'error'; ?>">
        <span><?php echo ($_GET['deleted'] == 'success') ? 'User deleted successfully!' : 'Error deleting user!'; ?></span>
        <i onclick="this.parentElement.style.display='none';">✖</i>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Logged-in</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="users-container">
        <h2>Users Logged-in</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone Number</th>
                    <th>Date of Birth</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Action</th> 
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT id, firstName, lastName, phoneNumber, dob, email, is_admin FROM users";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['firstName'] . "</td>";
                        echo "<td>" . $row['lastName'] . "</td>";
                        echo "<td>" . $row['phoneNumber'] . "</td>";
                        echo "<td>" . $row['dob'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . ($row['is_admin'] ? '<span style="color: red; font-weight: bold;">Admin</span>' : 'User') . "</td>";
                        echo "<td>
                            <form action='delete_user.php' method='POST' onsubmit='return confirm(\"Are you sure you want to delete this user?\")'>
                                <input type='hidden' name='user_id' value='" . $row['id'] . "'>
                                <button type='submit' class='delete-btn'>Delete</button>
                            </form>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='empty'>No users found</td></tr>";
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
