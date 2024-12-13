<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "admin";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize and validate inputs
    $email = trim($_POST['email']);
    $new_password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Encrypt the password

    if (empty($email) || empty($new_password)) {
        // Redirect back with an error if inputs are invalid
        header("Location: areset_password.php?status=invalid_input");
        exit;
    }

    // Prepare the SQL statement
    $sql = "UPDATE admin SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);

    // Check if $stmt is valid
    if (!$stmt) {
        error_log("Failed to prepare SQL statement: " . $conn->error); // Log the error
        header("Location: areset_password.php?status=stmt_error");
        exit;
    }

    $stmt->bind_param("ss", $new_password, $email);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to reset password page with success message
        header("Location: areset_password.php?status=success");
        exit;
    } else {
        error_log("Error executing query: " . $stmt->error); // Log the error
        header("Location: areset_password.php?status=update_error");
        exit;
    }

    // Close resources safely
    if ($stmt) {
        $stmt->close();
    }
    $conn->close();
}
?>
