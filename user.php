<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>User Profile</h1>
        <a href="logout.php">Logout</a>
    </header>
    <main>
        <section class="profile-info">
            <h2>Your Profile</h2>
            <?php
            // Assuming you have a function to fetch user data from the database
            $userData = getUserData($_SESSION['user_id']);
            if ($userData) {
                echo "<p><strong>Name:</strong> {$userData['name']}</p>";
                echo "<p><strong>Email:</strong> {$userData['email']}</p>";
                // Add more user-specific information here
            }
            ?>
        </section>
        <section class="profile-edit">
            <h2>Edit Profile</h2>
            <form action="update_profile.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $userData['name']; ?>" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $userData['email']; ?>" required>

                <!-- Add more fields for profile editing here -->

                <button type="submit">Save Changes</button>
            </form>
        </section>
    </main>
</body>
</html>
