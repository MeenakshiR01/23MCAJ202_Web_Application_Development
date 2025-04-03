<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indian Cricket Players</title>
    <style>
        /* Main styling for the page */
        body {
 
            font-family: 'Arial', sans-serif;
            background-color: lightblue;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .container {
            
            max-width: 800px;
            margin: 0 auto;
            background-color: transparent;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            
        }
        
        h1 {
            text-align: center;
            color: #0033a0; /* Blue color representing Indian cricket team */
        }
        
        /* Form styling */
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        button {
            background-color: #0033a0;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        
        button:hover {
            background-color: #002280;
        }
        
        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #0033a0;
            color: white;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #e6f2ff;
        }
        
        .no-players {
            text-align: center;
            padding: 20px;
            color: #777;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Indian Cricket Players</h1>
        
        <?php
        // Initialize session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // Initialize the players array in session if it doesn't exist
        if (!isset($_SESSION['players'])) {
            $_SESSION['players'] = [];
        }
        
        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Check if player name was submitted
            if (isset($_POST['player_name']) && !empty(trim($_POST['player_name']))) {
                // Get the player name and sanitize it
                $player_name = htmlspecialchars(trim($_POST['player_name']));
                
                // Add the player to the array
                $_SESSION['players'][] = $player_name;
                
                // Redirect to prevent form resubmission
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }
        
        // Handle reset request
        if (isset($_GET['reset'])) {
            // Clear the players array
            $_SESSION['players'] = [];
            
            // Redirect to prevent form resubmission
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
        ?>
        
        <!-- Form to add a new player -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">
                <label for="player_name">Player Name:</label>
                <input type="text" id="player_name" name="player_name" placeholder="Enter player name" required>
            </div>
            <button type="submit">Add Player</button>
            <a href="?reset=1" style="margin-left: 10px; color: #777; text-decoration: none;">Reset List</a>
        </form>
        
        <!-- Display the players in a table -->
        <h2>Players List</h2>
        
        <?php if (empty($_SESSION['players'])): ?>
            <div class="no-players">No players added yet.</div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Player Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Loop through each player and display in table
                    foreach ($_SESSION['players'] as $index => $player): 
                    ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo $player; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>