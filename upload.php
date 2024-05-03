<!DOCTYPE html>
<html lang="en">
    <head> <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <title>File Upload</title> <link
    rel="stylesheet" href="style.css">
</head> <body>
    <?php $targetDir = "uploads/"; $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]); if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"],
$targetFile)) {
  echo "<h2 class='success'>File Uploaded Successfully!</h2>";
} else {
    echo "<h2 class='error'>Sorry, there was an error uploading your file.</h2>";
}
?> </body> </html>