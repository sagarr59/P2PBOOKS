<?php
session_start();

if (!isset($_SESSION['email'])) {
  
  echo "<script>alert('Please log in before browsing books.'); window.location.href='login.php';</script>";
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

  <main>
    <section class="browse-section">
      <h2>Browse Books</h2>

      <?php
      
      echo '<div class="book-grid">'; 
      while ($row = $result->fetch_assoc()) {
        // Extract book details
        $bookName = $row['book_name'];
        $price = $row['price'];
        $sellerName = $row['seller_name'];
        $location = $row['location'];
        $phone = $row['phone'];
        $imageData = $row['image_data']; 
    
       echo '<div class="book">';
       echo '<a href="book_listing.php?book_id=' . $row['book_id'] . '">';
       echo '<img src="data:image/jpeg;base64,' . base64_encode($imageData) . '" alt="Book">';
       echo '</a>'; // Close the anchor tag for the image
       echo "<h3>$bookName</h3>";
       echo "<p>Price: Rs. $price</p>";
       echo "<p>Seller: $sellerName</p>";
       echo "<p>Location: $location</p>";
       echo "<p>Phone: $phone</p>";
       echo '</div>';
 

    }
      echo '</div>'; 
      ?>

    </section>
  </main>

  <footer>
    <div class="footer">
      <p>&copy; 2023 SASTOBOOKS. All rights reserved.</p>
    </div>
  </footer>

</body>

</html>
