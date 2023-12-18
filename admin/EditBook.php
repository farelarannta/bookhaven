<?php
include("../includes/config.php");
session_start();

if ($_SESSION['type'] == 'user') {
    header("Location: ../Index.php");
    exit();
} else {
    if (isset($_GET["book_id"])) {
        $book_id = mysqli_real_escape_string($conn, $_GET["book_id"]);
    }

    if (isset($_POST["edit_book"])) {
        $title = mysqli_real_escape_string($conn, $_POST["title"]);
        $author = mysqli_real_escape_string($conn, $_POST["author"]);
        $publication_year = mysqli_real_escape_string($conn, $_POST["publication_year"]);
        $genre = mysqli_real_escape_string($conn, $_POST["genre"]);
        $isbn = mysqli_real_escape_string($conn, $_POST["isbn"]);
        $page_count = mysqli_real_escape_string($conn, $_POST["page_count"]);
        $language = mysqli_real_escape_string($conn, $_POST["language"]);
        $publisher = mysqli_real_escape_string($conn, $_POST["publisher"]);
        $stock = mysqli_real_escape_string($conn, $_POST["stock"]);
        $description = mysqli_real_escape_string($conn, $_POST["description"]);
        $price = mysqli_real_escape_string($conn, $_POST["price"]);

        $imageName = $_FILES['image']['name'];
        $imageTempName = $_FILES['image']['tmp_name'];
        move_uploaded_file($imageTempName, "../uploads/" . $imageName);

        echo
        "
        <script>    
          alert('The book has been successfully changed!');
          window.location.href = './ManageBooks.php';
        </script>
        ";

        mysqli_query($conn, "UPDATE books SET title = '$title', author = '$author', publication_year = '$publication_year', genre = '$genre', isbn = '$isbn', page_count = '$page_count', language = '$language', publisher = '$publisher', stock = '$stock', description = '$description', price = '$price' WHERE book_id = '$book_id'");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book | Admin</title>
    <link rel="stylesheet" href="../assets/css/AddBook.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<body>
    <aside>
        <div class="logo">
            <h1>Bookhaven</h1>
        </div>
        <ul>
            <li><a href="./Dashboard.php"><i class="fa-solid fa-gauge"></i>Dashboard</a></li>
            <li><a href="./ManageBooks.php"><i class="fa-solid fa-book"></i>Manage Books</a></li>
            <li><a href="./ManageOrders.php"><i class="fa-solid fa-boxes"></i>Manage Orders</a></li>
        </ul>
    </aside>

    <!-- Main -->
    <main>
        <!-- Header -->
        <header>
            <h2>☰ Add Book</h2>

            <ul>
                <li><a href=""><?= $_SESSION["name"] ?></a></li>
                <li><a href="../auth/SignOut.php">Sign Out</a></li>
            </ul>
        </header>

        <section>
            <div class="container-form">
                <?php
                $query = mysqli_query($conn, "SELECT * FROM books WHERE book_id = '$book_id'");
                $book = mysqli_fetch_assoc($query);
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="container-input">
                        <div>
                            <div class="font">
                                <label for="title">Title:</label>
                                <input type="text" id="title" name="title" value="<?= $book["title"] ?>" required>
                            </div>

                            <div class="font">
                                <label for="author">Author:</label>
                                <input type="text" id="author" name="author" value="<?= $book["author"] ?>" required>
                            </div>

                            <div class="font">
                                <label for="publication_year">Publication Year:</label>
                                <input type="number" min="" max="<?php echo date('Y'); ?>" id="publication_year" name="publication_year" value="<?= $book["publication_year"] ?>">
                            </div>

                            <div class="font">
                                <label for="genre">Genre:</label>
                                <select id="genre" name="genre" value="<?= $book["genre"] ?>">
                                    <option value="Fiction">Fiction</option>
                                    <option value="Non-Fiction">Non-Fiction</option>
                                </select>
                            </div>

                            <div class="font">
                                <label for="isbn">ISBN:</label>
                                <input type="text" id="isbn" name="isbn" value="<?= $book["isbn"] ?>">
                            </div>
                        </div>

                        <div>
                            <div class="font">
                                <label for="page_count">Page Count:</label>
                                <input type="number" id="page_count" name="page_count" value="<?= $book["page_count"] ?>" min="0">
                            </div>

                            <div class="font">
                                <label for="language">Language:</label>
                                <select id="language" name="language" value="<?= $book["language"] ?>">
                                    <option value="English">English</option>
                                    <option value="Indonesia">Indonesia</option>
                                </select>
                            </div>

                            <div class="font">
                                <label for="publisher">Publisher:</label>
                                <input type="text" id="publisher" name="publisher" value="<?= $book["publisher"] ?>">
                            </div>

                            <div class="font">
                                <label for="price">Price:</label>
                                <input type="number" id="price" name="price" value="<?= $book["price"] ?>">
                            </div>

                            <div class="font">
                                <label for="stock">Stock:</label>
                                <input type="number" id="stock" name="stock" value="<?= $book["stock"] ?>" min="0">
                            </div>
                        </div>
                    </div>

                    <div class="font">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" rows="4"><?= $book["description"] ?></textarea>
                    </div>

                    <div class="font">
                        <label for="image">Image:</label>
                        <input type="file" id="image" name="image" value="<?= $book["image"] ?>">
                    </div>

                    <button type="submit" name="edit_book">Edit Book</button>
                </form>
            </div>
        </section>
    </main>
</body>

</html>