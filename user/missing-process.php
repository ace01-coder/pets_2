<?php
include('./dbconn/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $name    = htmlspecialchars(trim($_POST['name']));
    $phone   = htmlspecialchars(trim($_POST['phone']));
    $email   = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $address = htmlspecialchars(trim($_POST['address']));
    $petName = htmlspecialchars(trim($_POST['petName']));
    $petType = htmlspecialchars(trim($_POST['petType']));
    $petBreed = htmlspecialchars(trim($_POST['petBreed']));
    $info    = htmlspecialchars(trim($_POST['info']));

    // Validate Inputs
    $errors = [];
    if (empty($name) || !preg_match("/^[a-zA-Z ]+$/", $name)) {
        $errors[] = "Invalid name.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email.";
    }

    // If validation fails, return errors
    if (!empty($errors)) {
        echo json_encode(['status' => 'error', 'message' => implode(' ', $errors)]);
        exit;
    }

    // Handle image upload
    $base64Image = null;
    if (isset($_FILES['petImage']) && $_FILES['petImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['petImage']['tmp_name'];
        $fileSize    = $_FILES['petImage']['size'];
        $fileType    = mime_content_type($fileTmpPath);

        // Validate file type (allow JPEG, PNG only)
        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG and PNG are allowed.']);
            exit;
        }

        // Limit file size to 5MB
        if ($fileSize > 5 * 1024 * 1024) {
            echo json_encode(['status' => 'error', 'message' => 'File size exceeds 5MB limit.']);
            exit;
        }

        // Convert image to Base64
        $imageData   = file_get_contents($fileTmpPath);
        $base64Image = base64_encode($imageData);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
        exit;
    }

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO missing (reportParty, phone_number, email, address, pet_name, petType, pet_breed, additional_info, pet_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $phone, $email, $address, $petName, $petType, $petBreed, $info, $base64Image);

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Registration successful!'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save the upload record. ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

$conn->close();
?>
