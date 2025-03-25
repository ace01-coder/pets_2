<?php
include('./dbconn/config.php');
include('./dbconn/authentication.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pet_id']) && isset($_POST['action'])) {
    $petId = (int) $_POST['pet_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $query = "UPDATE adoption SET approved = 1, remark = 'Approved' WHERE pet_id = ?";
    } elseif ($action === 'reject') {
        $query = "UPDATE adoption SET approved = -1, remark = 'Rejected' WHERE pet_id = ?";
    } else {
        die("Invalid action");
    }

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $petId);
        $stmt->execute();
        $stmt->close();
        // Redirect back with a success message (optional)
        header("Location: adoption_list.php?success=Record processed successfully");
    } else {
        die("Error: " . $conn->error);
    }
}
$conn->close();
?>
