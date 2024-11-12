<?php
include("db.php");

// Check if the ID is passed in the query parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch blog data from the database
    $query = "SELECT * FROM blog WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error); // Display SQL error message
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $blog = $result->fetch_assoc();
    $stmt->close();

    // If the blog post doesn't exist, display a message and exit
    if (!$blog) {
        echo "<div class='alert alert-danger'>Blog not found. Invalid blog ID.</div>";
        exit();
    }
   
} else {
    echo "<div class='alert alert-danger'>No blog ID specified.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($blog['blogname']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-9 mx-auto">
                <div class="card mt-4">
                    <div class="card-header">
                        <img class="card-img-top" src="image/<?= htmlspecialchars($blog['blogimage']) ?>" alt="Card image cap">
                        <h2><?= htmlspecialchars($blog['blogname']) ?></h2>
                        <small class="text-muted">
                            By <?= htmlspecialchars($blog['creatorname']) ?> on <?= htmlspecialchars($blog['publishdate']) ?>
                        </small>
                    </div>
                    <div class="card-body">
                        <p><?= nl2br(htmlspecialchars($blog['content'])) ?></p>

                        <!-- Add Comments Button -->
                        <a href="comnt.php?id=<?= $id ?>" class="btn btn-primary mb-4">Add Comments</a>

                        <!-- Display Comments Section -->
                        <?php
                         
                         include("db.php");
                       
                         $commentQuery = "SELECT * FROM cmnts WHERE blog_id = ?";
                         $stmt = $conn->prepare($commentQuery);
                         if ($stmt) {
                             $stmt->bind_param("i", $id);
                             $stmt->execute();
                             $commentResult = $stmt->get_result();
                             
                             if ($commentResult->num_rows > 0) {
                                 while ($row = $commentResult->fetch_assoc()) {
                                     echo '
                                     <div class="card mb-3">
                                         <div class="card-body">
                                             <small class="card-title">' . htmlspecialchars($row["username"]) . ' on ' . htmlspecialchars($row["dateofcmnt"]) . '</small>
                                             <p class="card-text">' . htmlspecialchars($row["comments"]) . '</p>
                                         </div>
                                     </div>
                                     ';
                                 }
                             } else {
                                 echo "<p>No comments found.</p>";
                             }
                             $stmt->close();
                         } else {
                             echo "<p>Error fetching comments: " . $conn->error . "</p>";
                         }
                        ?>

                        <a href="index.php" class="btn btn-info mt-3">Back to Blogs</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
