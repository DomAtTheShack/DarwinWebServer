<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: LoginRedirect.php");
    exit;
}
// Handle file upload
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] === UPLOAD_ERR_OK) {
        $targetDir = "serverRoot/uploads/";
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo json_encode(["status" => "success", "message" => "File Uploaded Successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Sorry, there was an error uploading your file."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "File upload error: " . $_FILES["fileToUpload"]["error"]]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Browser</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div id="header"></div>
<main>
    <h1>Upload File</h1>
    <form id="uploadForm" action="" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload" required>
        <button type="submit">Upload File</button>
    </form>

    <div id="loadingBar" class="loading-bar">
        <div id="loadingProgress">0%</div>
    </div>

    <div id="result"></div>
</main>
<div id="footer"></div>
<script src="format.js"></script>

<script>
    document.getElementById('uploadForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();
        var loadingBar = document.getElementById('loadingBar');
        var progress = document.getElementById('loadingProgress');

        // Show loading bar
        loadingBar.style.display = 'block';

        // Update progress bar
        xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
                var percentComplete = (e.loaded / e.total) * 100;
                progress.style.width = percentComplete + '%';
                progress.innerHTML = Math.round(percentComplete) + '%';
            }
        });

        // Handle request completion
        xhr.addEventListener('load', function() {
            var response = JSON.parse(xhr.responseText);
            if (xhr.status === 200) {
                document.getElementById('result').innerHTML = '<h2 class="success">' + response.message + '</h2>';
            } else {
                document.getElementById('result').innerHTML = '<h2 class="error">' + response.message + '</h2>';
            }
            // Hide loading bar
            loadingBar.style.display = 'none';
        });

        // Handle request error
        xhr.addEventListener('error', function() {
            document.getElementById('result').innerHTML = '<h2 class="error">An error occurred during the upload.</h2>';
            // Hide loading bar
            loadingBar.style.display = 'none';
        });

        xhr.open('POST', '');
        xhr.send(formData);
    });
</script>

</body>
</html>
