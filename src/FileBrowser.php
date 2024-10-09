<?php
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
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
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div id="header"></div>
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

    $base_dir = 'serverRoot/'; // Change this to the base directory you want to browse
    $images_folder = 'serverImages/'; // Folder where your images are located
    $isMedia = false;

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
    echo '</div>'; // Close path-bar
    echo '</div>'; // Close path-bar-container

    // Add a spacer or divider between the path bar and the search bar for visual separation
    echo '<div class="spacer"></div>';

    // Add the search bar and buttons container
    echo '<section class="search-bar-container">';
    echo '<div class="search-bar-wrapper">'; // Container for search bar and buttons

    // Search bar
    echo '<input type="text" id="searchInput" class="search-input" placeholder="Enter your search query">';

    // Show buttons for selected files
    echo '<form method="post" class="buttons-form">'; // Form for buttons
    echo '<input type="hidden" name="action" value="delete">';
    $selected_files = isset($_POST['selected_files']) ? $_POST['selected_files'] : [];
    foreach ($selected_files as $file) {
        echo '<input type="hidden" name="selected_files[]" value="' . htmlentities($file) . '">';
    }
    echo '<button class="option-button delete-button" name="action" value="delete"></button>';
    echo '<button class="option-button download-button" name="action" value="download"></button>';
    echo '</form>'; // Close form for buttons

    echo '</div>'; // Close container for search bar and buttons
    echo '</section>';

    // List files
    echo '<table id="fileTable" class="file-browser">'; // Added id="fileTable"
    echo '<tr>';
    echo '<th>Name</th>';
    echo '<th>Date</th>';
    echo '<th>Options</th>';
    echo '</tr>';

    foreach ($files as $file) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        $file_path = $current_dir . $file;
        echo '<tr>';
        echo '<td>';
        if (is_dir($file_path)) {
            echo '<span class="file-icon folder-icon"></span>';
            echo '<a href="?dir=' . urlencode($file_path) . urlencode("/"). '"><strong>' . $file . '</strong></a>';
        } else {
            $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
            switch ($file_extension) {
                case 'txt':
                case 'php':
                case 'html':
                case 'css':
                case 'js':
                    $icon_class = 'text-file-icon';
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    $icon_class = 'image-file-icon';
                    break;
                case 'mp4':
                case 'avi':
                case 'mov':
                case 'mkv':
                case 'm4v':
                    $icon_class = 'video-file-icon';
                    echo '<span class="file-icon ' . $icon_class . '"></span>';
                    echo '<a href="videoPage.html?video=' . urlencode($file_path) . '">' . $file . '</a>';
                    $isMedia = true;
                    break;
                default:
                    $icon_class = 'default-file-icon';
                    break;
            }
            if(!$isMedia) {
                echo '<span class="file-icon ' . $icon_class . '"></span>';
                echo '<a href="' . $file_path . '">' . $file . '</a>';
                $isMedia = false;
            }
            $isMedia = false;
        }
        echo '</td>';
        echo '<td>';
        if (is_file($file_path)) {
            echo date("Y-m-d H:i:s", filemtime($file_path));
        } else {
            echo '-';
        }
        echo '</td>';
        echo '<td>';
        echo '<button class="option-button"></button>';
        if (is_file($file_path)) {
            echo '<button class="option-button"></button>';
        } else {
            echo '<button class="option-button"></button>';
        }
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
    ?>
</main>
<div id="footer"></div>
<script src="format.js"></script>
</body>
</html>
