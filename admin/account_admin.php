<?php
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('admin'); 

?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <?php include('./disc/partial/header.php');
    ?>
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

        th,
        td {
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
        <?php include('./disc/partial/navbar.php');
        ?>
        <?php include('./disc/partial/sidebar.php');
        ?>
        <main class='main-content'>
            <div class='container-fluid mt-4'>
                <div class='container-fluid mt-4'>
                    <div class='card shadow'>

                        <div
                            class='card-header d-flex justify-content-between align-items-center bg-primary text-white'>
                            <h4 class='mb-0 text-white'>User Management</h4>
                            <div class='d-flex'>
                                <div class='input-group me-2'>
                                    <span class='input-group-text'><i class='fa-solid fa-search'></i></span>
                                    <input type='text' id='search-bar' class='form-control'
                                        placeholder='Search by Pet Name, Email...' onkeyup='filterTable()'>
                                </div>

                                <select id='category-filter' class='form-select me-2' onchange='filterTable()'>
                                    <option value=''>Select Category</option>
                                    <option value='owner'>Owner</option>
                                    <option value='email'>Email</option>
                                    <option value='breed'>Pet Breed</option>
                                    <option value='info'>Information</option>
                                    <option value='date'>Date</option>
                                </select>

                                <input type='date' id='date-filter' class='form-control' onchange='filterTable()'
                                    style='display: none;'>
                            </div>
                        </div>

                        <div class='card-body'>
                            <div class='table-responsive'>
                                <table class='table table-hover table-bordered' id='pet-table'>

                                    <thead class='table-light'>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch user data from the database
                                     
                                        $sql = 'SELECT id, username, email, role FROM users';
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $roleBadge = $row['role'] == 'admin' ? 'badge bg-warning text-dark' : 'badge bg-primary';
                                                echo '<tr>';
                                                echo '<td>' . $row['id'] . '</td>';
                                                echo '<td>' . $row['username'] . '</td>';
                                                echo '<td>' . $row['email'] . '</td>';
                                                echo "<td><span class='$roleBadge'>" . ucfirst($row['role']) . '</span></td>';
                                                echo "<td>
                          <a href='#' onclick=\"openUpdateModal( '{$row['id']}', '{$row['username']}', '{$row['email']}', '{$row['role']}' )\" class='btn btn-sm btn-outline-primary'>Edit</a>
                          <a href='#' onclick=\"openDeleteModal( '{$row['id']}' )\" class='btn btn-sm btn-outline-danger'>Delete</a>
                        </td>";
                                                echo '</tr>';
                                            }
                                        } else {
                                            echo "<tr><td colspan='5' class='text-center'>No users found</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

        </main>
    </div>

  

    <?php include('./disc/partial/script.php');
    ?>
</body>

</html>