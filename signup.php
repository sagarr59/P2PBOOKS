<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];

  // Perform form validation
  $errors = [];

  // Validate full name (at least 2 words)
  $nameWords = explode(' ', $fullname);
  if (count($nameWords) < 2) {
    $errors[] = "Full name should contain at least 2 words.";
  }

  // Validate email format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format.";
  }

  // Validate password length (minimum 8 characters)
  if (strlen($password) < 8) {
    $errors[] = "Password should be at least 8 characters long.";
  }

  // Check if password and confirm password match
  if ($password !== $confirmPassword) {
    $errors[] = "Password and confirm password do not match.";
  }

  // Check if there are any errors
  if (count($errors) > 0) {
    // Prepare the error messages as a string
    $errorMessage = implode("\\n", $errors);
    echo "<script>alert('$errorMessage'); window.location.href='signup.php';</script>";
    exit();
  } else {
    // Form data is valid,further processing 

    // Database connection
    $servername = "localhost";
    $username = "root";
    $pass = "";
    $database = "login_register";

    $conn = new mysqli($servername, $username, $pass, $database);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Insert
    $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
      // User registration successful

      $_SESSION['email'] = $email;
      $_SESSION['fullname'] = $fullname;
      // You can set more session variables as needed

      // Redirect to success page
      header("Location: homepage.php");
      exit();
    } else {
      // Error in database insertion
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
  }
}
?>

<!--HTML-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SASTOBOOKS - Sign Up</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="signup.css">
</head>

<body>
  <div class="container">
    <a href="homepage.php"><img src="blacklogo.png" alt="Logo" class="logo"></a>
    <h1>Sign Up</h1>
    <form action="signup.php" method="POST" novalidate>
      <div class="form-group">
        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" required >
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
      </div>
      <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.html">Log in</a></p>
  </div>
</body>

</html>
