<!-- view_messages.php -->
<?php
session_start();

// Check if the user is logged in (you should implement proper user authentication)
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page
    exit;
}

// Database connection configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "sastobooks";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch and display messages
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM messages WHERE sender_id = ? OR receiver_id = ? ORDER BY timestamp DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Messages</title>
</head>
<body>
    <h1>View Messages</h1>
    <table>
        <tr>
            <th>Sender</th>
            <th>Message</th>
            <th>Timestamp</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            $sender_id = $row['sender_id'];
            $message_text = $row['message_text'];
            $timestamp = $row['timestamp'];
            // Fetch sender's username based on sender_id (you should have a users table)
            $sender_name = getSenderName($sender_id);
            echo "<tr>";
            echo "<td>$sender_name</td>";
            echo "<td>$message_text</td>";
            echo "<td>$timestamp</td>";
            echo "</tr>";
        }
        $stmt->close();
        $conn->close();
        ?>
    </table>
</body>
</html>
