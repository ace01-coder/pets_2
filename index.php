<?php
session_start();
include('config.php');
include('authentication.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $error = array(); // Initialize error array
    
    // Validate email/username and password fields
    if (empty($_POST['umail'])) {
        $error['umail'] = 'Please enter your email or username.';
    } else { 
        $umail = htmlspecialchars(trim($_POST['umail']));
    }

    if (empty($_POST['password'])) {
        $error['password'] = 'Please enter your password.';
    } else {
        $password = htmlspecialchars(trim($_POST['password']));
    }

    // If no errors, proceed to account check
    if (empty($error)) {
        // Check if the account exists
        $stmt = $conn->prepare('SELECT id, username, pwd, role FROM users WHERE username=? OR email=?');
        $stmt->bind_param('ss', $umail, $umail);
        $stmt->execute();
        $stmt->store_result();

        // If no account is found
        if ($stmt->num_rows === 0) {
            $error['account'] = 'Account not found.';
        } else {
            // If account is found, fetch user details
            $stmt->bind_result($id, $username, $hpassword, $role);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hpassword)) {
                // Prevent session fixation
                session_regenerate_id(true);

                // Set session variables for authentication
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['logged_in'] = true;

                // Redirect based on role
                if ($role === 'admin') {
                    header("Location: admin/dashboard_admin.php");
                } elseif ($role === 'user') {
                    header("Location: user/dashboard.php");
                } else {
                    $error['role'] = 'Invalid role. Please contact support.';
                }
                exit;
            } else {
                $error['password'] = 'Incorrect password. Please try again.';
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Pet Animal Welfare Protection</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="admin/img/barangay.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fb;
        }
        .background-img {
            background-image: url('admin/img/stray.png');
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .overlay {
            background-color: rgba(0, 47, 108, 0.7);
        }
        .login-card {
            background-color: #ffffff;
            border-left: 6px solid #002f6c;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center h-screen background-img relative">
    <div class="absolute inset-0 overlay"></div>
    <div class="login-card p-5 rounded-lg w-full max-w-md relative z-10 sm:w-11/12 md:w-9/12 lg:w-1/3">
        <div class="flex justify-center mb-4">
            <img src="admin/img/barangay.png" alt="Government Logo" class="h-20 w-auto">
        </div>
        <h2 class="text-center text-2xl font-semibold text-gray-700 mb-6">Login</h2>

        <?php if (!empty($error)) : ?>
            <div class="bg-red-600 text-white text-center py-2 mb-4 rounded">
                <?php 
                foreach ($error as $err) {
                    echo htmlspecialchars($err) . '<br>';
                }
                ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" id="loginForm">
            <div class="mb-4">
                <label for="umail" class="block text-sm font-semibold text-gray-700">Email/Username</label>
                <input type="text" name="umail" id="umail" class="mt-1 p-3 border border-gray-300 rounded w-full focus:outline-none focus:border-blue-600" value="<?php echo isset($_POST['umail']) ? htmlspecialchars($_POST['umail']) : ''; ?>" autocomplete="off">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="mt-1 p-3 border border-gray-300 rounded w-full focus:outline-none focus:border-blue-600" autocomplete="off">
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition duration-200 w-full">Login</button>
            </div>
        </form>
    <!--    <a class="flex justify-center mt-4 text-blue-600 hover:underline" href="register.php">Create an account. Sign up</a>
    -->
    </div>

    <!-- Copyright Footer -->
    <footer class="text-gray-500 text-sm mt-4 text-center absolute bottom-4">
        &copy; <?php echo date("Y"); ?> Barangay Pet Animal Welfare Protection System. All Rights Reserved.
    </footer>
</body>
</html>

