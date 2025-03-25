<?php
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('admin'); 


if (isset($_GET['pet_id'])) {
    $pet_id = intval($_GET['pet_id']);
    $sql = "SELECT * FROM pets WHERE id = $pet_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $petImage = !empty($row['pet_image']) 
            ? 'data:image/jpeg;base64,' . htmlspecialchars($row['pet_image']) 
            : 'default.jpg';
    } else {
        echo "Pet not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Pet</title>
  <style>
      /* Make the page full screen */
      html, body {
          margin: 0;
          padding: 0;
          width: 100%;
          height: 100%;
          background-color: #000;
      }
      .full-screen {
          display: flex;
          align-items: center;
          justify-content: center;
          width: 100%;
          height: 100%;
      }
      .full-screen img {
          max-width: 100%;
          max-height: 100%;
      }
  </style>
</head>
<body>
  <div class="full-screen">
    <img src="<?php echo $petImage; ?>" alt="Pet Image">
  </div>
</body>
</html>
