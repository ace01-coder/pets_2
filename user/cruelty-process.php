<?php
include('./dbconn/config.php');

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $name     = htmlspecialchars(trim($_POST['name']));
    $phone    = htmlspecialchars(trim($_POST['phone']));
    $email    = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $address  = htmlspecialchars(trim($_POST['address']));
    $petType  = htmlspecialchars(trim($_POST['petType']));
    $petBreed = htmlspecialchars(trim($_POST['petBreed']));
    $info     = htmlspecialchars(trim($_POST['info']));

    $errors = [];
    
    // Validate name
    if (empty($name) || !preg_match("/^[a-zA-Z ]+$/", $name)) {
        $errors[] = "Invalid name.";
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email.";
    }

    // Check for errors before processing the image
    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'message' => implode(" ", $errors)]);
        exit;
    }

    // File handling: Validate and Convert image to base64
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
    
    if (!isset($_FILES['petImage']) || $_FILES['petImage']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'File upload error.']);
        exit;
    }

    // Check if the uploaded file is a valid image type
    $imgInfo = getimagesize($_FILES['petImage']['tmp_name']);
    if ($imgInfo === false || !in_array($imgInfo['mime'], $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Only JPG, JPEG, and PNG files are allowed.']);
        exit;
    }

    // Read and encode image
    $imageContent = file_get_contents($_FILES['petImage']['tmp_name']);
    if ($imageContent === false) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to read the file.']);
        exit;
    }
    $petImageBase64 = base64_encode($imageContent);

    // Insert into the database
    $stmt = $conn->prepare("
        INSERT INTO report (
            reportParty, phone_number, email, address, pet_type, pet_breed, additional_info, pet_image
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssssssss", $name, $phone, $email, $address, $petType, $petBreed, $info, $petImageBase64);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Registration successful!'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to save the record in the database. ' . $stmt->error
        ]);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

$conn->close();
?>
