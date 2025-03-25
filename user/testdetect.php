<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Recognition</title>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.0.0/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class="relative bg-gray-100 font-sans">

    <!-- Background with Overlay -->
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('backone.jpg'); z-index: -1;">
        <div class="absolute inset-0 bg-black opacity-50"></div> 
    </div>

    <div class="relative flex justify-center items-center min-h-screen px-4 flex-col sm:flex-row space-y-6 sm:space-y-0 sm:space-x-6">

        <!-- Pet Scanner Box -->
        <div class="bg-[#DFA16A] p-6 rounded-lg shadow-lg shadow-white w-full sm:w-[350px] flex flex-col relative z-10">
            <h1 class="text-lg font-bold text-center text-white mb-4 flex items-center justify-center">
                <i class="fas fa-camera-retro mr-2"></i> Pet Scanner
            </h1>

            <!-- Camera Feed Section -->
            <div class="mb-4 p-3 rounded-md shadow-md relative">
                <video id="video" width="350" height="400" autoplay class="border rounded-md shadow-md mx-auto"></video>
                <canvas id="canvas" class="hidden"></canvas>
            </div>

            <!-- Capture and Switch Camera Buttons -->
            <div class="flex justify-center space-x-4">
                <button onclick="captureImage()"
                    class="w-1/3 text-sm bg-red-500 text-white py-2 rounded-md hover:bg-red-600 transition duration-200 flex items-center justify-center">
                    <i class="fas fa-camera mr-1"></i> Capture
                </button>

                <button onclick="switchCamera()"
                    class="w-1/3 text-sm bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition duration-200 flex items-center justify-center">
                    <i class="fas fa-sync-alt mr-1"></i> Switch
                </button>
            </div>
        </div>

    </div>

<!-- Modal -->
<div id="resultModal" class="fixed inset-0 flex items-center justify-center hidden z-50 bg-black bg-opacity-50">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl w-full relative">
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">
            <i class="fas fa-times"></i>
        </button>
        <h2 class="text-xl font-bold text-center text-gray-800 mb-6">Pet Information</h2>
        <div class="flex flex-col md:flex-row items-center md:space-x-6">
            <img id="capturedImg" src="" alt="Captured Image" class="w-full md:w-1/2 h-64 object-cover rounded-md shadow-md border">
            <p id="cameraPetInfo" class="text-center md:text-left text-lg text-gray-700 mt-4 md:mt-0 w-full md:w-1/2"></p>
        </div>
    </div>
</div>

    <!-- Footer -->
    <footer class="absolute bottom-4 w-full text-center text-white text-sm z-10">
        © 2025 Pet Recognition. All Rights Reserved.
    </footer>

    <script>
        let model;
        let useBackCamera = false;
        const video = document.getElementById("video");
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");
        const modal = document.getElementById("resultModal");

        async function loadModel() {
            model = await mobilenet.load();
            console.log("Model loaded successfully!");
        }

        async function setupCamera() {
            try {
                const constraints = {
                    video: {
                        width: 350,
                        height: 400,
                        facingMode: useBackCamera ? "environment" : "user"
                    }
                };
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                video.srcObject = stream;
            } catch (error) {
                console.error("Error accessing the camera: ", error);
                alert("Could not access the camera. Please check your permissions.");
            }
        }

        function switchCamera() {
            useBackCamera = !useBackCamera;
            setupCamera();
        }

        function captureImage() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            const imageDataUrl = canvas.toDataURL("image/png");
            document.getElementById('capturedImg').src = imageDataUrl;
            
            classifyCapturedImage();
        }

        async function classifyCapturedImage() {
            if (!model) {
                alert("Model is still loading. Please wait.");
                return;
            }

            const imageTensor = tf.browser.fromPixels(canvas);
            const predictions = await model.classify(imageTensor);
            imageTensor.dispose();

            const petName = predictions[0].className;
            document.getElementById('cameraPetInfo').innerText = `Prediction: ${petName} (${Math.round(predictions[0].probability * 100)}% confidence)`;
            fetchGeminiDescription(petName);
            modal.classList.remove("hidden");
        }

        async function fetchGeminiDescription(petName) {
            const apiKey = "YOUR_GEMINI_API_KEY";
            const url = "https://api.openai.com/v1/chat/completions";

            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${apiKey}`,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    model: "gpt-4-turbo",
                    messages: [{ role: "user", content: `Tell me about a pet called ${petName}` }]
                })
            });

            const data = await response.json();
            const description = data.choices?.[0]?.message?.content || "No additional information available.";
            document.getElementById('cameraPetInfo').innerText += `\n\n${description}`;
        }

        function closeModal() {
            modal.classList.add("hidden");
        }

        loadModel();
        setupCamera();
    </script>
</body>
</html>