<?php
include("db.php");

// Get the blog ID from the query parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch the blog post data
    $query = "SELECT * FROM blog WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blog = $result->fetch_assoc();
    $stmt->close();

    // Handle form submission to update the blog
    if (isset($_POST['update'])) {
        $blogname = $_POST['blogname'];
        $objective = $_POST['objective'];
        $content = $_POST['content'];
        
        $updateQuery = "UPDATE blog SET blogname = ?, objective = ?, content = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssi", $blogname, $objective, $content, $id);
        
        if ($stmt->execute()) {
            // Redirect to index.php after successful update
            header("Location: index.php");
            exit(); // Important: exit to stop further execution after redirection
        } else {
            echo "<div class='alert alert-danger'>Failed to update blog.</div>";
        }
        $stmt->close();
    }
} else {
    echo "<div class='alert alert-danger'>No blog ID specified.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2>Edit Blog</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="blogname" class="form-label">Blog Title</label>
                <input type="text" class="form-control" name="blogname" id="blogname" value="<?= htmlspecialchars($blog['blogname']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="objective" class="form-label">Objective</label>
                <textarea class="form-control" name="objective" id="objective" required><?= htmlspecialchars($blog['objective']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" name="content" id="content" required><?= htmlspecialchars($blog['content']) ?></textarea>
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update Blog</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>