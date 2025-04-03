<?php

// Initialize variables to store form data and error messages
$firstname = $lastname = $email = $password = $confirm_password = $phone = "";
$firstname_err = $lastname_err = $email_err = $password_err = $confirm_password_err = $phone_err = "";
$registration_success = false;

// Process form data when the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validate first name
    if (empty(trim($_POST["firstname"]))) {
        // Check if first name is empty
        $firstname_err = "Please enter your first name.";
    } elseif (!preg_match("/^[a-zA-Z ]{1,30}$/", trim($_POST["firstname"]))) {
        // Check if first name contains only letters and spaces and is between 2-30 characters
        $firstname_err = "First name should only contain letters and be 2-30 characters long.";
    } else {
        // First name is valid, store it after trimming whitespace
        $firstname = trim($_POST["firstname"]);
    }
    
    // Validate last name
    if (empty(trim($_POST["lastname"]))) {
        // Check if last name is empty
        $lastname_err = "Please enter your last name.";
    } elseif (!preg_match("/^[a-zA-Z ]{1,30}$/", trim($_POST["lastname"]))) {
        // Check if last name contains only letters and spaces and is between 2-30 characters
        $lastname_err = "Last name should only contain letters and be 2-30 characters long.";
    } else {
        // Last name is valid, store it after trimming whitespace
        $lastname = trim($_POST["lastname"]);
    }
    
    // Validate email
    if (empty(trim($_POST["email"]))) {
        // Check if email is empty
        $email_err = "Please enter your email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        // Check if email has valid format using PHP's built-in filter
        $email_err = "Please enter a valid email address.";
    } else {
        // Email format is valid, store it after trimming whitespace
        $email = trim($_POST["email"]);
        
        // Check if email already exists in database
        // This is where you would normally connect to your database and check if the email exists
        // For demonstration purposes, we'll use a dummy check
        $email_exists = false; // Replace with actual database check
        
        if ($email_exists) {
            // If email already exists in database, show error
            $email_err = "This email is already registered.";
        }
    }
    
    // Validate password
    if (empty(trim($_POST["password"]))) {
        // Check if password is empty
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8) {
        // Check if password meets minimum length requirement
        $password_err = "Password must have at least 8 characters.";
    } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", trim($_POST["password"]))) {
        // Check if password contains at least one uppercase letter, one lowercase letter, one number, and one special character
        $password_err = "Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.";
    } else {
        // Password meets all requirements, store it after trimming whitespace
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        // Check if confirm password is empty
        $confirm_password_err = "Please confirm your password.";
    } else {
        // Store confirm password after trimming whitespace
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            // Check if confirm password matches the original password
            $confirm_password_err = "Passwords did not match.";
        }
    }
    
    // Validate phone number (optional field)
    if (!empty(trim($_POST["phone"]))) {
        // Phone is optional but if provided, it should be valid
        if (!preg_match("/^[0-9]{10}$/", trim($_POST["phone"]))) {
            // Check if phone number is exactly 10 digits
            $phone_err = "Please enter a valid 10-digit phone number.";
        } else {
            // Phone number is valid, store it after trimming whitespace
            $phone = trim($_POST["phone"]);
        }
    }
    
    // Check if there are no errors before proceeding with registration
    if (empty($firstname_err) && empty($lastname_err) && empty($email_err) && 
        empty($password_err) && empty($confirm_password_err) && empty($phone_err)) {
        
        // Password hashing for security - never store plain text passwords
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Here you would normally insert the user data into your database
        // Example SQL (commented out):
        /*
        $sql = "INSERT INTO users (firstname, lastname, email, password, phone) VALUES (?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sssss", $firstname, $lastname, $email, $hashed_password, $phone);
        $stmt->execute();
        */
        
        // For demonstration purposes, we'll just set a success flag
        $registration_success = true;
        
        // Clear form data after successful registration
        $firstname = $lastname = $email = $password = $confirm_password = $phone = "";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        /* Basic styling for the form */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: lightblue
        }
        
        /* Header styling */
        h2 {
            color: #333;
            text-align: center;
        }
        
        /* Form field container */
        .form-group {
            margin-bottom: 15px;
        }
        
        /* Label styling */
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        /* Input field styling */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="tel"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        /* Error message styling */
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
        }
        
        /* Success message styling */
        .success {
            color: #28a745;
            text-align: center;
            padding: 10px;
            background-color: #d4edda;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        
        /* Submit button styling */
        button {
            margin-top: 15px;
            padding: 10px;
            background: rgba(83, 17, 2, 0.514);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            justify-content: center;
            align-items: center;
            margin-left: 150px;
            width: 300px
        }
        
        /* Button hover effect */
        button:hover {
            background-color: #0069d9;
        }
        
        /* Required field indicator */
        .required {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <h2>User Registration</h2>
    
    <?php 
    // Display success message if registration was successful
    if ($registration_success): ?>
        <div class="success">Registration successful! Thank you for registering.</div>
    <?php endif; ?>
    
    <!-- Registration form starts here -->
    <!-- htmlspecialchars prevents XSS attacks by encoding special characters -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <!-- First Name field -->
        <div class="form-group">
            <label>First Name <span class="required">*</span></label>
            <input type="text" name="firstname" value="<?php echo $firstname; ?>">
            <?php 
            // Display error message if there is one
            if (!empty($firstname_err)): ?>
                <span class="error"><?php echo $firstname_err; ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Last Name field -->
        <div class="form-group">
            <label>Last Name <span class="required">*</span></label>
            <input type="text" name="lastname" value="<?php echo $lastname; ?>">
            <?php 
            // Display error message if there is one
            if (!empty($lastname_err)): ?>
                <span class="error"><?php echo $lastname_err; ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Email field -->
        <div class="form-group">
            <label>Email <span class="required">*</span></label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <?php 
            // Display error message if there is one
            if (!empty($email_err)): ?>
                <span class="error"><?php echo $email_err; ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Password field -->
        <div class="form-group">
            <label>Password <span class="required">*</span></label>
            <input type="password" name="password">
            <?php 
            // Display error message if there is one
            if (!empty($password_err)): ?>
                <span class="error"><?php echo $password_err; ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Confirm Password field -->
        <div class="form-group">
            <label>Confirm Password <span class="required">*</span></label>
            <input type="password" name="confirm_password">
            <?php 
            // Display error message if there is one
            if (!empty($confirm_password_err)): ?>
                <span class="error"><?php echo $confirm_password_err; ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Phone Number field (optional) -->
        <div class="form-group">
            <label>Phone Number<span class="required">*</label>
            <input type="tel" name="phone" value="<?php echo $phone; ?>">
            <?php 
            // Display error message if there is one
            if (!empty($phone_err)): ?>
                <span class="error"><?php echo $phone_err; ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Submit button -->
        <div class="form-group">
            <button type="submit">Register</button>
        </div>
    </form>
</body>
</html>