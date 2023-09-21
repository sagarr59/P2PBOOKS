<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
  // Display an alert message
  echo "<script>alert('Please log in before browsing books.'); window.location.href='login.php';</script>";
  exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$database = "bookDetails";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Modify the SQL query to order books by the latest one added
$sql = "SELECT * FROM books ORDER BY book_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SASTOBOOKS - Browse</title>
  <link rel="stylesheet" href="browse.css">
</head>

<body>
  <header>
    <!-- Your header code here -->
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
          echo '<li><a href="logout.php">Logout</a></li>';
        } else {
          echo '<li><a href="login.php">Login/Signup</a></li>';
        }
        ?>
      </ul>
    </nav>
  </header>

  <main>
    <section class="browse-section">
      <h2>Browse Books</h2>

      <?php
      // Loop through the query result
      echo '<div class="book-grid">'; // Open the book-grid container
      while ($row = $result->fetch_assoc()) {
        // Extract book details
        $bookName = $row['book_name'];
        $price = $row['price'];
        $sellerName = $row['seller_name'];
        $location = $row['location'];
        $phone = $row['phone'];
        $imageData = $row['image_data']; // Retrieve image data from the database
    
        // Output the book details dynamically
        echo '<div class="book">';
        echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" alt="Book">'; // Display the image
        echo "<h3>$bookName</h3>";
        echo "<p>Price: Rs. $price</p>";
        echo "<p>Seller: $sellerName</p>";
        echo "<p>Location: $location</p>";
        echo "<p>Phone: $phone</p>";
        echo '<button class="chat-btn">Chat with Seller</button>';
        echo '</div>';
    }
      echo '</div>'; // Close the book-grid container
      ?>

    </section>
  </main>

  <footer>
    <!-- Your footer code here -->
    <div class="footer">
      <p>&copy; 2023 SASTOBOOKS. All rights reserved.</p>
    </div>
  </footer>

  <!-- JS -->
  <script src="script.js"></script>
</body>

</html>
