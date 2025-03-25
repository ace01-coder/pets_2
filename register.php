<?php
session_start();
include('config.php');

// Initialize error array
$error = [];

if (isset($_POST['createAccount'])) {
    // Sanitize and validate user inputs
    $username = htmlspecialchars(trim($_POST['username']));
    $email = htmlspecialchars(trim($_POST['email']));
    $role = 'user'; // Set role as "user" by default
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = "Please enter a valid email address.";
    }

    // Check if username or email already exists
    if (empty($error)) {
        $checkStmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $checkStmt->bind_param("ss", $username, $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $error[] = "Username or email already exists.";
        } else {
            // Prepare and execute insert statement
            $stmt = $conn->prepare("INSERT INTO users (username, email, pwd, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $password, $role);
            
            if ($stmt->execute()) {
                echo "<script>
                    alert('Account created successfully');
                    window.location.href = 'index.php';
                    </script>";
            } else {
                $error[] = "Error creating account. Please try again later.";
            }
            
            $stmt->close();
        }
        $checkStmt->close();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
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
    <div class="login-card p-8 rounded-lg w-full max-w-md relative z-10">
        <div class="flex justify-center mb-4">
            <img src="admin/img/barangay.png" alt="Government Logo" class="h-20 w-auto">
        </div>
        <h2 class="text-center text-2xl font-semibold text-gray-700 mb-6">Sign up</h2>

        <?php if (!empty($error)) : ?>
            <div class="bg-red-600 text-white text-center py-2 mb-4 rounded">
                <?php foreach ($error as $err) : ?>
                    <?php echo htmlspecialchars($err) . '<br>'; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="mb-4">
                <label class="block text-gray-700" for="createUsername">Username</label>
                <input class="border rounded-lg w-full p-2" type="text" id="createUsername" name="username" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-gray-700" for="createEmail">Email</label>
                <input class="border rounded-lg w-full p-2" type="email" id="createEmail" name="email" required>
            </div>

            <!-- Role (Hidden) -->
            <input type="hidden" name="role" value="user">

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-gray-700" for="createPassword">Password</label>
                <input class="border rounded-lg w-full p-2" type="password" id="createPassword" name="password" required>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center">
                <button type="submit" name="createAccount" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition duration-200 w-full">Sign up</button>
            </div>
            <a class="flex justify-center mt-4 text-blue-600 hover:underline" href="index.php">Have an account? Login</a>
        </form>
    </div>

    <!-- Footer -->
    <footer class="text-gray-500 text-sm mt-4 text-center absolute bottom-4">
        &copy; <?php echo date("Y"); ?> Barangay Pet Animal Welfare Protection System. All Rights Reserved.
    </footer>

    <script>
        // Reset the form on load
        window.onload = function() {
            document.querySelector('form').reset();
        };
    </script>
</body>
</html>