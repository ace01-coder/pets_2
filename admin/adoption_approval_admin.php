<?php
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('admin'); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('./disc/partial/header.php'); ?>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f9;
    }
    .main-content {
      padding: 20px;
      margin: 20px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .filter-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px;
      background-color: #fff;
      border-bottom: 2px solid #ddd;
    }
    .table-responsive {
      overflow-x: auto;
      max-height: 500px;
      border-radius: 5px;
      background: #fff;
      padding: 10px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 5px;
    }
    th, td {
      padding: 12px;
      text-align: center;
    }
    th {
      background: #333;
      color: white;
    }
    .modal-content {
      border-radius: 8px;
      padding: 20px;
    }
    .modal-body img {
      max-width: 100%;
      border-radius: 5px;
    }
  </style>
</head>
<body class="vertical light">
  <div class="wrapper">
    <?php include('./disc/partial/navbar.php'); ?>
    <?php include('./disc/partial/sidebar.php'); ?>
    <main class="main-content">
      <div class="box">
        <div class="filter-container d-flex justify-content-between align-items-center p-3 border-bottom">
          <h3 class="title">Adoption Management</h3>
        </div>
        <div class="table-responsive">
          <table class="table table-striped table-hover text-center" id="pet-table">
            <thead class="table-dark">
              <tr>
                <th>User Name</th>
                <th>View</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
          
              // Select only unapproved adoption records (pending)
              $sql = "SELECT * FROM adoption WHERE approved = 0";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  // Base64 encode pet image for display
                  $petImage = !empty($row['pet_image'])
                    ? 'data:image/jpeg;base64,' . base64_encode($row['pet_image'])
                    : 'default.jpg';
                  
                  // Also, encode pet_image for JSON if not empty
                  if (!empty($row['pet_image'])) {
                    $row['pet_image'] = base64_encode($row['pet_image']);
                  }
                  // Prepare JSON data for the modal
                  $jsonData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                  
                  // Use pet_id as data-id attribute (make sure your DB uses that column)
                  echo "<tr data-id='{$row['pet_id']}' data-info='{$jsonData}'>
                          <td>" . htmlspecialchars($row['username']) . "</td>
                          <td><button class='btn btn-info' onclick='viewDetails(this)'>View</button></td>
                          <td>
                            <form action='adoption-process.php' method='POST' class='d-inline'>
                              <input type='hidden' name='pet_id' value='{$row["pet_id"]}'>
                              <button type='submit' name='action' value='approve' class='btn btn-success'>Approve</button>
                            </form>
                            <!-- Reject button triggers a modal -->
                            <button type='button' class='btn btn-danger' onclick='openRejectModal(this)'>Reject</button>
                          </td>
                        </tr>";
                }
              } else {
                echo '<tr><td colspan="3">No records found.</td></tr>';
              }
              $conn->close();
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>

  <!-- Modal for Viewing Pet Details -->
  <div id="viewModal" class="modal fade" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pet Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modal-details">
          <!-- Pet details will be dynamically added here -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Rejecting Adoption -->
  <div id="rejectModal" class="modal fade" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title" id="rejectModalLabel">Enter Rejection Reason</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="rejectForm" action="adoption-process.php" method="POST">
            <input type="hidden" name="pet_id" id="rejectPetId" value="">
            <!-- Set action to reject -->
            <input type="hidden" name="action" value="reject">
            <div class="mb-3">
              <label for="remark" class="form-label">Reason for Rejection:</label>
              <textarea class="form-control" name="remark" id="remark" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-danger">Submit Rejection</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include('./disc/partial/script.php'); ?>
  <script>
    // Function to view pet details in modal
    function viewDetails(button) {
      var row = button.closest("tr");
      var recordStr = row.getAttribute("data-info");
      if (recordStr) {
        var data = JSON.parse(recordStr);
        var detailsHtml = `
          <p><strong>Pet Name:</strong> ${data.pet_name || 'N/A'}</p>
          <p><strong>Pet Age:</strong> ${data.pet_age || 'N/A'}</p>
          <p><strong>Pet Breed:</strong> ${data.pet_breed || 'N/A'}</p>
          <p><strong>Information:</strong> ${data.pet_info || 'N/A'}</p>
          <p><strong>User Name:</strong> ${data.owner || 'N/A'}</p>
          <p><strong>Email/Owner:</strong> ${data.email || 'N/A'}</p>
          <p><strong>Pet Image:</strong> 
            ${data.pet_image 
              ? `<br/><img src="data:image/jpeg;base64,${data.pet_image}" alt="Pet Image" class="img-fluid rounded">` 
              : 'N/A'}
          </p>
          <p><strong>Created At:</strong> ${data.created_at || 'N/A'}</p>
        `;
        document.getElementById("modal-details").innerHTML = detailsHtml;
        var viewModal = new bootstrap.Modal(document.getElementById("viewModal"));
        viewModal.show();
      }
    }

    // Function to open the Reject Modal and pass the pet id
    function openRejectModal(button) {
      var row = button.closest("tr");
      var petId = row.getAttribute("data-id");
      document.getElementById("rejectPetId").value = petId;
      var rejectModal = new bootstrap.Modal(document.getElementById("rejectModal"));
      rejectModal.show();
    }
  </script>
</body>
</html>
