<?php
include('./dbconn/config.php');
include('./dbconn/authentication.php');

$errorMessage = "";
$successMessage = "";

// Check if the form is submitted and required fields exist
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['petId'])) {
  // --- Sanitize and prepare pet information ---
  $petId = (int) $_POST['petId'];
  $petName = trim($_POST['petName']);
  $owner = trim($_POST['owner']);
  $petAge = (int) $_POST['petAge'];
  $petBreed = trim($_POST['petBreed']);
  $petInfo = trim($_POST['petInfo']);
  $mail = filter_var(trim($_POST['mail']), FILTER_SANITIZE_EMAIL);

  // Handle Pet Image Upload (check file upload or Base64 string provided)
  if (!empty($_FILES['petImage']['tmp_name'])) {
    $imageData = file_get_contents($_FILES['petImage']['tmp_name']);
    $petImage = base64_encode($imageData);
  } elseif (!empty($_POST['petImage'])) {
    $petImage = $_POST['petImage'];
  } else {
    $petImage = "";
  }

  // Handle Vaccine Image Upload (if applicable)
  if (!empty($_FILES['petVaccine']['tmp_name'])) {
    $vaccineData = file_get_contents($_FILES['petVaccine']['tmp_name']);
    $petVaccine = base64_encode($vaccineData);
  } elseif (!empty($_POST['petVaccine'])) {
    $petVaccine = $_POST['petVaccine'];
  } else {
    $petVaccine = "";
  }

  // Other vaccine details
  $vaccineType = isset($_POST['vaccineType']) ? trim($_POST['vaccineType']) : "";
  $vaccineName = isset($_POST['vaccineName']) ? trim($_POST['vaccineName']) : "";
  $vaccineDate = isset($_POST['vaccineDate']) ? trim($_POST['vaccineDate']) : "";
  $administeredBy = isset($_POST['administeredBy']) ? trim($_POST['administeredBy']) : "";

  // Check for duplicate adoption records for the given pet_id
  $checkQuery = "SELECT id FROM adoption WHERE pet_id = ?";
  if ($checkStmt = $conn->prepare($checkQuery)) {
    $checkStmt->bind_param("i", $petId);
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows > 0) {
      $errorMessage = "This adoption record already exists.";
    }
    $checkStmt->close();
  } else {
    $errorMessage = "Error preparing duplicate check: " . $conn->error;
  }

  // If no error, proceed with insertion
  if (empty($errorMessage)) {
    // Begin transaction
    $conn->begin_transaction();

    try {
      // --- Insert into the adoption table (pet information only) ---
      $queryAdoption = "INSERT INTO adoption 
        (pet_id, owner, pet_name, pet_age, pet_breed, pet_info, email, pet_image, approved) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)";

      if ($stmtAdoption = $conn->prepare($queryAdoption)) {
        $stmtAdoption->bind_param(
          "ississss",
          $petId,
          $owner,
          $petName,
          $petAge,
          $petBreed,
          $petInfo,
          $mail,
          $petImage
        );
        $stmtAdoption->execute();
        $stmtAdoption->close();
      } else {
        throw new Exception("Error preparing adoption statement: " . $conn->error);
      }

      // --- Insert into the vaccines table if any vaccine information is provided ---
      if (!empty($petVaccine) || !empty($vaccineType) || !empty($vaccineName) || !empty($vaccineDate) || !empty($administeredBy)) {
        $queryVaccine = "INSERT INTO vaccines 
          (pet_id, pet_vaccine, pet_vaccine, vaccine_name, vaccine_date, administered_by)
          VALUES (?, ?, ?, ?, ?, ?)";
        
        if ($stmtVaccine = $conn->prepare($queryVaccine)) {
          $stmtVaccine->bind_param(
            "isssss",
            $petId,
            $petVaccine,
            $vaccineType,
            $vaccineName,
            $vaccineDate,
            $administeredBy
          );
          $stmtVaccine->execute();
          $stmtVaccine->close();
        } else {
          throw new Exception("Error preparing vaccine statement: " . $conn->error);
        }
      }

      // Commit the transaction if all queries succeed
      $conn->commit();
      $successMessage = "Your adoption request and vaccine record have been submitted successfully and are pending approval.";
    } catch (Exception $e) {
      // Roll back the transaction if something fails
      $conn->rollback();
      $errorMessage = "Transaction failed: " . $e->getMessage();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('./disc/partials/header.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    /* Consolidated CSS */
    body { background-color: #f8f9fa; }
    .form-container {
      max-width: 800px;
      margin: auto;
      padding: 30px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .modal .table-responsive { max-height: 300px; overflow-y: auto; }
    .form-title { text-align: center; font-weight: bold; margin-bottom: 20px; }
    .form-group { margin-bottom: 15px; }
    .btn-submit { display: block; width: auto; padding: 12px 30px; border-radius: 5px; margin: 0 auto; }
    .form-group select.form-select { width: 100%; padding: 12px; border-radius: 5px; background-color: #fff; font-size: 16px; transition: border-color 0.3s ease-in-out; }
    .form-group select.form-select:focus { outline: none; }
    #vaccine_section { background: #f9f9f9; padding: 20px; border-radius: 10px; margin-top: 15px; border: 1px solid #ddd; }
    .vaccine_entry { background: #ffffff; padding: 15px; border-radius: 8px; margin-bottom: 10px; border: 1px solid #ddd; display: flex; flex-wrap: wrap; gap: 10px; }
    .vaccine_entry input { flex: 1; min-width: 180px; border-radius: 5px; padding: 8px; border: 1px solid #ced4da; }
    .vaccine_entry button { padding: 8px 12px; font-size: 14px; cursor: pointer; align-self: center; }
    #vaccine_entries { display: flex; flex-direction: column; gap: 10px; }
    @media (max-width: 768px) { .vaccine_entry { flex-direction: column; } }
  </style>
</head>
<body class="vertical light">
  <div class="loader-mask">
    <div class="loader"><div></div><div></div></div>
  </div>
  <div class="wrapper">
    <?php include('./disc/partials/navbar.php'); ?>
    <?php include('./disc/partials/sidebar.php'); ?>
    <main role="main" class="main-content">
      <div class="container-fluid">

      <h2 class="mb-4 text-center fw-bold text-primary">My pets</h2>
        <div class="row g-3">
          <?php
          $sql = "SELECT * FROM pets";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              $imageSrc = !empty($row['pet_image'])
                ? 'data:image/jpeg;base64,' . htmlspecialchars($row['pet_image'])
                : 'default.jpg';
              $qrSrc = !empty($row['qr_code'])
                ? 'data:image/jpeg;base64,' . htmlspecialchars($row['qr_code'])
                : 'qr_code.jpg';
              ?>
              <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100" data-id="<?php echo $row['id']; ?>"
                  data-pet="<?php echo htmlspecialchars($row['pet_name']); ?>"
                  data-age="<?php echo htmlspecialchars($row['pet_age']); ?>"
                  data-breed="<?php echo htmlspecialchars($row['pet_breed']); ?>"
                  data-info="<?php echo htmlspecialchars($row['pet_info']); ?>"
                  data-owner="<?php echo htmlspecialchars($row['name']); ?>"
                  data-mail="<?php echo htmlspecialchars($row['email']); ?>"
                  data-image="<?php echo $imageSrc; ?>"
                  data-vaccine="<?php echo $vaccineSrc; ?>">
                  <img src="<?php echo $imageSrc; ?>" class="card-img-top" alt="Pet Image">
                  <div class="card-body text-center">
                    <p class="card-text fw-bold"><?php echo htmlspecialchars($row['pet_name']); ?></p>
                  </div>
                </div>
              </div>
              <?php
            }
          } else {
            echo '<div class="col-12"><p class="text-center">No adoption listing available.</p></div>';
          }
          ?>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal for Pet Details -->
  <div class="modal fade" id="petModal" tabindex="-1" aria-labelledby="petModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title fw-bold" id="petModalLabel">🐾 Pet Details</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3">
            <div class="col-12 col-md-6 text-center">
              <img id="modalPetImage" src="<?php echo $Src; ?>" alt="Pet Image" class="img-fluid rounded border"
                style="cursor:pointer;" onclick="openFullSize(this)">
            </div>
            <div class="col-12 col-md-6">
              <div class="row">
                <div class="col">
                  <h3 id="modalPetName" class="fw-bold text-primary"></h3>
                  <p><strong>Owner:</strong> <span id="modalOwner" class="text-secondary"></span></p>
                  <p><strong>Email:</strong> <span id="modalMail" class="text-secondary"></span></p>
                  <p><strong>Age:</strong> <span id="modalPetAge" class="text-secondary"></span></p>
                  <p><strong>Breed:</strong> <span id="modalPetBreed" class="text-secondary"></span></p>
                  <p><strong>Info:</strong> <span id="modalPetInfo" class="text-secondary"></span></p>
                </div>
                <div class="col">
                  <p><strong>QrCode</strong></p>
                  <img id="modalQRImage" src="<?php echo $qrSrc; ?>" alt="QR Code" style="max-width:128px;">
                </div>
              </div>
            </div>
          </div>
          <hr>
          <!-- Vaccine records table -->
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover table-sm">
              <thead class="table-primary text-center">
                <tr>
                  <th>Vaccine Type</th>
                  <th>Vaccine Product</th>
                  <th>Vaccine Date</th>
                  <th>Administered By</th>
                </tr>
              </thead>
              <tbody id="vaccineTableBody" class="text-center">
                <?php
                $vaccine_sql = "SELECT * FROM vaccines WHERE pet_id";
                $vaccine_result = $conn->query($vaccine_sql);
                if ($vaccine_result && $vaccine_result->num_rows > 0) {
                  while ($vaccine = $vaccine_result->fetch_assoc()) {
                    echo "<tr>";
                    // Display pet_vaccine instead of pet_vaccine for Vaccine Type
                    echo "<td>" . htmlspecialchars($vaccine['vaccine_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($vaccine['vaccine_name']) . "</td>";
                    echo "<td>" . htmlspecialchars($vaccine['vaccine_date']) . "</td>";
                    echo "<td>" . htmlspecialchars($vaccine['administered_by']) . "</td>";
                    echo "</tr>";
                  }
                } else {
                  echo "<tr><td colspan='4'>No vaccines recorded.</td></tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
          <div class="modal-footer d-flex justify-content-center">
            <form id="adoptForm" action="" method="post">
              <input type="hidden" name="petId" id="formPetId">
              <input type="hidden" name="owner" id="formOwner">
              <input type="hidden" name="petName" id="formPetName">
              <input type="hidden" name="petAge" id="formPetAge">
              <input type="hidden" name="petBreed" id="formPetBreed">
              <input type="hidden" name="petInfo" id="formPetInfo">
              <input type="hidden" name="mail" id="formMail">
              <input type="hidden" name="petImage" id="formPetImage">
              <!-- Hidden fields for vaccine info -->
              <input type="hidden" name="petVaccine" id="formPetVaccine">
              <input type="hidden" name="vaccineType" id="formVaccineType">
              <input type="hidden" name="vaccineName" id="formVaccineName">
              <input type="hidden" name="vaccineDate" id="formVaccineDate">
              <input type="hidden" name="administeredBy" id="formAdministeredBy">
              <div class="d-flex justify-content-center gap-3">
                <button type="submit" class="btn btn-success fw-bold px-4 py-2 m-2">🐶 Adopt This Pet</button>
                <button type="button" class="btn btn-warning fw-bold px-4 py-2 m-2" id="updateVaccineBtn">🩺 Update Vaccine</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Update Vaccine Modal -->
  <div class="modal fade" id="updateVaccineModal" tabindex="-1" aria-labelledby="updateVaccineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title fw-bold" id="updateVaccineModalLabel">🩺 Update Vaccine Record</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="vaccineForm" action="update_vaccine.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="petId" id="updatePetId">
            <div class="mb-3">
              <label for="vaccineType" class="form-label">Vaccine Type</label>
              <input type="text" class="form-control" name="vaccineType" id="vaccineType" required>
            </div>
            <div class="mb-3">
              <label for="vaccineName" class="form-label">Vaccine Product</label>
              <input type="text" class="form-control" name="vaccineName" id="vaccineName" required>
            </div>
            <div class="mb-3">
              <label for="vaccineDate" class="form-label">Vaccine Date</label>
              <input type="date" class="form-control" name="vaccineDate" id="vaccineDate" required>
            </div>
            <div class="mb-3">
              <label for="administeredBy" class="form-label">Administered By</label>
              <input type="text" class="form-control" name="administeredBy" id="administeredBy" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit Vaccine Record</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Update Success Modal -->
  <div class="modal fade" id="updateSuccessModal" tabindex="-1" aria-labelledby="updateSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content border-0 shadow-sm">
        <div class="modal-header bg-success text-white p-2">
          <h6 class="modal-title fw-bold w-100" id="updateSuccessModalLabel">
            <i class="bi bi-check-circle-fill me-1"></i> Update Successful
          </h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body text-center">
          <p class="text-dark fw-semibold mb-2">Vaccine record updated successfully!</p>
        </div>
        <div class="modal-footer d-flex justify-content-center border-0">
          <button type="button" class="btn btn-sm btn-success" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Error Modal -->
  <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content border-0 shadow-sm">
        <div class="modal-header bg-white p-2">
          <h6 class="modal-title text-white fw-bold w-100"><i class="bi bi-exclamation-triangle-fill me-1"></i></h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body text-center">
          <p class="text-dark fw-semibold mb-2"><?php echo htmlspecialchars($errorMessage); ?></p>
        </div>
        <div class="modal-footer d-flex justify-content-center border-0">
          <button type="button" class="btn btn-sm btn-success" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Success Modal -->
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content border-0 shadow-sm">
        <div class="modal-header bg-white p-2">
          <h6 class="modal-title text-white fw-bold w-100"><i class="bi bi-check-circle-fill me-1"></i></h6>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
        </div>
        <div class="modal-body text-center">
          <p class="text-dark fw-semibold mb-2"><?php echo htmlspecialchars($successMessage); ?></p>
        </div>
        <div class="modal-footer d-flex justify-content-center border-0">
          <button type="button" class="btn btn-sm btn-success" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

  <?php include('script.php'); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Initialize modals
      var petModalEl = document.getElementById('petModal');
      var updateVaccineModalEl = document.getElementById('updateVaccineModal');
      var updateSuccessModalEl = document.getElementById('updateSuccessModal');
      var errorModalEl = document.getElementById('errorModal');
      var successModalEl = document.getElementById('successModal');

      var petModal = new bootstrap.Modal(petModalEl);
      var updateVaccineModal = new bootstrap.Modal(updateVaccineModalEl);
      var updateSuccessModal = new bootstrap.Modal(updateSuccessModalEl);
      var errorModal = new bootstrap.Modal(errorModalEl);
      var successModal = new bootstrap.Modal(successModalEl);

      // Open pet modal when a card is clicked
      document.querySelectorAll('.card').forEach(function (card) {
        card.addEventListener('click', function () {
          var petId = card.getAttribute('data-id');
          var owner = card.getAttribute('data-owner');
          var petName = card.getAttribute('data-pet');
          var petAge = card.getAttribute('data-age');
          var petBreed = card.getAttribute('data-breed');
          var petInfo = card.getAttribute('data-info');
          var mail = card.getAttribute('data-mail');
          var petImage = card.getAttribute('data-image');

          document.getElementById('modalPetImage').src = petImage;
          document.getElementById('modalOwner').textContent = owner;
          document.getElementById('modalPetName').textContent = petName;
          document.getElementById('modalPetAge').textContent = petAge;
          document.getElementById('modalPetBreed').textContent = petBreed;
          document.getElementById('modalPetInfo').textContent = petInfo;
          document.getElementById('modalMail').textContent = mail;

          document.getElementById('formPetId').value = petId;
          document.getElementById('formOwner').value = owner;
          document.getElementById('formPetName').value = petName;
          document.getElementById('formPetAge').value = petAge;
          document.getElementById('formPetBreed').value = petBreed;
          document.getElementById('formPetInfo').value = petInfo;
          document.getElementById('formMail').value = mail;
          document.getElementById('formPetImage').value = petImage;

          petModal.show();
        });
      });

      // When clicking the Update Vaccine button inside the pet modal
      document.getElementById('updateVaccineBtn').addEventListener('click', function () {
        petModal.hide();
        var petId = document.getElementById('formPetId').value;
        document.getElementById('updatePetId').value = petId;
        updateVaccineModal.show();
      });

      // Intercept update vaccine form submission via AJAX
      var vaccineForm = document.getElementById('vaccineForm');
      vaccineForm.addEventListener('submit', function (event) {
        event.preventDefault();
        var formData = new FormData(vaccineForm);
        fetch("update_vaccine.php", {
          method: "POST",
          body: formData
        })
          .then(response => response.text())
          .then(data => {
            if (data.toLowerCase().indexOf("success") !== -1) {
              updateVaccineModal.hide();
              updateSuccessModal.show();
              updateSuccessModalEl.addEventListener('hidden.bs.modal', function () {
                petModal.show();
              }, { once: true });
            } else {
              alert("Error updating vaccine record. Please try again.");
            }
          })
          .catch(error => {
            console.error(error);
            alert("An error occurred. Please try again.");
          });
      });

      // Show error/success modals if PHP messages are set
      var phpErrorMsg = "<?php echo addslashes($errorMessage); ?>";
      var phpSuccessMsg = "<?php echo addslashes($successMessage); ?>";
      if (phpErrorMsg) { errorModal.show(); }
      if (phpSuccessMsg) { successModal.show(); }
    });

    // Function to load vaccine records and update both the table and hidden inputs
    function loadVaccineRecords(petId) {
      fetch('fetch_vaccine.php?pet_id=' + petId)
        .then(response => response.json())
        .then(data => {
          let tableBody = document.getElementById('vaccineTableBody');
          tableBody.innerHTML = ""; // Clear previous records
          if (data.length > 0) {
            data.forEach(vaccine => {
              let row = `<tr>
                <td>${vaccine.pet_vaccine || 'N/A'}</td>
                <td>${vaccine.vaccine_name || 'N/A'}</td>
                <td>${vaccine.vaccine_date || 'N/A'}</td>
                <td>${vaccine.administered_by || 'N/A'}</td>
              </tr>`;
              tableBody.innerHTML += row;
            });
            // Use the first record as default for the adoption submission
            document.getElementById('formVaccineType').value = data[0].pet_vaccine;
            document.getElementById('formVaccineName').value = data[0].vaccine_name;
            document.getElementById('formVaccineDate').value = data[0].vaccine_date;
            document.getElementById('formAdministeredBy').value = data[0].administered_by;
          } else {
            tableBody.innerHTML = `<tr><td colspan="4">No vaccines recorded.</td></tr>`;
          }
        })
        .catch(error => {
          console.error("Error fetching vaccine records:", error);
        });
    }

    // When a pet card is clicked, update both the pet info and load vaccine records
    document.querySelectorAll('.card').forEach(function (card) {
      card.addEventListener('click', function () {
        var petId = card.getAttribute('data-id');
        var owner = card.getAttribute('data-owner');
        var petName = card.getAttribute('data-pet');
        var petAge = card.getAttribute('data-age');
        var petBreed = card.getAttribute('data-breed');
        var petInfo = card.getAttribute('data-info');
        var mail = card.getAttribute('data-mail');
        var petImage = card.getAttribute('data-image');

        document.getElementById('modalPetImage').src = petImage;
        document.getElementById('modalOwner').textContent = owner;
        document.getElementById('modalPetName').textContent = petName;
        document.getElementById('modalPetAge').textContent = petAge;
        document.getElementById('modalPetBreed').textContent = petBreed;
        document.getElementById('modalPetInfo').textContent = petInfo;
        document.getElementById('modalMail').textContent = mail;

        document.getElementById('formPetId').value = petId;
        document.getElementById('formOwner').value = owner;
        document.getElementById('formPetName').value = petName;
        document.getElementById('formPetAge').value = petAge;
        document.getElementById('formPetBreed').value = petBreed;
        document.getElementById('formPetInfo').value = petInfo;
        document.getElementById('formMail').value = mail;
        document.getElementById('formPetImage').value = petImage;

        // Load vaccine records for the selected pet
        loadVaccineRecords(petId);

        var petModal = new bootstrap.Modal(document.getElementById('petModal'));
        petModal.show();
      });
    });
  </script>
</body>
</html>
