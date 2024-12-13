<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "fac";    // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['facultyID'])) {
    // Redirect to login page if not logged in
    header("Location: faclogin.php");
    exit();
}

// Get the logged-in faculty ID from the session
$facultyID = $_SESSION['facultyID'];

// Query to fetch the faculty details
$sql = "SELECT name, email FROM faculty WHERE facultyID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $facultyID);
$stmt->execute();
$result = $stmt->get_result();

// Check if faculty exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
} else {
    // If no data found, log the user out
    session_destroy();
    header("Location: faclogin.php");
    exit();
}

// Close the connection
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="white.png">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* Add CSS styling here (similar to dashboard.html) */
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            text-align: center;
            padding: 40px 0;
            background-color: #004d99;
            color: #fff;
            border-radius: 8px;
        }

        header h1 {
            font-size: 2.5rem;
        }

        #user-info {
            margin-top: 30px;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .card p {
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        button {
            padding: 12px 20px;
            font-size: 1.1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #appraisal-btn {
            background-color: #28a745;
            color: white;
        }

        #logout-btn {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome to Your Dashboard</h1>
        </header>
        <section id="user-info">
            <div class="card">
                <p><strong>Username:</strong> <?php echo htmlspecialchars($name); ?></p>
                <p><strong>Email ID:</strong> <?php echo htmlspecialchars($email); ?></p>
            </div>
        </section>
        <section class="buttons">
            <button id="appraisal-btn" onclick="window.location.href='all.html';">Appraisal</button>
            <button id="logout-btn" onclick="window.location.href='logout.php';">Logout</button>
        </section>
    </div>
</body>
</html>
