<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>SASTOBOOKS - P2P Book Marketplace</title>
  <link rel="stylesheet" href="homepage.css">
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
          session_start();
          if (isset($_SESSION['email'])) {
            echo '<li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>'; // User icon linked to profile page
            echo '<li><a href="logout.php">Logout</a></li>';
          } else {
            echo '<li><a href="login.php">Login/Signup</a></li>';
          }
        ?>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <div class="container">
      <?php
        if (isset($_SESSION['fullname'])) {
          echo '<h1><span>Welcome to SASTOBOOKS , '  . $_SESSION['fullname'] . '!</span></h1>';
        } else {
          echo '<h1><span>A P2P Book Marketplace</span></h1>';
        }
      ?>
      <p><span>Buy and sell books with ease</span></p>
      <br>
      <a href="browse.php" class="btn">Browse Books</a>
    </div>
  </section>

  <section class="features">
    <div class="features-content">
      <h2>Features</h2>
      <div class="feature">
        <i class="fas fa-search"></i>
        <h3>Browse Books</h3>
        <p>Explore a wide range of books available for purchase</p>
      </div>
      <div class="feature">
        <i class="fas fa-dollar-sign"></i>
        <h3>Sell Books</h3>
        <p>List your books for sale and reach potential buyers</p>
      </div>
      <div class="feature">
        <i class="fas fa-comments"></i>
        <h3>Communicate</h3>
        <p>Connect with other users for book transactions</p>
      </div>
      <div class="feature">
        <a href="./learnmore.html">Learn More</a>
      </div>
    </div>
  </section>

  <footer>
    <div class="footer">
      <p>&copy; 2023 SASTOBOOKS. All rights reserved.</p>
    </div>
  </footer>
</body>

</html>
