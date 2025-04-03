<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Array Manager</title>
    <style>
        /* Basic styling for the entire page */
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color:rgb(163, 159, 159);
        }
        
        h1, h2 {
            color: #2c3e50;
            text-align: center;
        }
        
        /* Styling for the form */
        .input-form {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        button, input[type="submit"], input[type="button"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }
        
        button:hover, input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #2980b9;
        }
        
        .reset-btn {
            background-color: #e74c3c;
        }
        
        .reset-btn:hover {
            background-color: #c0392b;
        }
        
        /* Styling for the results */
        .result-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        
        .array-display {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            border-left: 4px solid #3498db;
            font-family: monospace;
            white-space: pre-wrap;
            overflow-x: auto;
        }
        
        .empty-message {
            color: #7f8c8d;
            text-align: center;
            font-style: italic;
        }
        
        .student-list {
            list-style-type: none;
            padding: 0;
        }
        
        .student-list li {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <h1>Student Array Manager</h1>
    
    <div class="input-form">
        <form method="post" action="">
            <label for="student_name">Enter Student Name:</label>
            <input type="text" id="student_name" name="student_name" placeholder="Enter a student name" required>
            <input type="submit" name="add_student" value="Submit">
            <!-- Changed from reset to button to handle custom reset functionality -->
            <input type="submit" name="reset_data" value="Reset" class="reset-btn">
        </form>
    </div>
    
    <?php
    // Start the session to store student array
    session_start();
    
    // Check if reset button was pressed
    if (isset($_POST['reset_data'])) {
        // Clear the array by resetting it
        $_SESSION['students'] = array();
        
        // Feedback message
        echo "<div class='result-container'>";
        echo "<p>All student data has been cleared!</p>";
        echo "</div>";
    }
    
    // Initialize the students array if it doesn't exist
    if (!isset($_SESSION['students'])) {
        $_SESSION['students'] = array();
    }
    
    // Check if the form is submitted to add a student
    if (isset($_POST['add_student']) && !empty($_POST['student_name'])) {
        // Get the student name from the form
        $student_name = trim($_POST['student_name']);
        
        // Add the student name to the array
        $_SESSION['students'][] = $student_name;
        
        // Feedback message
        echo "<div class='result-container'>";
        echo "<p>Student '{$student_name}' has been added successfully!</p>";
        echo "</div>";
    }
    
    // Display the current array if it's not empty
    if (!empty($_SESSION['students'])) {
        echo "<div class='result-container'>";
        
        // Original Student List
        echo "<h2>Original Student List</h2>";
        echo "<div class='array-display'>";
        echo "<ul class='student-list'>";
        
        // Custom display of the original array without Array()
        foreach ($_SESSION['students'] as $key => $student) {
            echo "<li>[$key] => $student</li>";
        }
        
        echo "</ul>";
        echo "</div>";
        
        // Create a copy of the original array for sorting
        $sorted_asc = $_SESSION['students'];
        $sorted_desc = $_SESSION['students'];
        
        // Sort the array in ascending order (asort)
        asort($sorted_asc);
        
        echo "<h2>Ascending Sorted List (asort)</h2>";
        echo "<div class='array-display'>";
        echo "<ul class='student-list'>";
        
        // Custom display of the ascending sorted array without Array()
        foreach ($sorted_asc as $key => $student) {
            echo "<li>[$key] => $student</li>";
        }
        
        echo "</ul>";
        echo "</div>";
        
        // Sort the array in descending order (arsort)
        arsort($sorted_desc);
        
        echo "<h2>Descending Sorted List (arsort)</h2>";
        echo "<div class='array-display'>";
        echo "<ul class='student-list'>";
        
        // Custom display of the descending sorted array without Array()
        foreach ($sorted_desc as $key => $student) {
            echo "<li>[$key] => $student</li>";
        }
        
        echo "</ul>";
        echo "</div>";
        echo "</div>";
    } else {
        // Display a message if the array is empty
        echo "<div class='result-container'>";
        echo "<p class='empty-message'>No students have been added yet. Add some students to see them displayed here.</p>";
        echo "</div>";
    }
    ?>
</body>
</html>