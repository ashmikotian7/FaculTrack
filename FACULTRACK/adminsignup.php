<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root";    // Your database username
    $password = "";        // Your database password
    $dbname = "admin";     // The database name you are using

    // Create a new connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
        exit;
    }

    // Collect form data from POST
    $adminID = $_POST['adminID'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password
    $birthdate = $_POST['birthdate'];

    // Validate email domain to ensure it's from @sode-edu.in
    if (!str_ends_with($email, "@sode-edu.in")) {
        echo json_encode(["status" => "error", "message" => "This platform is only for @sode-edu.in email addresses."]);
        exit;
    }

    // Insert data into the database
    $sql = "INSERT INTO admin (adminID, name, email, password, birthdate) 
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters to prevent SQL injection
    $stmt->bind_param("sssss", $adminID, $name, $email, $password, $birthdate);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Signup successful!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
