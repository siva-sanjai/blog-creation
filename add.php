<?php
include("db.php");

if (isset($_POST['submit'])) {
    // Sanitize and assign form data to variables
    $creatorname = mysqli_real_escape_string($conn, $_POST['creatorname']);
    $dateofpublish = $_POST['dateofpublish'];
    $blogname = mysqli_real_escape_string($conn, $_POST['blogname']);
    $objective = mysqli_real_escape_string($conn, $_POST['objective']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    // Handle file upload
    $file = $_FILES['blogimage']['name'];
    $template = $_FILES['blogimage']['tmp_name'];
    $folder = 'image/' . $file;

    // Check if the file upload is successful
    if (move_uploaded_file($template, $folder)) {
        echo "Image uploaded successfully!";
    } else {
        echo "Image upload failed.";
        $file = ''; // If image upload fails, set $file to an empty string.
    }

    // Prepare the SQL query to insert the form data
    $sql = "INSERT INTO blog (creatorname, publishdate, blogname, objective, content, blogimage) 
            VALUES ('$creatorname', '$dateofpublish', '$blogname', '$objective', '$content', '$file')";
    
    // Execute the query and handle the response
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Record inserted successfully');
        </script>";
        header("Location: index.php"); // Redirect after successful insert
        exit(); // Ensure no further code execution
    } else {
        echo "<div class='alert alert-danger'>Error inserting record: " . mysqli_error($conn) . "</div>";
    }
}

mysqli_close($conn); // Close the database connection at the end of the script
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs.Com</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        Add New Blog
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="creatorname">Name Of Creator</label>
                                <input type="text" class="form-control" name="creatorname" placeholder="Enter the name" required>
                            </div>
                            <div class="form-group">
                                <label for="dateofpublish">Date</label>
                                <input type="date" class="form-control" name="dateofpublish" required>
                            </div>
                            <div class="form-group">
                                <label for="blogname">Blog Name</label>
                                <input type="text" class="form-control" name="blogname" placeholder="Enter blog name" required>
                            </div>
                            <div class="form-group">
                                <label for="objective">Objective</label>
                                <textarea class="form-control" name="objective" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control" name="content" rows="3" required></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="blogimage">Upload Image</label>
                                <input type="file" class="form-control-file" name="blogimage" required>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary my-1" name="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>