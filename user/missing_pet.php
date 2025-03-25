<?php
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('user'); 
?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <?php include('./disc/partials/header.php'); ?>
    <style>
       .card-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); 
    gap: 20px;
    justify-content: center;
}

.card {
    width: 100%;
    max-width: 300px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
}

        .card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .card-body {
            padding: 15px;
            text-align: left; /* Aligns text to the left */
        }
    </style>
</head>
<body class='vertical light'>
    <div class='wrapper'>
        <?php include('./disc/partials/navbar.php'); ?>
        <?php include('./disc/partials/sidebar.php'); ?>

        <main role='main' class='main-content'>
            <div class='container'>
            <div class='container'>
                 <!-- Button to open modal -->
                 <button type="button" class="btn btn-success me-2 p-2" data-bs-toggle="modal" data-bs-target="#reportPetModal">
                        + Report Missing Pet
                    </button>
                    <div class="d-flex justify-content-center mb-4">
    <h2 class='text-center mb-0'>Missing Pets</h2>
</div>
                </div>
                <div class='card-container'>
                    <?php
                    $query = "SELECT * FROM missing";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $imageSrc = !empty($row['pet_image']) 
                            ? 'data:image/jpeg;base64,' . htmlspecialchars($row['pet_image']) 
                            : 'default.jpg';
                            echo "<div class='card'>
                                    <img src='$imageSrc' alt='Pet Image'>
                                    <div class='card-body flex-start'>
                                        <h5 class='card-title'>" . htmlspecialchars($row['pet_name']) . "</h5>
                                        <p class='card-text'><strong>Type:</strong> " . htmlspecialchars($row['petType']) . "</p>
                                        <p class='card-text'><strong>Breed:</strong> " . htmlspecialchars($row['pet_breed']) . "</p>
                                        <p class='card-text'><strong>Owner:</strong> " . htmlspecialchars($row['reportParty']) . "</p>
                                        <p class='card-text'><strong>Phone:</strong> " . htmlspecialchars($row['phone_number']) . "</p>
                                        <p class='card-text'><strong>Address:</strong> " . htmlspecialchars($row['address']) . "</p>
                                        <p class='card-text'><strong>Info:</strong> " . htmlspecialchars($row['additional_info']) . "</p>
                                    </div>
                                  </div>";
                        }
                    
                    
                    } else {
                        echo "<p class='text-center'>No missing pets reported yet.</p>";
                    }
                    ?>
                </div>
            </div>
        </main>
    </div>

 
    <!-- Modal for Reporting a Missing Pet -->
    <div class="modal fade" id="reportPetModal" tabindex="-1" aria-labelledby="reportPetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportPetModalLabel">Report a Missing Pet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id='regForm' enctype='multipart/form-data' method='POST'>
                        <div class='row'>

                            <div class='col-md-6 form-group'>
                                <label for='name' class='form-label'>Name</label>
                                <input type='text' class='form-control' id='name' name='name' required>
                                <div id='nameError' class='text-danger d-none'>Name is required and cannot contain
                                    numbers.</div>
                            </div>

                            <div class='col-md-6 form-group'>
                                <label for='phone' class='form-label'>Phone Number</label>
                                <input type='text' class='form-control' id='phone' name='phone' required>
                                <div id='phoneError' class='text-danger d-none'>Please enter a valid phone number (11
                                    digits).</div>
                            </div>

                            <div class='col-md-6 form-group'>
                                <label for='email' class='form-label'>Email</label>
                                <input type='email' class='form-control' id='email' name='email' required>
                                <div id='emailError' class='text-danger d-none'>Please enter a valid email address.
                                </div>
                            </div>

                            <div class='col-md-6 form-group'>
                                <label for='address' class='form-label'>Address</label>
                                <textarea class='form-control' id='address' name='address' required></textarea>
                                <div id='addressError' class='text-danger d-none'>Address is required.</div>
                            </div>
                            <div class='col-md-6 form-group'>
                                <label for='petName' class='form-label'>Pet Name</label>
                                <input type='text' class='form-control' id='petName' name='petName' required>
                                <div id='petNameError' class='text-danger d-none'>Pet Name is required.</div>
                            </div>
                            <div class='col-md-6 form-group'>
                                <label for='petType' class='form-label'>Pet Type</label>
                                <input type='text' class='form-control' id='petType' name='petType' required>
                                <div id='petTypeError' class='text-danger d-none'>Pet Type is required.</div>
                            </div>
                            <div class='col-md-6 form-group'>
                                <label for='petBreed' class='form-label'>Breed</label>
                                <input type='text' class='form-control' id='petBreed' name='petBreed' required>
                                <div id='petBreedError' class='text-danger d-none'>Breed is required.</div>
                            </div>
                            <div class='col-md-6 form-group'>
                                <label class='form-label'>Status</label>
                                <div class='form-check'>
                                    <input class='form-check-input' type='radio' name='status' id='lost' value='Lost'
                                        required>
                                    <label class='form-check-label' for='lost'>Lost</label>
                                </div>
                                <div class='form-check'>
                                    <input class='form-check-input' type='radio' name='status' id='found' value='Found'
                                        required>
                                    <label class='form-check-label' for='found'>Found</label>
                                </div>
                                <div id='statusError' class='text-danger d-none'>Please select a status.</div>
                            </div>
                            <div class='col-md-6 form-group'>
                                <label for='info' class='form-label'>information (status)</label>
                                <textarea class='form-control' id='info' name='info'></textarea>
                                <div id='infoError' class='text-danger d-none'>Additional Information is required.</div>
                            </div>
                            <div class='col-md-6 form-group'>
                                <label for='petImage' class='form-label'>Pet Image</label>
                                <input type='file' class='form-control' id='petImage' name='petImage' accept='image/*'
                                    required>
                                <div id='petImageError' class='text-danger d-none'>Please upload an image.</div>
                            </div>
                            <div class='col-md-12 form-group text-center'>
                                <button type='button' id='submitForm' class='btn btn-primary btn-submit'>Submit</button>
                            </div>
                        </div>
                    </form>
                    <div id='submitFeedback' class='alert d-none mt-3'></div>
                </div>
            </div>
        </div>
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

        fetch('missing-process.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                const feedback = document.getElementById('submitFeedback');
                feedback.classList.remove('d-none', 'alert-success', 'alert-danger');
                feedback.classList.add(data.status === 'success' ? 'alert-success' : 'alert-danger');
                feedback.textContent = data.message;

                if (data.status === 'success') {
                    // Close the form modal
                    const reportPetModal = bootstrap.Modal.getInstance(document.getElementById('reportPetModal'));
                    reportPetModal.hide();

                    // Show success modal
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();

                    // Reset the form
                    form.reset();

                    // Redirect after 3 seconds
                    setTimeout(() => {
                        window.location.href = 'missing_pet.php'; // Change to your desired page
                    }, 3000);
                }

                setTimeout(() => {
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
            const petName = document.getElementById('petName').value.trim();
            const petType = document.getElementById('petType').value.trim();
            const petBreed = document.getElementById('petBreed').value.trim();
            const info = document.getElementById('info').value.trim();
            const petImage = document.getElementById('petImage').files[0];

            // Status radio buttons
            const statusLost = document.getElementById('lost');
            const statusFound = document.getElementById('found');
            const statusError = document.getElementById('statusError');

            // If neither "Lost" nor "Found" is selected, show error
            if (!statusLost.checked && !statusFound.checked) {
                statusError.classList.remove('d-none');
                isValid = false;
            } else {
                statusError.classList.add('d-none');
            }

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

            const petNameError = document.getElementById('petNameError');
            if (!petName) {
                petNameError.classList.remove('d-none');
                isValid = false;
            } else {
                petNameError.classList.add('d-none');
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

        // Add event listeners to remove error messages when a radio button is selected
        document.querySelectorAll('input[name="status"]').forEach((radio) => {
            radio.addEventListener('change', () => {
                document.getElementById('statusError').classList.add('d-none');
            });
        });

    </script>
</body>
</html>
