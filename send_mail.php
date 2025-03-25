<?php
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name         = $_POST['name'];
    $email        = $_POST['email'];
    $phone        = $_POST['phone'];
    $address      = $_POST['address'];
    $occupation   = $_POST['occupation'];
    $homeType     = $_POST['homeType'];
    $adoptReason  = $_POST['adoptReason'];
    $experience   = $_POST['petExperience'];

    $adminEmail = "macefelixerp@gmail.com"; // Change this to your admin email
    $subject = "New Pet Adoption Request from $name";

    $message = "
        <h3>Adoption Request Details:</h3>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Address:</strong> $address</p>
        <p><strong>Occupation:</strong> $occupation</p>
        <p><strong>Home Type:</strong> $homeType</p>
        <p><strong>Reason for Adoption:</strong> $adoptReason</p>
        <p><strong>Pet Experience:</strong> $experience</p>
    ";

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'macefelixerp@gmail.com'; // Change to your email
        $mail->Password   = 'uvhg txfl djhk uksw';  // Use App Password (if using Gmail)
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Sender
        $mail->setFrom('macefelixerp@mail.com', 'Pet Adoption Center');

        // Send email to Admin
        $mail->addAddress($adminEmail, "Admin");
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->send();

        // Send Confirmation Email to User
        $mail->clearAddresses();
        $mail->addAddress($email, $name);
        $mail->Subject = "Your Adoption Request Has Been Received";
        $mail->Body    = "<p>Dear $name,</p>
                          <p>Thank you for your adoption request. We will review it and contact you soon.</p>
                          <p>Best regards,</p>
                          <p>Pet Adoption Center</p>";
        $mail->send();

        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
    }
}
?>
