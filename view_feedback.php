<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "campaign_feedback";

//connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$limit = 10; 
if (isset($_GET["page"])) {
    $page  = $_GET["page"]; 
} else { 
    $page = 0;
};
$start_from = ($page - 0) * $limit;

//SQL query to select all records from the feedback table
$sql = "SELECT * FROM feedback ORDER BY id ASC LIMIT $start_from, $limit";
$result = $conn->query($sql);

// Count the total number of feedback records
$total_sql = "SELECT COUNT(id) FROM feedback";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_row();
$total_records = $total_row[0];
$total_pages = ceil($total_records / $limit);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .table-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 2px;
        }
        .pagination a.active {
            background-color: #28a745;
            color: white;
            border: 1px solid #28a745;
        }
        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<div class="table-container">
    <h2>Feedback Records</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Feedback</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row["id"]. "</td>
                        <td>" . $row["name"]. "</td>
                        <td>" . $row["email"]. "</td>
                        <td>" . $row["feedback"]. "</td>
                        <td>" . $row["rating"]. "</td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No feedback found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='view_feedback.php?page=".$i."'";
            if ($i == $page) echo " class='active'";
            echo ">".$i."</a> ";
        }
        ?>
    </div>
</div>

<?php

$conn->close();
?>

</body>
</html>
