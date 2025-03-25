<?php
function checkAccess($requiredRole) {
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to login page if not logged in
        header("Location: ../index.php");
        exit();
    }

    // Check if the logged-in user has the required role
    if ($_SESSION['role'] !== $requiredRole) {
        // Redirect to error page if the role doesn't match
        header("Location: ../index.php");
        exit();
    }
}
?>
