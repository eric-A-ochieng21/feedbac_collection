<?php
// Database configuration
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "campaign_feedback";

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $feedback = isset($_POST['feedback']) ? htmlspecialchars(trim($_POST['feedback'])) : '';
    $rating = isset($_POST['rating']) ? htmlspecialchars(trim($_POST['rating'])) : '';

    // Check if all required fields are filled
    if (!empty($name) && !empty($email) && !empty($feedback) && !empty($rating)) {
        //connect to the database
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        $sql = "INSERT INTO feedback (name, email, feedback, rating) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $name, $email, $feedback, $rating);

        // Execute the query 
        if ($stmt->execute()) {
            echo "Your feedback submitted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

       
        $stmt->close();
        $conn->close();
    } else {
        echo "All fields are required.";
    }
} else {
    echo "Invalid request.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button Link Example</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: blue;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }

        .button:hover {
            background-color: darkblue;
        }
    </style>
</head>
<body>
    <a href="view_feedback.php" class="button">View Feedback</a>
</body>
</html>

