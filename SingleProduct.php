<?php
session_start();
@include 'config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        $_SESSION['cart_message'] = "Product not found!";
        header("Location: menu.php");
        exit();
    }
    $stmt->close();
} else {
    $_SESSION['cart_message'] = "Invalid product!";
    header("Location: menu.php");
    exit();
}

if (isset($_POST['add_to_cart'])) {
    $product_name = $product['name'];
    $product_price = floatval($_POST['product_price']);
    $product_image = $product['image'];
    $product_size = $_POST['product_size'] ?? '1/2 kg';

    $stmt = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND size = ?");
    $stmt->bind_param("ss", $product_name, $product_size);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE `cart` SET quantity = quantity + 1 WHERE name = ? AND size = ?");
        $stmt->bind_param("ss", $product_name, $product_size);
        $_SESSION['cart_message'] = "Quantity updated in cart!";
    } else {
        $stmt = $conn->prepare("INSERT INTO `cart` (name, price, image, quantity, size) VALUES (?, ?, ?, 1, ?)");
        $stmt->bind_param("sdss", $product_name, $product_price, $product_image, $product_size);
        $_SESSION['cart_message'] = "Product added to cart!";
    }
    $stmt->execute();
    $stmt->close();
    
    header("Location: SingleProduct.php?id=" . $product_id);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?> | Product Details</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function updatePrice() {
            let basePrice = parseFloat(<?php echo json_encode($product['price']); ?>) || 0;
            let sizeMultiplier = parseFloat(document.getElementById("size").value) || 1;
            let newPrice = basePrice * sizeMultiplier;
            
            document.getElementById("price").innerText = "₹" + newPrice.toFixed(2) + "/-";
            document.getElementById("product_price").value = newPrice.toFixed(2);
        }

        function closeCartMessage() {
            let messageBox = document.querySelector('.cart-message-box');
            if (messageBox) {
                messageBox.style.animation = "fadeOut 0.3s ease-in-out";
                setTimeout(() => messageBox.remove(), 300);
            }
        }
    </script>
</head>
<body>
    <?php if (isset($_SESSION['cart_message'])): ?>
        <div class="cart-message-box">
            <?php echo $_SESSION['cart_message']; ?>
            <i onclick="closeCartMessage()">&times;</i>
        </div>
        <?php unset($_SESSION['cart_message']); ?>
    <?php endif; ?>
    
    <div class="product-page">
        <section id="product-details">
            <div class="product-image">
                <img src="uploaded_img/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            </div>
            <div class="product-info">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <h3 id="price">₹<?php echo number_format($product['price'], 2); ?>/-</h3>
                <p class="product-description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                
                <form action="" method="post">
                    <input type="hidden" id="product_price" name="product_price" value="<?php echo number_format($product['price'], 2); ?>">
                    
                    <?php if ($product['category'] == 'cake') { ?>
                        <label for="size">Select Size:</label>
                        <select name="product_size" id="size" onchange="updatePrice()">
                            <option value="1">1/2 kg</option>
                            <option value="2">1 kg</option>
                            <option value="4">2 kg</option>
                            <option value="6">3 kg</option>
                        </select>
                    <?php } ?>
                    <br><br>
                    <button type="submit" name="add_to_cart" class="add-to-cart-btn">Add to Cart</button>
                </form>
                <br>
                <a href="menu.php" class="back-btn">Back to Menu</a>
            </div>
        </section>
    </div>
    
    <script>
        setTimeout(() => {
            let msg = document.querySelector('.cart-message-box');
            if (msg) msg.style.animation = "fadeOut 0.3s ease-in-out";
            setTimeout(() => msg.remove(), 300);
        }, 3000);
        function closeCartMessage() {
        let messageBox = document.querySelector('.cart-message-box');
        if (messageBox) {
            messageBox.style.animation = "fadeOut 0.3s ease-in-out";
            setTimeout(() => messageBox.remove(), 300);
        }
    }
    </script>
</body>
</html>
