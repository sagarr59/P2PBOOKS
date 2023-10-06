<?php
session_start();

if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in before selling a book.'); window.location.href='login.php';</script>";
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "bookDetails";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookName = isset($_POST['book-name']) ? $_POST['book-name'] : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $sellerName = isset($_POST['seller-name']) ? $_POST['seller-name'] : '';
    $condition = isset($_POST['condition']) ? $_POST['condition'] : '';
    $location = isset($_POST['seller-location']) ? $_POST['seller-location'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    
    // File upload handling
    $targetDirectory = "uploads/";
    $targetFileName = basename($_FILES["book-photo"]["name"]);
    $targetFilePath = $targetDirectory . $targetFileName;
    move_uploaded_file($_FILES["book-photo"]["tmp_name"], $targetFilePath);

    if ($bookName && $price && $sellerName && $condition && $location && $phone) {
        // Open and read the image file
        $imageData = file_get_contents($targetFilePath);

        $sql = "INSERT INTO books (book_name, price, `condition`, seller_name, location, phone, image_path, image_data) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $bookName, $price, $condition, $sellerName, $location, $phone, $targetFileName, $imageData);
        
        if ($stmt->execute()) {
            echo "<script>alert('Sell book details added successfully.'); window.location.href='browse.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "<script>alert('Please fill out all the required fields.'); window.location.href='sell.php';</script>";
    }
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SASTOBOOKS - Sell</title>
    <link rel="stylesheet" href="sell.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>
    <header>
    <nav>
    <div class="logo">
        <a href="homepage.php"><img src="mylogo.png" alt="Logo" class="logo"></a>
    </div>
    <ul class="navigation">
        <li><a href="homepage.php">Home</a></li>
        <li><a href="browse.php">Browse</a></li>
        <li><a href="sell.php">Sell</a></li>
        <?php
        if (isset($_SESSION['fullname'])) {
            echo '<li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>'; // Add the profile icon link
            echo '<li><a href="logout.php">Logout</a></li>';
        } else {
            echo '<li><a href="login.php">Login/Signup</a></li>';
        }
        ?>
    </ul>
</nav>

    </header>
    <div class="container">

        <main>
            <section class="sell-section">
                <h2>Sell a Book</h2>
                <form class="sell-form" action="sell.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="book-name">Book Name:</label>
                        <input type="text" id="book-name" name="book-name" required>
                    </div>

                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="text" id="price" name="price" required>
                    </div>

                    <div class="form-group">
                        <label for="seller-name">Seller Name:</label>
                        <input type="text" id="seller-name" name="seller-name" required>
                    </div>

                    <div class="form-group">
                        <label for="condition">Condition:</label>
                        <select id="condition" name="condition" required>
                            <option value="new">New</option>

                            <option value="used">Used</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="seller-location">Seller Location:</label>
                        <input type="text" id="seller-location" name="seller-location" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
        <label for="book-photo">Book Photo:</label>
        <input type="file" id="book-photo" name="book-photo" required>
    </div>
    <button type="submit" class="sell-btn">Sell Book</button>
</form>
            </section>
        </main>

        <footer>
            <!-- Footer content -->
            <div class="footer">
                <p>&copy; 2023 SASTOBOOKS. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script src="script.js"></script>
</body>

</html>