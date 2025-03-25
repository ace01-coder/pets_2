<?php
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('user'); 
$userId = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('./disc/partials/header.php'); ?>
    <style>
        .form-container {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .btn-submit {
            display: block;
            width: auto;
            padding: 12px 30px;
            border-radius: 5px;
            margin: 0 auto;
        }
    </style>
</head>
<body class="vertical light">
    <div class="wrapper">
        <?php include('./disc/partials/navbar.php'); ?>
        <?php include('./disc/partials/sidebar.php'); ?>

        <main role="main" class="main-content">
            <div class="container">
                <div class="form-container">
                    <h4 class="form-title">Report Cruelty</h4>
                    <form id="regForm" enctype="multipart/form-data" method="POST">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div id='nameError' class='text-danger d-none'>Name is required and cannot contain numbers.</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                                <div id='phoneError' class='text-danger d-none'>Please enter a valid phone number (11 digits).</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div id='emailError' class='text-danger d-none'>Please enter a valid email address.</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" required></textarea>
                                <div id='addressError' class='text-danger d-none'>Address is required.</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="petType" class="form-label">Pet Type</label>
                                <input type="text" class="form-control" id="petType" name="petType" required>
                                <div id='petTypeError' class='text-danger d-none'>Pet type is required.</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="petBreed" class="form-label">Breed</label>
                                <input type="text" class="form-control" id="petBreed" name="petBreed" required>
                                <div id='petBreedError' class='text-danger d-none'>Pet Breed is required.</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="info" class="form-label">Additional Information</label>
                                <textarea class="form-control" id="info" name="info"></textarea>
                                <div id='infoError' class='text-danger d-none'>Additional information is required.</div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="petImage" class="form-label">Pet Image</label>
                                <input type="file" class="form-control" id="petImage" name="petImage" accept="image/*" required>
                                <div id='petImageError' class='text-danger d-none'>Please upload a valid image file.</div>
                            </div>
                            <div class="col-md-12 form-group text-center">
                                <button type="button" id="submitForm" class="btn btn-primary btn-submit">Submit</button>
                            </div>
                        </div>
                    </form>
                    <div id="submitFeedback" class="alert d-none mt-3"></div>
                </div>
            </div>

            <footer class=" text-dark py-4 border-top m-3">
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
     
    <!-- Success Modal (Compact & Styled) -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-sm">
            <div class="modal-header bg-white border-0 p-2">
            <h6 class="modal-title w-100 text-white fw-bold">
                    <i class="bi bi-check-circle-fill me-1"></i>
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body text-center">
                  Your form has been submitted successfully!
            </div>
            <div class="modal-footer border-0 d-flex justify-content-center">
                <button type="button" class="btn btn-sm btn-success px-3" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>

</div>


    <?php include('./script.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
   document.getElementById('submitForm').addEventListener('click', function () {
    if (validateForm()) {
        const form = document.getElementById('regForm');
        const formData = new FormData(form);

        fetch('cruelty-process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const feedback = document.getElementById('submitFeedback');
            feedback.classList.remove('d-none');
            feedback.classList.add(data.status === 'success' ? 'alert-success' : 'alert-danger');
            feedback.textContent = data.status === 'success' ? 'Successfully Registered!' : 'Registration Failed!';

            if (data.status === 'success') {
                // Show the success modal
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();

                // Reset the form
                form.reset();
            }

            setTimeout(function() {
        feedback.classList.add('d-none');
    }, 3000); 
        })
        .catch(error => {
            const feedback = document.getElementById('submitFeedback');
            feedback.classList.remove('d-none');
            feedback.classList.add('alert-danger');
            feedback.textContent = 'An error occurred during the submit process';
        });
    }
});


        function validateForm() {
            let isValid = true;

            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const email = document.getElementById('email').value.trim();
            const address = document.getElementById('address').value.trim();
            const petType = document.getElementById('petType').value.trim();
            const petBreed = document.getElementById('petBreed').value.trim();
            const info = document.getElementById('info').value.trim();
            const petImage = document.getElementById('petImage').files[0];

            const nameError = document.getElementById('nameError');
            if (!name || /\d/.test(name)) {
                nameError.classList.remove('d-none');
                isValid = false;
            } else {
                nameError.classList.add('d-none');
            }

            const phoneError = document.getElementById('phoneError');
            if (!/^[0-9]{11}$/.test(phone)) {
                phoneError.classList.remove('d-none');
                isValid = false;
            } else {
                phoneError.classList.add('d-none');
            }

            const emailError = document.getElementById('emailError');
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                emailError.classList.remove('d-none');
                isValid = false;
            } else {
                emailError.classList.add('d-none');
            }

            const addressError = document.getElementById('addressError');
            if (!address) {
                addressError.classList.remove('d-none');
                isValid = false;
            } else {
                addressError.classList.add('d-none');
            }

            const petTypeError = document.getElementById('petTypeError');
            if (!petType) {
                petTypeError.classList.remove('d-none');
                isValid = false;
            } else {
                petTypeError.classList.add('d-none');
            }

            const petBreedError = document.getElementById('petBreedError');
            if (!petBreed) {
                petBreedError.classList.remove('d-none');
                isValid = false;
            } else {
                petBreedError.classList.add('d-none');
            }

            const infoError = document.getElementById('infoError');
            if (!info) {
                infoError.classList.remove('d-none');
                isValid = false;
            } else {
                infoError.classList.add('d-none');
            }

            const petImageError = document.getElementById('petImageError');
            if (!petImage || !petImage.type.startsWith('image/')) {
                petImageError.classList.remove('d-none');
                isValid = false;
            } else {
                petImageError.classList.add('d-none');
            }

            return isValid;
        }
    </script>
</body>
</html>