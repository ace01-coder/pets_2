
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pet Profile</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100">
        <div class="min-h-screen flex items-center justify-center">
            <div class="bg-white shadow-md rounded-lg max-w-md w-full p-6">
                <div class="flex flex-col items-center">
                    <!-- Pet Image -->
                    <img src="<?php echo htmlspecialchars($petImage); ?>" 
                         alt="Pet Image" 
                         class="w-32 h-32 rounded-full mb-4 border-2 border-gray-300">

                    <!-- Pet Name -->
                    <h1 class="text-2xl font-bold mb-2"><?php echo htmlspecialchars($pet['pet']); ?></h1>

                    <!-- Owner Details -->
                    <p class="text-gray-600 mb-4">
                        Owner: <?php echo htmlspecialchars($pet['owner']); ?>
                    </p>

                    <!-- Contact Details -->
                    <p class="text-gray-600 mb-4">
                        Contact: <?php echo htmlspecialchars($pet['phone']); ?>
                    </p>

                    <!-- Emergency Contact -->
                    <p class="text-gray-600 mb-4">
                        In case of emergency, notify the owner via 
                        <a href="mailto:<?php echo urlencode($pet['email']); ?>" class="text-blue-600 hover:underline">
                            email
                        </a>.
                    </p>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
//} else {
  //  echo "<div class='text-center'><h1 class='text-red-600 font-bold text-lg'>Pet not found!</h1></div>";
//}

//$stmt->close();
//$conn->close();
?>
