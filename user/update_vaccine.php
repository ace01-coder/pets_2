<?php
include('./dbconn/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input values
    $petId = (int) $_POST['petId'];
    $vaccineType = trim($_POST['vaccineType']);
    $vaccineName = trim($_POST['vaccineName']);
    $vaccineDate = trim($_POST['vaccineDate']);
    $administeredBy = trim($_POST['administeredBy']);


    // If no record was updated, try inserting a new record
    $sqlInsert = "INSERT INTO vaccines (pet_id, vaccine_type, vaccine_name, vaccine_date, administered_by) VALUES (?, ?, ?, ?, ?)";
    if ($stmt = $conn->prepare($sqlInsert)) {
        $stmt->bind_param("issss", $petId, $vaccineType, $vaccineName, $vaccineDate, $administeredBy);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "success: record inserted";
        } else {
            echo "error: no rows affected";
        }
        $stmt->close();
    } else {
        echo "error: prepare failed - " . $conn->error;
    }
} else {
    echo "error: invalid request";
}
?>
