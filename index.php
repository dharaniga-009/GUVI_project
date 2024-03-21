<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

// Database connection
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "login_register";
$conn = mysqli_connect('localhost', 'root', '', 'login_register');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve registered users with additional information
$sql = "SELECT * FROM register";
$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <style>
        .user-card {
            margin-bottom: 20px;
        }
        .profile-logo {
            width: 50px; /* Adjust width as needed */
            height: 50px; /* Adjust height as needed */
            border-radius: 50%; /* Make it circular */
            object-fit: cover; /* Maintain aspect ratio */
        }
        h1{
            color:black;
            font-family: 'Times New Roman', serif;
        }
        .cont{
            color: aqua;
        }
    </style>
</head>
<body>
    <!-- Just an image -->
<nav class="navbar navbar-light bg-body-tertiary">
  <div class="cont">
    <a class="navbar-brand" href="#">
      <img
        src="guvi 2.jpg"
        height="90"
        alt="guvi"
        loading="lazy"
      />
    </a>
  </div>
</nav>
    <div class="container">
        <h1>Users Profile</h1>
        <div class="row">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4">
                    <div class="card user-card">
                        <div class="card-body">
                        <img class="profile-logo" src="logo.png" alt="Profile Logo">
                            <h5 class="card-title"><?php echo $row['full_name']; ?></h5>
                            <p class="card-text">Email: <?php echo $row['email']; ?></p>
                            <p class="card-text">Age: <?php echo $row['age']; ?></p>
                            <p class="card-text">Gender: <?php echo $row['gender']; ?></p>
                            <p class="card-text">Date of Birth: <?php echo $row['dateOfBirth']; ?></p>
                            <p class="card-text">Phone Number: <?php echo $row['phoneNumber']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
        <a href="logout.php" class="btn btn-warning">Logout</a>
    </div>
</body>
</html>
