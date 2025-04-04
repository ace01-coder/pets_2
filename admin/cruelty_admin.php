<?php
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('admin'); 

?>
    <!DOCTYPE html>
    <html lang='en'>
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
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .filter-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background-color: #fff;
        border-bottom: 2px solid #ddd;
        }
        .table-wrapper {
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
    <body class='vertical light'>
    <div class='wrapper'>
        <?php include('./disc/partial/navbar.php'); ?>
        <?php include('./disc/partial/sidebar.php'); ?>
        <main class='main-content'>
        <div class="container-fluid mt-4">
        <div class="container-fluid mt-4">
        <div class="card shadow">
            <!-- Updated Header: White text with blue background -->
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                <h4 class="mb-0 text-white">Report Management</h4> <!-- Ensure text remains white -->
                <div class="d-flex">
                    <div class="input-group me-2">
                        <span class="input-group-text"><i class="fa-solid fa-search"></i></span>
                        <input type="text" id="search-bar" class="form-control" placeholder="Search by Pet Name, Email..." onkeyup="filterTable()">
                    </div>

                    <select id="category-filter" class="form-select me-2" onchange="filterTable()">
                        <option value="">Select Category</option>
                        <option value="owner">Owner</option>
                        <option value="email">Email</option>
                        <option value="breed">Pet Breed</option>
                        <option value="info">Information</option>
                        <option value="date">Date</option>
                    </select>

                    <input type="date" id="date-filter" class="form-control" onchange="filterTable()" style="display: none;">
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="pet-table">
                        <!-- Updated Table Header: Background set to primary blue -->
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Pet</th>
                                <th>Age</th>
                                <th>Breed</th>
                                <th>Information</th>
                                <th>Pet Image</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                    <tbody>
                        <?php
                
$sql = "SELECT * FROM report";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $index = 1;
    while ($row = $result->fetch_assoc()) {
        // Check if pet_image exists and is valid
        $petImage = (!empty($row['pet_image']))
            ? 'data:image/jpeg;base64,' . $row['pet_image']  // Ensure correct format
            : 'default.jpg'; // Use default if no image is found

        echo "<tr>
                <td>{$index}</td>
                <td>{$row['reportParty']}</td>
                <td>{$row['phone_number']}</td>
                <td>{$row['email']}</td>
                <td>{$row['address']}</td>
                <td>{$row['pet_type']}</td>
                <td>{$row['pet_breed']}</td>
                <td>{$row['additional_info']}</td>
                <td>
                    <a href='{$petImage}' target='_blank'>
                        <img src='{$petImage}' alt='Pet Image' width='50' height='50' style='border-radius: 5px;'>
                    </a>
                </td>
                <td>{$row['created_at']}</td>
              </tr>";

        $index++;
    }
} else {
    echo '<tr><td colspan="10">No records found.</td></tr>';
}

$conn->close();
?>

</tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>


        </main>
    </div>

    <!-- Modal -->
    <div id="viewModal" class="modal fade" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Pet Details</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body" id="modal-details">
            <!-- Content will be dynamically added -->
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>

    <?php include('./disc/partial/script.php'); ?>
    </body>
    </html>
