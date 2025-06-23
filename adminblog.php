<?php
include 'config.php';
@include 'header.php';

// Handle adding a new blog post
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_blog'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    $target_dir = "Images/" . $category . "/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $image_path = "";
    if (!empty($_FILES["image"]["name"])) {
        $image = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $category . "/" . $image;
        } else {
            echo "<p style='color:red;'>Error uploading the image.</p>";
        }
    }

    if (!empty($image_path)) {
        $query = "INSERT INTO blog (title, content, image, created_at) VALUES ('$title', '$content', '$image_path', NOW())";
        if (mysqli_query($conn, $query)) {
            header("Location: adminblog.php?success=1");
            exit();
        } else {
            echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
}

// Handle deleting a blog post
if (isset($_GET['delete_id'])) {
    $blog_id = $_GET['delete_id'];

    // Fetch image path before deleting
    $query = "SELECT image FROM blog WHERE id = $blog_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $image_path = "Images/" . $row['image'];
        if (file_exists($image_path)) {
            unlink($image_path); // Delete the image file
        }

        // Delete the blog entry from the database
        $delete_query = "DELETE FROM blog WHERE id = $blog_id";
        if (mysqli_query($conn, $delete_query)) {
            header("Location: adminblog.php?deleted=1");
            exit();
        } else {
            echo "<p style='color:red;'>Error deleting blog: " . mysqli_error($conn) . "</p>";
        }
    }
}

// Fetch all blogs
$fetch_blogs = mysqli_query($conn, "SELECT * FROM blog ORDER BY created_at DESC");

// Handle editing a blog post
$edit_blog = null;
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_query = "SELECT * FROM blog WHERE id = $edit_id";
    $edit_result = mysqli_query($conn, $edit_query);
    $edit_blog = mysqli_fetch_assoc($edit_result);
}

// Handle updating a blog post
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_blog'])) {
    $edit_id = $_POST['edit_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $update_query = "UPDATE blog SET title='$title', content='$content' WHERE id=$edit_id";
    if (mysqli_query($conn, $update_query)) {
        header("Location: adminblog.php?updated=1");
        exit();
    } else {
        echo "<p style='color:red;'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog | Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php if (isset($_GET['success'])): ?>
    <div class="blog-message-container success">
        <span>Blog added successfully!</span>
        <i onclick="this.parentElement.style.display='none';">✖</i>
    </div>
<?php endif; ?>

<?php if (isset($_GET['updated'])): ?>
    <div class="blog-message-container success">
        <span>Blog updated successfully!</span>
        <i onclick="this.parentElement.style.display='none';">✖</i>
    </div>
<?php endif; ?>

<?php if (isset($_GET['deleted'])): ?>
    <div class="blog-message-container error">
        <span>Blog deleted successfully!</span>
        <i onclick="this.parentElement.style.display='none';">✖</i>
    </div>
<?php endif; ?>



    <section id="add-blog">
        <h2>Add New Blog Post</h2>
        <form action="adminblog.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="add_blog" value="1">
            
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="content">Content:</label>
            <textarea name="content" id="content" rows="5" required></textarea>

            <label for="category">Category:</label>
            <select name="category" id="category" required>
                <option value="Cake img">Cake</option>
                <option value="Pastry img">Pastry</option>
                <option value="Donuts img">Donut</option>
                <option value="Ice cream img">Ice Cream</option>
            </select>

            <label for="image">Upload Image:</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <button type="submit">Add Blog</button>
        </form>
    </section>

    <section id="blog-list">
        <h2>All Blogs</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($fetch_blogs)) { ?>
                    <tr>
                        <td><img src="Images/<?php echo htmlspecialchars($row['image']); ?>" width="100"></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo substr(htmlspecialchars($row['content']), 0, 100) . '...'; ?></td>
                        <td>
                            <a href="adminblog.php?edit_id=<?php echo $row['id']; ?>">Edit</a>
                            <a href="adminblog.php?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this blog?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>

    <?php if ($edit_blog): ?>
    <section id="edit-blog">
        <h2>Edit Blog Post</h2>
        <form action="adminblog.php" method="POST">
            <input type="hidden" name="edit_id" value="<?php echo $edit_blog['id']; ?>">
            <input type="hidden" name="update_blog" value="1">

            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($edit_blog['title']); ?>" required>

            <label for="content">Content:</label>
            <textarea name="content" id="content" rows="5" required><?php echo htmlspecialchars($edit_blog['content']); ?></textarea>

            <div class="edit-buttons">
                <button type="submit" class="update-btn">Update Blog</button>
                <a href="adminblog.php" class="cancel-btn">Cancel</a>
            </div>
        </form>
    </section>
    <?php endif; ?>
</body>
</html>
