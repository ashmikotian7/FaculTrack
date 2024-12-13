<?php
// Start session for session management
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = "";     // Your MySQL password
$dbname = "admin";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$adminID = $passwordInput = "";
$login_error = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $adminID = $_POST['adminID'];
    $passwordInput = $_POST['password'];

    // Query to check if the adminID exists in the database
    $sql = "SELECT * FROM admin WHERE adminID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $adminID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the data from the database
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($passwordInput, $row['password'])) {
            // Password is correct, set session and redirect
            $_SESSION['adminID'] = $adminID;
            header("Location: admin.php"); // Redirect to the dashboard
            exit();
        } else {
            $login_error = "Invalid password.";
        }
    } else {
        $login_error = "Invalid Admin ID.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - FaculTrack</title>
    <link rel="icon" type="image/png" href="white.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Basic CSS for layout and styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(150deg, #f6f8f7, #43324f, #f6f8f7);
            background-size: cover;
            color: #fff;
        }

        /* Header styling */
        header {
            background-color: #584158;
            padding: 10px 20px;
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            box-sizing: border-box;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        header img {
            width: 10%;
        }

        header h2 {
            font-size: 1.8em;
            font-family: cursive;
        }

        /* Hamburger Menu */
        .menu-container {
            position: relative;
        }

        .hamburger {
            width: 30px;
            height: 25px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }

        .hamburger div {
            height: 5px;
            width: 100%;
            background-color: #fbf7f7;
            margin: 3px 0;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 35px;
            right: 0;
            background-color: #333;
            border-radius: 5px;
            width: 150px;
        }

        .dropdown-menu a {
            display: block;
            color: white;
            padding: 12px 16px;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background-color: #575757;
        }

        /* Login Container Styling */
        .login-container {
    width: 100%;
    max-width: 400px;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.7); /* Increased transparency */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    text-align: center;
    margin-top: 20px;
    color: #333;
}

        .login-container h2 {
            color: #43324f;
            margin-bottom: 20px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            padding: 7px;
            margin: 10px 0;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #12723a;
            box-sizing: initial;
            width: 92%;
        }

        .login-form button {
            display: block;
            width: 200px;
            margin: 0 auto;
            padding: 10px 20px;
            background-color: #12723a;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .login-form button:hover {
            background-color: #008a8a;
        }

        .back-link,
        .forgot-password {
            margin-top: 15px;
            display: block;
            color: #43324f;
            text-decoration: none;
        }

        .back-link:hover,
        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Footer */
        footer {
            background-color: #584158;
            color: #fff;
            text-align: center;
            padding: 10px;
            width: 100%;
            margin-top: auto;
        }

        .signup-link {
            margin-top: 15px;
            font-size: 14px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .signup-link a {
            color: #007bff;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .instructions {
            margin-top: 20px;
            color: #43324f;
            text-align: left;
        }

        .instructions ul {
            padding-left: 20px;
        }

        .instructions ul li {
            margin-bottom: 10px;
            font-size: 0.95em;
        }

        /* Error message styling */
        .error-message {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Header with logo, title, and menu -->
    <header>
        <div class="logo-container">
            <img src="white.jpg" alt="SMVITM LOGO">
            <h2>FaculTrack</h2>
        </div>
        <!-- Hamburger Menu -->
        <div class="menu-container">
            <div class="hamburger" onclick="toggleMenu()">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="dropdown-menu">
                <a href="home.html">Home</a>
                <a href="faclogin.php">FacLogin</a>
                <a href="adminlog.php">AdminLogin</a>
                <a href="aboutus.html">About Us</a>
                <a href="contactus.html">Contact Us</a>
            </div>
        </div>
    </header>

    <!-- Login Container -->
    <div class="login-container">
        <h2>Admin Login</h2>
        
        <!-- Display error message if invalid login -->
        <?php if ($login_error): ?>
            <div class="error-message"><?= $login_error ?></div>
        <?php endif; ?>

        <form class="login-form" action="adminlog.php" method="POST">
            <input type="text" name="adminID" placeholder="Admin ID" required>
            <input type="password" name="password" placeholder="Password" required>
            <br>
            <button type="submit">Login</button>
        </form>

        <!-- Forgot Password and Sign-Up links -->
        <div class="forgot-password">
            <a href="aforgot-password.php">Forgot Password?</a>
        </div>
        <div class="signup-link">
            <p>Don't have an account? <a href="asignup.php">SIGN-UP</a></p>
        </div>

        <!-- Instructions Section -->
        <div class="instructions">
            <h3>Instructions:</h3>
            <ul>
    <li>Welcome to the Admin Login page for FaculTrack.</li>
    <li>Enter your Admin ID and Password to access the management dashboard.</li>
    <li>If you are a new administrator, please contact the system administrator to create an account.</li>
    <li>If you've forgotten your password, use the "Forgot Password?" link to reset it.</li>
    <li>Ensure that your login credentials are secure and confidential to maintain system integrity.</li>
</ul>
        </div>
    </div>
<br>
<br>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 FaculTrack. All Rights Reserved.</p>
    </footer>

    <!-- JavaScript for Hamburger Menu -->
    <script>
        function toggleMenu() {
            var menu = document.querySelector('.dropdown-menu');
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        }
    </script>

</body>
</html>
