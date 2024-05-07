
        <?php
        session_start();

        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            header("location: LoginRedirect.php");
            exit;
        }
        $targetDir = "serverRoot/uploads/"; $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "<h2 class='success'>File Uploaded Successfully!</h2>";
        } else {
            echo "<h2 class='error'>Sorry, there was an error uploading your file.</h2>";
        }?>
