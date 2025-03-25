<?php
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('user'); 
$userId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('./disc/partials/header.php');
    ?>
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
</head>
    
    <div class="loader-mask">
        <div class="loader">
            <div></div>
            <div></div>
        </div>
    </div>
    
 
  <body class="vertical  light">
    <div class="wrapper">
    <div class="wrapper">


    <?php include('./disc/partials/navbar.php');
        ?>
        <?php include('./disc/partials/sidebar.php');
        ?>

      <main role="main" class="main-content">

      <!--YOUR CONTENTHERE-->
        
        <div class="container my-6">
          <div class="row ">
            <div class="col col-md-6">
              <img class="img-fluid rounded-lg " src="img/animal_welfare.jpg" alt="animal_welfare">
            </div>
            <div class="col-md  "> 
              <h2 class="row px-4 pt-2 fw-bold">Barangay Animal Welfare</h2>
              <p class="row-md-4 px-4 text-overly">Barangay Animal Welfare promotes animal well-being by encouraging responsible pet ownership, preventing abuse, addressing stray animal issues, and providing resources for pet care, all to foster a compassionate and safe community for animals and residents.</p>
              <div class=" col-12-md-4 justify-content-center  text-center">
              </div>
            </div>
          </div>
        </div>
               

        <div class="container my-6">
          <div class="row  ">
            <div class="col-md-4 p-2">
              <img class="img-fluid rounded-lg" src="img/dog1.jpg" alt="Animal">
            </div>
            <div class="col-md-4 p-2">
              <img class="img-fluid rounded-lg" src="img/dog1.jpg" alt="Animal">
            </div>
            <div class="col-md-4 p-2">
            <img class="img-fluid rounded-lg" src="img/dog1.jpg" alt="Animal">
            </div>
            </div>
            <div class=" col-12-md-4 justify-content-center  text-center">
            <a href="pet_view.php" class=" btn btn-lg btn-primary">Pet for adoption </a> 
            </div>
          </div> 
  
          <div class="container my-6">
            <div class="row ">
              <div class="col-md "> 
                <h2 class="row px-4 pt-2 fw-bold">Barangay Animal Welfare</h2>
                <p class="row-md-4 px-4 text-overly">Barangay Animal Welfare promotes animal well-being by encouraging responsible pet ownership, preventing abuse, addressing stray animal issues, and providing resources for pet care, all to foster a compassionate and safe community for animals and residents.</p>
                <div class=" col-12-md-4 justify-content-center  text-center">
                  <a href="cruelty.php" class=" btn btn-lg btn-primary">Report </a> 
                </div>
              </div>
              <div class="col col-md-6">
                <img class="img-fluid rounded-lg " src="img/animal_welfare.jpg" alt="animal_welfare">
              </div>
            </div>
          </div>

          <div class="container my-6">
            <div class="row ">
              <div class="col-md  "> 
                <h2 class="col px-4 pt-2 fw-bold text-center">About</h2>
                <p class="row-md-4 px-4 text-overly">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam, quaerat? Quae cupiditate quisquam dolores sit, blanditiis quo perspiciatis ratione placeat quibusdam, odio odit animi mollitia, modi dicta veritatis sint aut?Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores sapiente, aut itaque dolor nesciunt perferendis sit libero laboriosam qui esse maxime consequatur, nostrum voluptatibus culpa hic commodi inventore earum excepturi.</p>
              </div>
            </div>
          </div>
         
          <footer class=" text-dark py-4 border-top">
  <div class="container">
    <div class="row align-items-center text-center text-md-start">
      
      <!-- Social Media Icons -->
      <div class="col-12 col-md-4 mb-3 mb-md-0 d-flex justify-content-center justify-content-md-start">
        <a href="#" class="text-primary m-3 fs-4"><i class="fab fa-facebook"></i></a>
        <a href="#" class="text-danger m-3 fs-4"><i class="fab fa-instagram"></i></a>
        <a href="#" class="text-info m-3 fs-4"><i class="fab fa-twitter"></i></a>
      </div>

      <!-- Copyright Text -->
      <div class="col-12 col-md-4 text-center">
        <small>&copy; 2025 Barangay Pet Welfare. <i>All Rights Reserved.</i></small>
      </div>

      <!-- Links and Sponsor -->
      <div class="col-12 col-md-4 text-center text-md-end">
        <a href="#" class="text-primary fw-bold me-2">Terms of Use</a>
        <a href="#" class="text-primary fw-bold me-2">Privacy Policy</a>
        <a href="#" class="text-primary fw-bold">Sitemap</a>
        <p class="d-inline-block text-muted ms-2">
          Website sponsored by <a href="#" class="text-primary fw-bold">BPWS</a>
        </p>
      </div>

    </div>
  </div>
</footer>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        
      </main>
      
      </div>  
  <!-- Include jQuery -->
<?php include ('./script.php'); ?>

  </body>
</html>
