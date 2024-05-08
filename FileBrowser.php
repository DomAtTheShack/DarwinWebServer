        <?php

        
	session_start();
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            header("location: LoginRedirect.php");
            exit;
        }
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Browser</title>
    <style>
        <?php include 'style.css'; ?>
    </style>
</head>
<body>
<header>
    <section class="header-container">
        <div>
            <h1>Welcome to Darwin Server</h1>
            <p>Your gateway to the World Wide Web</p>
        </div>
        <div>
            <a href="LoginHome.php">
                <img src="serverImages/favicon.ico" alt="Website Icon">
            </a>
        </div>
    </section>
    <section style="background-color: #eeeeee; font-size:3vh; border-top: 2px dashed black; border-bottom: 2px dashed black; text-align:center; padding: .5%">
        <a href="login.html" style="margin-right: 2vw;"> Login/Register</a>
        <a href="Upload.php" style="margin-right: 2vw;"> Upload</a>
        <a href="FileBrowser.php" style="margin-right: 2vw;"> File Browser</a>
        <a href="About.html" style="margin-right: 2vw;"> About this Server</a>
    </section>
</header>
<main>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'delete':
                    // Implement delete action
                    // You can delete the selected files here
                    break;
                case 'download':
                    // Implement download action
                    // You can create a zip file containing selected files and initiate download
                    break;
                // Add more cases for other actions as needed
            }
        }
    }

    $base_dir = 'serverRoot'; // Change this to the base directory you want to browse
    $images_folder = 'serverImages'; // Folder where your images are located

    if(isset($_GET['dir'])) {
        $current_dir = $_GET['dir'];
    } else {
        $current_dir = $base_dir;
    }

    // Get the list of files in the directory
    $files = scandir($current_dir);

    // Display path bar
    echo '<div class="path-bar-container">';
    echo '<div class="path-bar">';
    $path_segments = explode('/', $current_dir);
    $dir_path = '';
    foreach ($path_segments as $segment) {
        if (!empty($segment)) {
            $dir_path .= $segment . '/';
            echo '<a href="?dir=' . urlencode($dir_path) . '">' . $segment . '</a>';
            echo '/';
        }
    }
    echo '</div>';

    // Show buttons for selected files
    echo '<form method="post">';
    echo '<input type="hidden" name="action" value="delete">';
    $selected_files = isset($_POST['selected_files']) ? $_POST['selected_files'] : [];
    foreach ($selected_files as $file) {
        echo '<input type="hidden" name="selected_files[]" value="' . htmlentities($file) . '">';
    }
    echo '<button class="option-button" name="action" value="delete"><span class="option-icon" style="background-image: url(' . $images_folder . '/delete-icon.png);"></span></button>';
    echo '<button class="option-button" name="action" value="download"><span class="option-icon" style="background-image: url(' . $images_folder . '/download-icon.png);"></span></button>';
    echo '</form>';
    echo '</div>';

    // List files
    echo '<table class="file-browser">';
echo '<tr>';
echo '<th>Name</th>';
echo '<th>Date</th>'; // Add date column header
echo '<th>Options</th>'; // Add options column header
echo '</tr>';

foreach ($files as $file) {
    if ($file == '.' || $file == '..') {
        continue;
    }
    $file_path = $current_dir . '/' . $file;
    echo '<tr>';
    echo '<td>';
    if (is_file($file_path)) {
        echo '<a href="' . $file_path . '">' . $file . '</a>'; // Display a clickable link for all files
    } else {
        echo '<a href="?dir=' . urlencode($file_path) . '"><strong>' . $file . '</strong></a>'; // Display directory as a clickable link
    }
    echo '</td>';

    echo '<td>'; // Start date column
    if (is_file($file_path)) {
        // Display file modification date if it's a file
        echo date("Y-m-d H:i:s", filemtime($file_path));
    } else {
        echo '-'; // Display a placeholder if it's not a file
    }
    echo '</td>'; // End date column

    echo '<td>'; // Start options column
    // You can add options buttons here
    echo '</td>'; // End options column

    echo '</tr>';
}
echo '</table>';
?>

</main>
<footer class="footer"><p>© 2022 Darwin Server. All rights reserved.</p></footer>
</body>
</html>
