<?php 
include 'connect.php';
session_start();

if(isset($_POST['signUp'])){
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $phoneNumber = $_POST['phone'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); 

    if(isset($_POST['is_admin']) && $email != "sahilbhosale1804@gmail.com"){
        echo "<script>alert('You are not the admin!'); window.location.href='LoginRegistration.php';</script>";
        exit();
    }
    
    $is_admin = ($email == "sahilbhosale1804@gmail.com") ? 1 : 0;

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if($result->num_rows > 0){
        echo "<script>alert('Email Address Already Exists!'); window.location.href='LoginRegistration.php';</script>";
    } else {
        $insertQuery = "INSERT INTO users (firstName, lastName, phoneNumber, dob, email, password, is_admin)
                        VALUES ('$firstName', '$lastName', '$phoneNumber', '$dob', '$email', '$password', '$is_admin')";
        
        if($conn->query($insertQuery) === TRUE){
            echo "<script>alert('Registration Successful! Please log in.'); window.location.href='LoginRegistration.php';</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// LOGIN LOGIC
if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        $_SESSION['is_admin'] = $row['is_admin'];

        echo "<script>alert('Login Successful!');</script>"; // Added login success message
        
        if ($row['is_admin'] == 1) {
            if ($email == "sahilbhosale1804@gmail.com") {
                echo "<script>window.location.href='admin.php';</script>";
            } else {
                echo "<script>alert('You are not the admin!'); window.location.href='LoginRegistration.php';</script>";
                exit();
            }
        } else {
            echo "<script>window.location.href='index.php';</script>";
        }
        exit();
    } else {
        echo "<script>alert('Incorrect Email or Password!'); window.location.href='LoginRegistration.php';</script>";
    }
}
?>
