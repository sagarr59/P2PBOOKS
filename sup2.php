<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];

  // Perform form validation
  $error = "";

  // Validate full name (at least 2 words)
  $nameWords = explode(' ', $fullname);
  if (count($nameWords) < 2) {
    $error = "Full name should contain at least 2 words.";
  }

  // Validate password length (minimum 8 characters)
  if (strlen($password) < 8) {
    $error = "Password should be at least 8 characters long.";
  }

  // Check if password and confirm password match
  if ($password !== $confirmPassword) {
    $error = "Password and confirm password do not match.";
  }

  // Check if there is an error
  if (!empty($error)) {
    echo "<script>alert('$error'); window.location.href='signup.html';</script>";
    exit();
  } else {
    // Form data is valid, perform further processing (e.g., database insertion, user authentication)

    // Database connection
    $servername = "localhost";
    $username = "root";
    $pass = "";
    $database = "login_register";

    // Create connection
    $conn = new mysqli($servername, $username, $pass, $database);

    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Insert user data into the database
    $sql = "INSERT INTO users (fullname, email, password) VALUES ('$fullname', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
      // User registration successful

      // Perform user authentication (e.g., generate session, set cookies)
      $_SESSION['email'] = $email;
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
