<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bpa_system";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM pets";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Pet Information</title>
</head>
<body>
    <h2>Pet Information</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Pet Name</th>
            <th>Pet Type</th>
            <th>Pet Image</th>
            <th>Vaccinated</th>
            <th>Vaccine Records</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['pet_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['pet_type']) . "</td>";

            // Convert Base64 image to HTML safely
            $imageData = $row['pet_image'];
            if (!empty($imageData)) {
                echo "<td><img src='data:image/jpeg;base64," . htmlspecialchars($imageData) . "' width='100' height='100'></td>";
            } else {
                echo "<td>No Image</td>";
            }

            // Fetch vaccine records
            $pet_id = $row['id'];
            $vaccine_sql = "SELECT * FROM vaccines WHERE pet_id = '$pet_id'";
            $vaccine_result = $conn->query($vaccine_sql);

            // Check if pet has been vaccinated
            $is_vaccinated = ($vaccine_result->num_rows > 0) ? "Yes" : "No";
            echo "<td><strong>" . $is_vaccinated . "</strong></td>";

            echo "<td>";
            if ($vaccine_result->num_rows > 0) {
                while ($vaccine = $vaccine_result->fetch_assoc()) {
                    echo "<strong>Type:</strong> " . htmlspecialchars($vaccine['vaccine_type']) . "<br>";
                    echo "<strong>Name:</strong> " . htmlspecialchars($vaccine['vaccine_name']) . "<br>";
                    echo "<strong>Date:</strong> " . htmlspecialchars($vaccine['vaccine_date']) . "<br>";
                    echo "<strong>Administered By:</strong> " . htmlspecialchars($vaccine['administered_by']) . "<br>";
                    echo "<hr>";
                }
            } else {
                echo "No vaccines recorded.";
            }
            echo "</td>";

            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
