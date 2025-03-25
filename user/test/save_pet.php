<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_database";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $owner_name = $_POST['name'];
    $pet_name = $_POST['pet_name'];
    $pet_type = $_POST['pet_type'];
    $pet_age = $_POST['pet_age'];
    $pet_breed = $_POST['pet_breed'];
    $pet_info = $_POST['pet_info'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $vaccine_status = $_POST['vaccine_status'];

    // Handle Pet Image (Convert to Base64)
    if (isset($_FILES['pet_image']) && $_FILES['pet_image']['error'] == 0) {
        $imageData = base64_encode(file_get_contents($_FILES['pet_image']['tmp_name']));
    } else {
        $imageData = null;
    }

    // Check if the pet is already registered
    $check_sql = "SELECT * FROM pets WHERE name = ? AND pet_name = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ss", $owner_name, $pet_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Pet already exists
        echo "<script>alert('This pet is already registered under the same owner.'); window.location.href='add_pet.php';</script>";
        exit();
    }

    // Insert into pets table
    $insert_sql = "INSERT INTO pets (name, phone, email, address, pet_name, pet_age, pet_type, pet_breed, pet_info, pet_image, vaccine_status) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sssssssssss", $owner_name, $phone, $email, $address, $pet_name, $pet_age, $pet_type, $pet_breed, $pet_info, $imageData, $vaccine_status);
    
    if ($stmt->execute()) {
        $pet_id = $conn->insert_id; // Get the last inserted pet ID

        // Insert vaccine records if vaccinated
        if ($vaccine_status == "Vaccinated" && isset($_POST['vaccine_type'])) {
            foreach ($_POST['vaccine_type'] as $index => $type) {
                $vaccine_name = $_POST['vaccine_name'][$index];
                $vaccine_date = $_POST['vaccine_date'][$index];
                $administered_by = $_POST['administered_by'][$index];

                $vaccine_sql = "INSERT INTO vaccines (pet_id, vaccine_type, vaccine_name, vaccine_date, administered_by) 
                                VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($vaccine_sql);
                $stmt->bind_param("issss", $pet_id, $type, $vaccine_name, $vaccine_date, $administered_by);
                $stmt->execute();
            }
        }

        // Generate QR Code (Base64) without saving to folder
        include 'phpqrcode/qrlib.php'; // Ensure you have phpqrcode library
        $qr_data = "http://localhost/pets/user/test/view_pet.php?id=" . $pet_id;
        ob_start();
        QRcode::png($qr_data, null, QR_ECLEVEL_L, 5);
        $qr_image = base64_encode(ob_get_clean());

        // Save QR code to database
        $qr_update_sql = "UPDATE pets SET qr_code = ? WHERE id = ?";
        $stmt = $conn->prepare($qr_update_sql);
        $stmt->bind_param("si", $qr_image, $pet_id);
        $stmt->execute();

        echo "<script>alert('Pet registered successfully!'); window.location.href='success.php?id=$pet_id';</script>";
    } else {
        echo "<script>alert('Error registering pet.'); window.location.href='add_pet.php';</script>";
    }
}

$conn->close();
?>
