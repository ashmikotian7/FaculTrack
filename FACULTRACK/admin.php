<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/png" href="white.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .dashboard {
            max-width: 1200px;
            margin: 20px auto;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background: white;
        }
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #004080;
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
        }
        .dashboard-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .logout-btn {
            background-color: white;
            color: #004080;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
        }
        .logout-btn:hover {
            background-color: #f0f0f0;
        }
        .search-box {
            padding: 10px;
            text-align: center;
        }
        .search-box input {
            width: 90%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <button class="logout-btn" onclick="window.location.href='home.html'">Logout</button>
        </div>
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search by name or department">
        </div>
        <table id="dataTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Faculty ID</th>
                    <th>Name</th>
                    <th>Grade</th>
                    <th>Allowance</th>
                    <th>Total Score</th>
                    <th>Department</th>
                    <th>Drive Link</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection details
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "fac";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to fetch data from the faculty table
                $sql = "SELECT id, facultyID, name, grade, allowance, total_score, department, drive_link FROM faculty";
                $result = $conn->query($sql);

                // Populate table rows with database data
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["id"] . "</td>
                                <td>" . $row["facultyID"] . "</td>
                                <td>" . $row["name"] . "</td>
                                <td>" . $row["grade"] . "</td>
                                <td>" . number_format($row["allowance"], 2) . "</td>
                                <td>" . $row["total_score"] . "</td>
                                <td>" . $row["department"] . "</td>
                                <td><a href='" . htmlspecialchars($row["drive_link"]) . "' target='_blank'>Link</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No data found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function () {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#dataTable tbody tr');
            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
