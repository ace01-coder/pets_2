<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bpa_system";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$pet_id = $_GET['id'];
$sql = "SELECT * FROM pets WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pet_id);
$stmt->execute();
$result = $stmt->get_result();
$pet = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pet Registered Successfully</title>
</head>
<body>
    <h2>Pet Registered Successfully!</h2>
    <p><strong>Pet Name:</strong> <?php echo htmlspecialchars($pet['pet_name']); ?></p>
    <p><strong>Owner:</strong> <?php echo htmlspecialchars($pet['name']); ?></p>

    <h3>Scan the QR Code to View Pet Details</h3>
    <img src="data:image/png;base64,<?php echo $pet['qr_code']; ?>" alt="QR Code" width="200">

    <br><br>
    <a href="http://localhost/pets/user/view_pet.php?id=<?php echo $pet_id; ?>">View Pet Profile</a>
    <br>
    <a href="register.php">Go Back to Home</a>
</body>

</html>

<?php
$conn->close();
?>
