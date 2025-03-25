<?php
include('dbconn/config.php');

// Get pet_id from the GET parameter and validate it.
$pet_id = isset($_GET['pet_id']) ? (int) $_GET['pet_id'] : 0;

if ($pet_id > 0) {
    // Use a prepared statement to safely query the vaccines table.
    $stmt = $conn->prepare("SELECT vaccine_type, vaccine_name, vaccine_date, administered_by FROM vaccines WHERE pet_id = ?");
    $stmt->bind_param("i", $pet_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    
    // Return the results as JSON.
    echo json_encode($data);
    $stmt->close();
} else {
    echo json_encode([]);
}
?>
