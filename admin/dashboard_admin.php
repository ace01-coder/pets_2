<?php
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('admin'); 

?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <?php include('./disc/partial/header.php'); ?>
</head>
<body class='vertical light'>
    <div class='wrapper'>
        <?php include('./disc/partial/navbar.php'); ?>
        <?php include('./disc/partial/sidebar.php'); ?>

        <main role='main' class='main-content'>
        
        </main>
    </div>
    <?php include('./disc/partial/script.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
