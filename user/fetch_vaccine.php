<?php
include('./dbconn/config.php');
include('./dbconn/authentication.php');

if (isset($_GET['pet_id'])) {
    $pet_id = (int) $_GET['pet_id'];
    $stmt = $conn->prepare("SELECT vaccine_type, vaccine_name, vaccine_date, administered_by FROM vaccines WHERE pet_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $pet_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $vaccineRecords = [];
        while ($row = $result->fetch_assoc()) {
            $vaccineRecords[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($vaccineRecords);
        $stmt->close();
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
$conn->close();
?>
