<?php
// Connect to the database
$conn = new mysqli("localhost", "root", "", "shop_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the URL
$search = isset($_GET['query']) ? trim($_GET['query']) : '';
$search = $conn->real_escape_string($search);

// Search in products table
$sql = "SELECT * FROM products WHERE name LIKE '%$search%' OR category LIKE '%$search%' OR description LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css"> <!-- Ensure this is linked to your main CSS -->
</head>
<body>

    <section class="products">
        <h2 class="heading">Search Results for "<?php echo htmlspecialchars($search); ?>"</h2>
        <div class="box-container">
            <?php if ($result->num_rows > 0) { ?>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="box">
                        <a href="SingleProduct.php?id=<?php echo $row['id']; ?>">
                            <?php
                            // Mapping category to its respective folder
                            $categoryFolders = [
                                "cake" => "Cake img",
                                "donut" => "Donuts img",
                                "ice cream" => "Ice cream img",
                                "pastry" => "Pastry img"
                            ];
                            
                            $folder = isset($categoryFolders[$row['category']]) ? $categoryFolders[$row['category']] : "default";
                            ?>
                            <img src="Images/<?php echo $folder; ?>/<?php echo $row['image']; ?>" 
                                 alt="<?php echo htmlspecialchars($row['name']); ?>">
                        </a>
                        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                        <span><?php echo ucfirst($row['category']); ?></span>
                        <div class="price">₹<?php echo number_format($row['price'], 2); ?></div>
                        <a href="SingleProduct.php?id=<?php echo $row['id']; ?>" class="btn">View Product</a>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p id="no-results">No results found for "<?php echo htmlspecialchars($search); ?>"</p>
            <?php } ?>
        </div>
    </section>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
