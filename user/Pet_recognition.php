<?php
include('dbconn/config.php');
include('dbconn/authentication.php');
checkAccess('user'); 
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <?php include('./disc/partials/header.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow/tfjs"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tensorflow-models/mobilenet"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>

<body class='vertical light'>
<div class='container-fluid'>
    <?php include('./disc/partials/navbar.php'); ?>
    <?php include('./disc/partials/sidebar.php'); ?>

    <main class='d-flex justify-content-center align-items-center min-vh-100'>
        <div class="container d-flex justify-content-center align-items-center px-3">
            <div class="card shadow-lg light text-black p-4 w-100" style="max-width: 30rem;">
                <h3 class="text-center mb-3"><i class="fas fa-camera-retro me-2"></i> Pet Scanner</h3>
                <div class="mb-3 text-center">
                    <video id="video" class="border rounded w-100" autoplay></video>
                    <canvas id="canvas" class="d-none"></canvas>
                </div>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <button onclick="captureImage()" class="btn btn-danger m-2"><i class="fas fa-camera me-1"></i> Capture</button>
                    <button onclick="switchCamera()" class="btn btn-success m-2"><i class="fas fa-sync-alt me-1"></i> Switch</button>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modal -->
<div id="resultModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pet Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body text-center">
                <img id="capturedImg" class="img-fluid rounded border mb-3" alt="Captured Image">
                <p id="cameraPetInfo" class="text-dark"></p>
            </div>
        </div>
    </div>
</div>

<?php include('./script.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let model;
    const video = document.getElementById("video");
    async function loadModel() {
        model = await mobilenet.load();
        console.log("Model loaded successfully!");
    }

    async function setupCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        } catch (error) {
            console.error("Error accessing the camera: ", error);
            alert("Could not access the camera. Please check your permissions.");
        }
    }

    function captureImage() {
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        document.getElementById('capturedImg').src = canvas.toDataURL("image/png");
        classifyCapturedImage();
        new bootstrap.Modal(document.getElementById('resultModal')).show();
    }

    async function classifyCapturedImage() {
        if (!model) {
            alert("Model is still loading. Please wait.");
            return;
        }
        const canvas = document.getElementById("canvas");
        const imageTensor = tf.browser.fromPixels(canvas);
        const predictions = await model.classify(imageTensor);
        imageTensor.dispose();
        document.getElementById('cameraPetInfo').innerText = `Prediction: ${predictions[0].className} (${Math.round(predictions[0].probability * 100)}% confidence)`;
    }

    function switchCamera() {
        location.reload();
    }

    loadModel();
    setupCamera();
</script>
</body>

</html>
