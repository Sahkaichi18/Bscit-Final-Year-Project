<?php
session_start();
@include 'config.php';

if(isset($_POST['add_product'])){
   $p_name = $_POST['p_name'];
   $p_price = $_POST['p_price'];
   $p_description = mysqli_real_escape_string($conn, $_POST['p_description']);
   $p_image = $_FILES['p_image']['name'];
   $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
   $p_image_folder = 'uploaded_img/'.$p_image;

   $insert_query = mysqli_query($conn, "INSERT INTO `products`(name, price, description, image) VALUES('$p_name', '$p_price', '$p_description', '$p_image')") or die('query failed');

   if($insert_query){
      move_uploaded_file($p_image_tmp_name, $p_image_folder);
      $_SESSION['message'] = 'Product added successfully';
   }else{
      $_SESSION['message'] = 'Could not add the product';
   }
   header('location:admin.php');
   exit();
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id") or die('query failed');
   if($delete_query){
      $_SESSION['message'] = 'Product deleted successfully';
   }
   header('location:admin.php');
   exit();
}

if(isset($_POST['update_product'])){
   $update_p_id = $_POST['update_p_id'];
   $update_p_name = $_POST['update_p_name'];
   $update_p_price = $_POST['update_p_price'];
   $update_p_description = mysqli_real_escape_string($conn, $_POST['update_p_description']);
   $update_p_image = $_FILES['update_p_image']['name'];
   $update_p_image_tmp_name = $_FILES['update_p_image']['tmp_name'];
   $update_p_image_folder = 'uploaded_img/'.$update_p_image;

   if(!empty($update_p_image)){
      $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', price = '$update_p_price', description = '$update_p_description', image = '$update_p_image' WHERE id = '$update_p_id'") or die('query failed');
      move_uploaded_file($update_p_image_tmp_name, $update_p_image_folder);
   } else {
      $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_p_name', price = '$update_p_price', description = '$update_p_description' WHERE id = '$update_p_id'") or die('query failed');
   }

   if($update_query){
      $_SESSION['message'] = 'Product updated successfully';
   }
   header('location:admin.php');
   exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
if(isset($_SESSION['message'])){
   echo '<div class="message"><span>'.$_SESSION['message'].'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;x"></i> </div>';
   unset($_SESSION['message']); // Clear message after showing it
}
?>

<?php include 'header.php'; ?>

<div class="container">

<section class="admin-container">
    <form action="" method="post" enctype="multipart/form-data" class="admin-add-product-form">
        <h3>Add a New Product</h3>
        <input type="text" name="p_name" placeholder="Enter the product name" required>
        <input type="number" name="p_price" placeholder="Enter the product price" min="0" required>
        <textarea name="p_description" placeholder="Enter the product description" rows="4" required></textarea>
        <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" required>
        <button type="submit" name="add_product" class="btn">Add the product</button>
    </form>
</section>

<section class="display-product-table">

   <table>
      <thead>
         <th>Product Image</th>
         <th>Product Name</th>
         <th>Price</th>
         <th>Description</th>
         <th>Action</th>
      </thead>

      <tbody>
         <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            if(mysqli_num_rows($select_products) > 0){
               while($row = mysqli_fetch_assoc($select_products)){
         ?>
         <tr>
            <td><img src="uploaded_img/<?php echo $row['image']; ?>" height="100" alt=""></td>
            <td><?php echo $row['name']; ?></td>
            <td>₹<?php echo $row['price']; ?>/-</td>
            <td><?php echo $row['description']; ?></td>
            <td>
               <a href="admin.php?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this?');"> <i class="fas fa-trash"></i> Delete </a>
               <a href="admin.php?edit=<?php echo $row['id']; ?>" class="option-btn"> <i class="fas fa-edit"></i> Update </a>
            </td>
         </tr>
         <?php
            }
         } else {
            echo "<tr><td colspan='5' class='empty'>No product added</td></tr>";
         }
         ?>
      </tbody>
   </table>

</section>

<section class="edit-form-container">
   <?php
   if(isset($_GET['edit'])){
      $edit_id = $_GET['edit'];
      $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $edit_id");
      if(mysqli_num_rows($edit_query) > 0){
         while($fetch_edit = mysqli_fetch_assoc($edit_query)){
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <img src="uploaded_img/<?php echo $fetch_edit['image']; ?>" height="200" alt="">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_edit['id']; ?>">
      <input type="text" class="box" required name="update_p_name" value="<?php echo $fetch_edit['name']; ?>">
      <input type="number" min="0" class="box" required name="update_p_price" value="<?php echo $fetch_edit['price']; ?>">
      <textarea class="box" required name="update_p_description" rows="4"><?php echo $fetch_edit['description']; ?></textarea>
      <input type="file" class="box" name="update_p_image" accept="image/png, image/jpg, image/jpeg">
      <input type="submit" value="Update Product" name="update_product" class="btn">
      <input type="reset" value="Cancel" id="close-edit" class="option-btn">
   </form>
   <?php
            }
         }
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      }
   ?>
</section>

</div>
<script src="js/script.js"></script>

</body>
</html>
