<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the form inputs
  $email = $_POST['email'];
  $password = $_POST['password'];

  // Validate the inputs
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format";
  } elseif (strlen($password) < 8) {
    $error = "Password must be at least 8 characters long";
  }

  // Stop further execution if there's an error
  if (isset($error)) {
    echo "<script>alert('$error'); window.location.href='login.php';</script>";
    exit();
  }

  $servername = "localhost";
  $username = "root";
  $db_password = "";
  $dbname = "login_register";

  // Create a new connection
  $conn = new mysqli($servername, $username, $db_password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Sanitize the inputs to prevent SQL injection
  $email = $conn->real_escape_string($email);
  $password = $conn->real_escape_string($password);

  // Prepare and execute the SQL statement
  $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
  $result = $conn->query($sql);

  if ($result && $result->num_rows == 1) {
    // User login successful
    $row = $result->fetch_assoc();
    $_SESSION['email'] = $email;
    $_SESSION['fullname'] = $row['fullname'];
    header("Location: homepage.php"); // Redirect to the homepage
    exit();
  } else {
    // User login failed
    $error = "Invalid email or password";
    echo "<script>alert('$error'); window.location.href='login.php';</script>";
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SASTOBOOKS - Login</title>
  <link rel="stylesheet" href="login.css">
</head>

<body>
  <div class="container">
  <a href="homepage.php"><img src="blacklogo.png" alt="Logo" class="logo"></a>

    <h1>Login</h1>
    <form method="POST" action="login.php">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" class="btn" name="button">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
  </div>
</body>

</html>
