<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fac";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
        exit;
    }

    // Collect form data
    $facultyID = $_POST['facultyID'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password
    $birthdate = $_POST['birthdate'];
    $department = $_POST['department'];

    // Validate email domain
    if (!str_ends_with($email, "@sode-edu.in")) {
        echo json_encode(["status" => "error", "message" => "This platform is only for @sode-edu.in email addresses."]);
        exit;
    }

    // Insert data into the database with placeholders for grade, allowance, and drive_link
    $sql = "INSERT INTO faculty (facultyID, name, email, password, birthdate, department, grade, allowance, drive_link) 
            VALUES (?, ?, ?, ?, ?, ?, '', 0.00, '')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $facultyID, $name, $email, $password, $birthdate, $department);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Signup successful!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
