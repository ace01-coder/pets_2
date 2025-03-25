<?php
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('user'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('./disc/partials/header.php'); ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body { background-color: #f8f9fa; }
    .wrapper { display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px; }
    .card-header { background-color: #007bff; color: #fff; }
  </style>
</head>
<body>

<div class="wrapper">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="card shadow-sm">
          <div class="card-header text-center">
            <h4 class="mb-0">Adoption Form</h4>
          </div>
          <div class="card-body">
            <form id="adoptForm">
              <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <div class="text-danger d-none small" id="nameError">Invalid name.</div>
              </div>

              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="text-danger d-none small" id="emailError">Invalid email.</div>
              </div>

              <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
                <div class="text-danger d-none small" id="phoneError">Invalid phone number.</div>
              </div>

              <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
              </div>

              <div class="mb-3">
                <label class="form-label">Occupation</label>
                <input type="text" class="form-control" id="occupation" name="occupation" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Home Type</label>
                <select class="form-select" id="homeType" name="homeType" required>
                  <option value="">Select Home Type</option>
                  <option value="apartment">Apartment</option>
                  <option value="house">House</option>
                  <option value="condo">Condominium</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Reason for Adoption</label>
                <textarea class="form-control" id="adoptReason" name="adoptReason" rows="3" required></textarea>
              </div>

              <div class="mb-3">
                <label class="form-label">Pet Experience</label>
                <select class="form-select" id="petExperience" name="petExperience" required>
                  <option value="">Select Experience</option>
                  <option value="none">No Experience</option>
                  <option value="some">Some Experience</option>
                  <option value="extensive">Extensive Experience</option>
                </select>
              </div>

              <div class="text-center">
                <button type="button" id="submitForm" class="btn btn-primary">Submit</button>
              </div>
            </form>

            <div id="submitFeedback" class="alert d-none mt-3"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('submitForm').addEventListener('click', function () {
    let formData = new FormData(document.getElementById('adoptForm'));

    fetch('send_email.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        let feedback = document.getElementById('submitFeedback');
        feedback.classList.remove('d-none');
        feedback.classList.add(data.status === 'success' ? 'alert-success' : 'alert-danger');
        feedback.textContent = data.status === 'success' ? 'Successfully Submitted!' : 'Submission Failed!';
    });
});
</script>

</body>
</html>
