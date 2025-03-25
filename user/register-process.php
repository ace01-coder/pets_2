<?php
session_start();
include('./dbconn/config.php');
include('./dbconn/authentication.php');
checkAccess('user');

// Retrieve the current user's id
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve owner info directly from the session
    $user_id  = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    // Get the email from the POST data (or from the session if stored there)
    $email = htmlspecialchars(trim($_POST['email']));

    // Get the rest of the pet data from the POST array
    $pet_name       = trim($_POST['pet_name']);
    $pet_type       = trim($_POST['pet_type']);
    $pet_age        = (int) $_POST['pet_age'];
    $pet_breed      = trim($_POST['pet_breed']);
    $pet_info       = trim($_POST['pet_info']);
    $vaccine_status = trim($_POST['vaccine_status']);

    // Handle Pet Image Upload (convert to Base64)
    if (isset($_FILES['pet_image']) && $_FILES['pet_image']['error'] == 0) {
        $imageData = base64_encode(file_get_contents($_FILES['pet_image']['tmp_name']));
    } else {
        $imageData = null;
    }

    // Check for duplicate pet registration using $username and $pet_name
    $check_sql = "SELECT * FROM pets WHERE username = ? AND pet_name = ?";
    $stmt = $conn->prepare($check_sql);
    if (!$stmt) {
        header('Location: register.php?error=Prepare error: ' . $conn->error);
        exit();
    }
    $stmt->bind_param("ss", $username, $pet_name);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        header('Location: register.php?error=Pet already registered!');
        exit();
    }
    $stmt->close();

    // Insert the pet record into the database.
    // Note the order of fields in the INSERT statement must match the order in bind_param:
    // user_id, username, mail, pet_name, pet_age, pet_type, pet_breed, pet_info, pet_image, vaccine_status
    $insert_sql = "INSERT INTO pets (user_id, username, mail, pet_name, pet_age, pet_type, pet_breed, pet_info, pet_image, vaccine_status) 
                   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    if (!$stmt) {
        header('Location: register.php?error=Prepare error: ' . $conn->error);
        exit();
    }
    // Bind parameters. Notice $email is now the third parameter.
    $stmt->bind_param("isssisssss", $user_id, $username, $email, $pet_name, $pet_age, $pet_type, $pet_breed, $pet_info, $imageData, $vaccine_status);

    if ($stmt->execute()) {
        $pet_id = $conn->insert_id;
        $stmt->close();

        // Insert vaccine details if applicable
        if ($vaccine_status == "Vaccinated" && isset($_POST['vaccine_type'])) {
            foreach ($_POST['vaccine_type'] as $index => $type) {
                $vaccine_name    = trim($_POST['vaccine_name'][$index]);
                $vaccine_date    = trim($_POST['vaccine_date'][$index]);
                $administered_by = trim($_POST['administered_by'][$index]);

                $vaccine_sql = "INSERT INTO vaccines (pet_id, vaccine_type, vaccine_name, vaccine_date, administered_by) 
                                VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($vaccine_sql);
                if (!$stmt) {
                    header('Location: register.php?error=Vaccine prepare error: ' . $conn->error);
                    exit();
                }
                $stmt->bind_param("issss", $pet_id, $type, $vaccine_name, $vaccine_date, $administered_by);
                $stmt->execute();
                $stmt->close();
            }
        }

        // Generate QR Code and update pet record
        include 'phpqrcode/qrlib.php';
        $qr_data = "http://localhost/pets/user/view_pet.php?id=" . $pet_id;
        ob_start();
        QRcode::png($qr_data, null, QR_ECLEVEL_L, 5);
        $qr_image = base64_encode(ob_get_clean());

        $qr_update_sql = "UPDATE pets SET qr_code = ? WHERE id = ?";
        $stmt = $conn->prepare($qr_update_sql);
        if (!$stmt) {
            header('Location: register.php?error=QR code prepare error: ' . $conn->error);
            exit();
        }
        $stmt->bind_param("si", $qr_image, $pet_id);
        $stmt->execute();
        $stmt->close();

        header('Location: register.php?success=Pet registered successfully!');
        exit();
    } else {
        header('Location: register.php?error=Failed to register pet!');
        exit();
    }
}
$conn->close();
?>
