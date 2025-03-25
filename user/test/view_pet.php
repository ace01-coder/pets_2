<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_database";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Invalid request. Pet ID is required.");
}

$pet_id = intval($_GET['id']); // Ensure it's an integer

$sql = "SELECT * FROM pets WHERE id = '$pet_id'";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    die("Pet not found.");
}

$pet = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pet Profile</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <h2>Pet Profile</h2>
    
    <table>
        <tr>
            <th>Information</th>
            <th>Vaccine Records</th>
        </tr>
        <tr>
            <td>
                <p><strong>Owner:</strong> <?php echo htmlspecialchars($pet['name']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($pet['phone']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($pet['email']); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($pet['address']); ?></p>
                
                <h3>Pet Information</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($pet['pet_name']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($pet['pet_age']); ?></p>
                <p><strong>Type:</strong> <?php echo htmlspecialchars($pet['pet_type']); ?></p>
                <p><strong>Breed:</strong> <?php echo htmlspecialchars($pet['pet_breed']); ?></p>
                <p><strong>Additional Info:</strong> <?php echo htmlspecialchars($pet['pet_info']); ?></p>
            </td>
            <td>
                <h3>Vaccine Records</h3>
                <?php
                $vaccine_sql = "SELECT * FROM vaccines WHERE pet_id = '$pet_id'";
                $vaccine_result = $conn->query($vaccine_sql);
                
                if ($vaccine_result->num_rows > 0) {
                    while ($vaccine = $vaccine_result->fetch_assoc()) {
                        echo "<p><strong>Type:</strong> " . htmlspecialchars($vaccine['vaccine_type']) . "</p>";
                        echo "<p><strong>Name:</strong> " . htmlspecialchars($vaccine['vaccine_name']) . "</p>";
                        echo "<p><strong>Date:</strong> " . htmlspecialchars($vaccine['vaccine_date']) . "</p>";
                        echo "<p><strong>Administered By:</strong> " . htmlspecialchars($vaccine['administered_by']) . "</p>";
                        echo "<hr>";
                    }
                } else {
                    echo "<p>No vaccines recorded.</p>";
                }
                ?>
            </td>
        </tr>
    </table>

    <br>
    <a href="index.php">Go Back</a>
</body>
</html>

<?php
$conn->close();
?>
