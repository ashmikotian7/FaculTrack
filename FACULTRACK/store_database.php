<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "fac"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['facultyID'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}

$facultyID = $_SESSION['facultyID'];

// Check if data is sent via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and validate input data
    $totalScore = isset($_POST['totalScore']) ? intval($_POST['totalScore']) : 0;
    $grade = $_POST['grade'] ?? '';
    $allowance = $_POST['allowance'] ?? ''; // Raw allowance input
    $driveLink = $_POST['driveLink'] ?? '';

    // Remove non-numeric characters from allowance (e.g., currency symbols)
    $allowance = intval(preg_replace('/[^\d]/', '', $allowance));

    // Validation
    if (empty($grade) || $allowance < 0 || $totalScore < 0 || empty($driveLink)) {
        echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
        exit();
    }

    // Update query
    $sql = "UPDATE faculty SET total_score = ?, grade = ?, allowance = ?, drive_link = ? WHERE facultyID = ?";

    // Prepare and execute statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isiss", $totalScore, $grade, $allowance, $driveLink, $facultyID);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Data updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Prepared statement error.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

$conn->close();
?>
