<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "admin";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize inputs
    $email = trim($_POST['email']);
    $birthdate = trim($_POST['birthdate']);
    $fav_color = strtolower(trim($_POST['fav_color'])); // Normalize input

    // Debugging Step: Log user input
    // echo "Input Email: $email<br>";
    // echo "Input Birthdate: $birthdate<br>";
    // echo "Input Favorite Color: $fav_color<br>";

    // Prepare the SQL statement
    $sql = "SELECT * FROM admin WHERE email = ? AND birthdate = ? AND LOWER(fav_color) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $birthdate, $fav_color);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if record exists
    if ($result->num_rows > 0) {
        // Redirect to reset password page
        header("Location: reset_password.php?email=" . urlencode($email));
        exit;
    } else {
        echo "<script>alert('Validation failed. Please check your information and try again.');</script>";
    }

    // Close resources
    $stmt->close();
    $conn->close();
}
?>
