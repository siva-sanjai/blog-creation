<?php
include("db.php");

if (isset($_POST['submit'])) {
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $dateofcmnt = $_POST['dateofcmnt'];
    $comments = mysqli_real_escape_string($conn, $_POST['comments']);
   
    // Get the blog ID from the URL (assuming it's passed as a query parameter)
    $blog_id = $_GET['id'];
    
    // Prepare the SQL query to insert the form data
    $sql = "INSERT INTO cmnts (username, dateofcmnt, comments, blog_id) 
            VALUES ('$username', '$dateofcmnt', '$comments', '$blog_id')";
    
    // Execute the query and handle the response
    if (mysqli_query($conn, $sql)) {
        echo "<script>
        alert('Commented successfully');
        </script>";
        header("Location: more.php?id=$blog_id"); // Redirect to the same blog page
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
                        Add Comments
                    </div>
                    <div class="card-body">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="username">Name Of user</label>
                                <input type="text" class="form-control" name="username" placeholder="Enter the name" required>
                            </div>
                            <div class="form-group">
                                <label for="dateofcmnt">Date</label>
                                <input type="date" class="form-control" name="dateofcmnt" required>
                            </div>
                            <div class="form-group">
                                <label for="comments">Give Comments</label>
                                <textarea class="form-control" name="comments" rows="3" required></textarea>
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