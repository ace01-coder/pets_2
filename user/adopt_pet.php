<?php
session_start();
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('user');

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}

// Retrieve and sanitize inputs
$petId    = isset($_POST['petId']) ? (int) $_POST['petId'] : 0;
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$petName  = isset($_POST['petName']) ? trim($_POST['petName']) : '';
$petAge   = isset($_POST['petAge']) ? (int) $_POST['petAge'] : 0;
$petBreed = isset($_POST['petBreed']) ? trim($_POST['petBreed']) : '';
$petInfo  = isset($_POST['petInfo']) ? trim($_POST['petInfo']) : '';
$mail     = isset($_POST['petMail']) ? trim($_POST['petMail']) : '';
$petImage = isset($_POST['petImage']) ? trim($_POST['petImage']) : '';

// Basic validation
if ($petId <= 0 || empty($username) || empty($petName)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input provided.']);
    exit();
}

// Check for duplicate adoption records for this pet
$checkQuery = "SELECT adoption_id FROM adoption WHERE pet_id = ?";
if ($stmt = $conn->prepare($checkQuery)) {
    $stmt->bind_param("i", $petId);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'An adoption record for this pet already exists.']);
        $stmt->close();
        exit();
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Database prepare error: ' . $conn->error]);
    exit();
}

// Insert the adoption record
$queryAdoption = "INSERT INTO adoption 
    (pet_id, username, mail, pet_name, pet_age, pet_breed, pet_info, pet_image, approved)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)";
if ($stmt = $conn->prepare($queryAdoption)) {
    // Adjust binding order if needed; here we bind:
    // pet_id (i), username (s), mail (s), pet_name (s), pet_age (i), pet_breed (s), pet_info (s), pet_image (s)
    $stmt->bind_param("isssisss", $petId, $username, $mail, $petName, $petAge, $petBreed, $petInfo, $petImage);
    if ($stmt->execute()) {
        $stmt->close();
        echo json_encode(['success' => true, 'message' => 'Adoption process initiated successfully.']);
        exit();
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to initiate adoption process.']);
        $stmt->close();
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Prepare error: ' . $conn->error]);
    exit();
}

$conn->close();
?>
