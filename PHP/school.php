<html>
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        table {
            margin: 0 auto;
            width: 80%;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px 15px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<h1>Student Records</h1>

<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Change if you have a password
$dbname = "school";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<p style='color:red;text-align:center;'>Connection failed: " . $conn->connect_error . "</p>");
}

// Query to fetch student data
$sql = "SELECT id, name, email, course FROM students";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th></tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["id"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["course"]) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "<p style='text-align:center;'>No records found.</p>";
}

$conn->close();
?>

</body>
</html>
