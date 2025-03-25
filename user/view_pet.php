<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Adoption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4 text-center">Pet Adoption Listings</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Image</th>
                        <th>Pet Name</th>
                        <th>Age</th>
                        <th>Breed</th>
                        <th>Owner</th>
                        <th>Email</th>
                        <th>Info</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM pets";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $imageSrc = !empty($row['pet_image']) ? 'data:image/jpeg;base64,' . htmlspecialchars($row['pet_image']) : 'default.jpg';
                    ?>
                    <tr>
                        <td><img src="<?php echo $imageSrc; ?>" class="img-thumbnail" width="80" alt="Pet Image"></td>
                        <td><?php echo htmlspecialchars($row['pet_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['pet_age']); ?></td>
                        <td><?php echo htmlspecialchars($row['pet_breed']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['pet_info']); ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#petModal"
                                data-id="<?php echo $row['id']; ?>"
                                data-pet="<?php echo htmlspecialchars($row['pet_name']); ?>"
                                data-age="<?php echo htmlspecialchars($row['pet_age']); ?>"
                                data-breed="<?php echo htmlspecialchars($row['pet_breed']); ?>"
                                data-info="<?php echo htmlspecialchars($row['pet_info']); ?>"
                                data-owner="<?php echo htmlspecialchars($row['name']); ?>"
                                data-mail="<?php echo htmlspecialchars($row['email']); ?>"
                                data-image="<?php echo $imageSrc; ?>">
                                View Details
                            </button>
                        </td>
                    </tr>
                    <?php }} else { echo '<tr><td colspan="8" class="text-center">No adoption listing available.</td></tr>'; } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pet Modal -->
    <div class="modal fade" id="petModal" tabindex="-1" aria-labelledby="petModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="petModalLabel">🐾 Pet Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-5 text-center">
                            <img id="modalPetImage" src="" alt="Pet Image" class="img-fluid rounded shadow-sm">
                        </div>
                        <div class="col-md-7">
                            <h3 id="modalPetName" class="text-primary"></h3>
                            <p><strong>Owner:</strong> <span id="modalOwner"></span></p>
                            <p><strong>Email:</strong> <span id="modalMail"></span></p>
                            <p><strong>Age:</strong> <span id="modalPetAge"></span></p>
                            <p><strong>Breed:</strong> <span id="modalPetBreed"></span></p>
                            <p><strong>Info:</strong> <span id="modalPetInfo"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success">🐶 Adopt This Pet</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var petModal = document.getElementById('petModal');
            petModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                document.getElementById('modalPetImage').src = button.getAttribute('data-image');
                document.getElementById('modalPetName').textContent = button.getAttribute('data-pet');
                document.getElementById('modalOwner').textContent = button.getAttribute('data-owner');
                document.getElementById('modalMail').textContent = button.getAttribute('data-mail');
                document.getElementById('modalPetAge').textContent = button.getAttribute('data-age');
                document.getElementById('modalPetBreed').textContent = button.getAttribute('data-breed');
                document.getElementById('modalPetInfo').textContent = button.getAttribute('data-info');
            });
        });
    </script>
</body>
</html>
