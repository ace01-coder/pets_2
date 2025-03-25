<?php
require 'dbconn/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $occupation = $_POST['occupation'];
    $homeType = $_POST['homeType'];
    $adoptReason = $_POST['adoptReason'];
    $petExperience = $_POST['petExperience'];

    // Save the adoption request in the database
    $sql = "INSERT INTO adoption_requests (name, phone, email, address, occupation, home_type, adopt_reason, pet_experience, status) 
            VALUES ('$name', '$phone', '$email', '$address', '$occupation', '$homeType', '$adoptReason', '$petExperience', 'pending')";

    if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn); // Get the last inserted request ID

        // Insert a notification into the database
        $notif_sql = "INSERT INTO notifications (adoption_id, message, status) 
                      VALUES ('$last_id', 'New adoption request from $name', 'unread')";
        mysqli_query($conn, $notif_sql);

        // Redirect to confirmation page
        header("Location: adoption_confirmation.php?success=true");
        exit;
    } else {
        header("Location: adoption_form.php?error=db_failed");
        exit;
    }
}
?>
