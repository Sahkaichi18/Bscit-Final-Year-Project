<?php
session_start();
@include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_id = $_POST['payment_id'];
    $status = $_POST['status'] ?? 'Pending';

    // Update the order in the database
    $update_query = "UPDATE `order` 
                     SET payment_id = '$payment_id', status = '$status' 
                     WHERE payment_id IS NULL AND method = 'Razorpay' 
                     ORDER BY id DESC LIMIT 1";

    if (mysqli_query($conn, $update_query)) {
        error_log("Order updated successfully for Payment ID: $payment_id");
        echo "Order updated successfully";
    } else {
        // If no rows were updated, insert a new order
        $name = $_POST['name'];
        $email = $_POST['email'];
        $number = $_POST['number'];
        $method = $_POST['method'];
        $flat = $_POST['flat'];
        $street = $_POST['street'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $pin_code = $_POST['pin_code'];
        $total_product = $_POST['total_product'];
        $final_price = $_POST['final_price'];

        $insert_query = "INSERT INTO `order` 
                         (name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price, payment_id, status)
                         VALUES 
                         ('$name', '$number', '$email', '$method', '$flat', '$street', '$city', '$state', '$country', '$pin_code', '$total_product', '$final_price', '$payment_id', '$status')";

        if (mysqli_query($conn, $insert_query)) {
            error_log("Order inserted successfully for Payment ID: $payment_id");
            echo "Order inserted successfully";
        } else {
            error_log("Error inserting order for Payment ID: $payment_id - " . mysqli_error($conn));
            echo "Error: Unable to process your order. Please try again.";
        }
    }
}
?>