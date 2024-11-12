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
            <div class="col-md-15">
                <div class="card">
                    <div class="card-header">
                        Blogs
                    </div>
                    <div class="card-body">
                        <button class="btn btn-success">
                            <a href="add.php" class="text-light" style="text-decoration: none;">Add new Blog</a>
                        </button>
                        <br><br>
                        <div class="row">
                            <?php
                            include("db.php");

                            // Check if delete is set and process the delete request
                            if (isset($_POST["delete"])) {
                                $id = $_POST["delete"];
                                $deleteQuery = "DELETE FROM blog WHERE id = ?";
                                $stmt = $conn->prepare($deleteQuery);
                                $stmt->bind_param("i", $id);
                                $stmt->execute();
                                $stmt->close();
                                echo "<div class='alert alert-success'>Blog deleted successfully.</div>";
                            }

                            // Fetch and display blog entries
                            $query = "SELECT * FROM blog";
                            if ($result = $conn->query($query)) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '
                                        <div class="col-sm-4 mb-3">
                                            <div class="card">
                                                <img class="card-img-top " width="30" height="240" src="image/' . $row['blogimage'] . '" alt="Card image cap">
                                                <div class="card-body">
                                                    <h5 class="card-title">' . htmlspecialchars($row["blogname"]) . '</h5>
                                                    <p class="card-text">' . htmlspecialchars($row["objective"]) . '</p>
                                                      <a href="edit.php?id=' . $row["id"] . '" class="btn btn-warning btn-sm">Edit</a>
                                                    
                                                    
                                                    <!-- Delete button within a form -->
                                                    <form method="POST" style="display:inline;">
                                                        <input type="hidden" name="delete" value="' . $row["id"] . '">
                                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                   <br><br>                                
                                                    <a href="more.php?id=' . $row["id"] . '" >Read more -></a>

                                                </div>
                                            </div>
                                        </div>
                                    ';
                                }
                                $result->free();
                            } else {
                                echo "<p>No blogs found.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
