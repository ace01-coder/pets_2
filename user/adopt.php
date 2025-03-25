<?php
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('user'); 

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method.";
    exit;
}

// Retrieve and sanitize form data
$pet_id = isset($_POST['pet_id']) ? intval($_POST['pet_id']) : 0;
$adopter_email = isset($_POST['adopter_email']) ? filter_var($_POST['adopter_email'], FILTER_VALIDATE_EMAIL) : false;
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

if (!$pet_id || !$adopter_email || empty($message)) {
    echo "All fields are required and must be valid.";
    exit;
}

// Retrieve pet details (and owner email) from the database using the pet_id
$sql = "SELECT * FROM adoption WHERE id = $pet_id";
$result = $conn->query($sql);
    

$pet = $result->fetch_assoc();

// Check if the owner's email is available
if (!isset($pet['owner_email']) || empty($pet['owner_email'])) {
    echo "Owner email is not available for this pet.";
    exit;
}

$recipient = $pet['owner_email'];

// Compose the email
$subject = "Adoption Request for " . $pet['pet_name'];
$body = "Hello,\n\n";
$body .= "You have received an adoption request for your pet listing:\n\n";
$body .= "Pet Name: " . $pet['pet_name'] . "\n";
$body .= "Breed: " . $pet['pet_breed'] . "\n";
$body .= "Additional Info: " . $pet['additional_info'] . "\n\n";
$body .= "Adopter's Email: " . $adopter_email . "\n";
$body .= "Message from the adopter:\n" . $message . "\n\n";
$body .= "Regards,\nYour Adoption Website";

// Email headers (update the From address with an appropriate sender for your domain)
$headers = "From: noreply@yourdomain.com\r\n";
$headers .= "Reply-To: " . $adopter_email . "\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Send the email
if (mail($recipient, $subject, $body, $headers)) {
    echo "Your adoption request has been sent successfully!";
} else {
    echo "Failed to send email. Please try again later.";
}

$conn->close();
?>
