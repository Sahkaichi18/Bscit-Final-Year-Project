<?php
session_start();
@include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Orders</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="admin-header">
    <a href="admin.php"><img src="Images/logo (2).jpg" class="logo" alt="Logo"></a>
    <div class="nav-container">
        <ul>
            <li><a class="active" href="admin.php">Add Product</a></li>
            <li><a href="adminblog.php">Add Blogs</a></li>
            <li><a href="Users.php">Users</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="Subscribers.php">Subscribers</a></li>
            <li><a href="admin_feedback.php">Feedback</a></li>
        </ul>
    </div>
</header>
<div class="container">
    <section class="order-container">
        <h3>Customer Orders</h3>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Products</th>
                    <th>Total Price</th>
                    <th>Payment Method</th>
                    <th>Payment ID</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $shop_conn = new mysqli("localhost", "root", "", "shop_db");
                if ($shop_conn->connect_error) {
                    die("Connection failed to shop_db: " . $shop_conn->connect_error);
                }

                // Fetch orders sorted by latest
                $select_orders = mysqli_query($shop_conn, "SELECT * FROM `order` ORDER BY id ASC") 
                    or die("Query failed: " . mysqli_error($shop_conn));

                if (mysqli_num_rows($select_orders) > 0) {
                    while ($row = mysqli_fetch_assoc($select_orders)) {
                        $order_id = htmlspecialchars($row['id']);
                        $customer_name = htmlspecialchars($row['name']);
                        $products = htmlspecialchars($row['total_products']);
                        $total_price = '₹' . htmlspecialchars($row['total_price']) . '/-';
                        $payment_method = htmlspecialchars($row['method']);
                        $payment_id = htmlspecialchars($row['payment_id']);
                        $address = htmlspecialchars($row['flat'] . ', ' . $row['street'] . ', ' . $row['city'] . ', ' . $row['state'] . ', ' . $row['country'] . ' - ' . $row['pin_code']);
                        $status = htmlspecialchars($row['status']);
                ?>
                <tr>
                    <td><?php echo $order_id; ?></td>
                    <td><?php echo $customer_name; ?></td>
                    <td><?php echo $products; ?></td>
                    <td><?php echo $total_price; ?></td>
                    <td><?php echo $payment_method; ?></td>
                    <td><?php echo (!empty($payment_id)) ? $payment_id : 'N/A'; ?></td>
                    <td><?php echo $address; ?></td>
                    <td>
                        <span style="color: <?php echo ($status === 'Paid') ? 'green' : 'red'; ?>;">
                            <?php echo (!empty($status)) ? $status : 'Pending'; ?>
                        </span>
                    </td>
                    <td>
                        <form action="delete_order.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?')">
                            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='9' class='empty'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</div>
<script src="js/script.js"></script>
</body>
</html>