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
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            text-align: center;
            padding: 10px;
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: contain;
            background: #f8f9fa;
        }

        .card-title {
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>

<body class="vertical light">
    <div class="wrapper">
        <?php include('./disc/partials/navbar.php'); ?>
        <?php include('./disc/partials/sidebar.php'); ?>
        <main role="main" class="main-content">

    <div class="container-fluid">
        <?php if (isset($message)): ?>
            <div class="alert alert-success text-center fw-bold" role="alert">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger text-center fw-bold" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <h2 class="mb-4 text-center fw-bold text-primary">Adoptable Pets</h2>

        <div class="row ">
            <?php
            $sql = "SELECT * FROM adoption WHERE approved = 1 ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card shadow-sm border-0" data-bs-toggle="modal" data-bs-target="#adoptModal"
                            data-pet-id="<?php echo $row['pet_id']; ?>"
                            data-pet-name="<?php echo htmlspecialchars($row['pet_name']); ?>"
                            data-pet-breed="<?php echo htmlspecialchars($row['pet_breed']); ?>"
                            data-pet-info="<?php echo htmlspecialchars($row['pet_info']); ?>"
                            data-pet-image="<?php echo htmlspecialchars($row['pet_image']); ?>"
                            data-owner-email="<?php echo htmlspecialchars($row['mail']); ?>">
                            <img src="<?php echo htmlspecialchars($row['pet_image']); ?>" class="card-img-top rounded-top"
                                alt="Pet Image">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?php echo htmlspecialchars($row['pet_name']); ?></h5>

                                <button class="btn btn-sm btn-outline-primary mt-2">View Details</button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<div class='col-12 text-center'><p class='text-danger fw-bold'>No adoption listings available.</p></div>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</main>


        <div class="modal fade" id="adoptModal" tabindex="-1" aria-labelledby="adoptModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="adoptModalLabel">Adoption Application</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-5">
                                <img id="modal-pet-image" src="" alt="Pet Image" class="img-fluid rounded">
                            </div>
                            <div class="col-md-7">
                                <h5 id="modal-pet-name"></h5>
                                <!--<p><strong>Type:</strong> <span id="modal-pet-type"></span></p>-->
                                <p><strong>Breed:</strong> <span id="modal-pet-breed"></span></p>
                                <p><strong>Information:</strong> <span id="modal-pet-info"></span></p>
                            </div>
                        </div>
                        <div class="row">
                        <div class="table-responsive mt-4"> <!-- Added margin-top -->
    <table class="table table-striped table-bordered table-hover table-sm">
        <thead class="table-primary text-center">
            <tr>
                <th>Vaccine Type</th>
                <th>Vaccine Product</th>
                <th>Vaccine Date</th>
                <th>Administered By</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <tr>
                <td>Rabies</td>
                <td>Rabisin</td>
                <td>2024-03-10</td>
                <td>Dr. Smith</td>
            </tr>
            <tr>
                <td>Deworming</td>
                <td>Drontal</td>
                <td>2024-02-15</td>
                <td>Dr. Jones</td>
            </tr>
            <tr>
                <td>Parvovirus</td>
                <td>Vanguard Plus</td>
                <td>2024-01-20</td>
                <td>Dr. Wilson</td>
            </tr>
        </tbody>
    </table>
</div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('./script.php'); ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.getElementById('adoptModal').addEventListener('show.bs.modal', function (event) {
                var card = event.relatedTarget;

                var petName = card.getAttribute('data-pet-name');
                var petType = card.getAttribute('data-pet-type'); 
                var petBreed = card.getAttribute('data-pet-breed');  // Fixed pet type issue
                var petInfo = card.getAttribute('data-pet-info');
                var petImage = card.getAttribute('data-pet-image');

                document.getElementById('modal-pet-name').textContent = petName;
                document.getElementById('modal-pet-breed').textContent = petType;
                document.getElementById('modal-pet-breed').textContent = petBreed;
                document.getElementById('modal-pet-info').textContent = petInfo;
                document.getElementById('modal-pet-image').src = petImage;
            });
        </script>
    </div>
</body>

</html>