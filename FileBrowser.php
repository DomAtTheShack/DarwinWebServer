<?php

session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    //  header("location: LoginRedirect.php");
    //  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Browser</title>
    <style>
        /* Your CSS styles here */
        /* Include the font styles from your style.css file */
        <?php include 'style.css'; ?>

        /* Additional styles for the file browser */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
            padding: 20px;
            padding-bottom: 100px; /* Adjust this value as needed */
        }
        footer {
            background-color: #eee;
            padding: 10px;
            text-align: center;
            flex-shrink: 0; /* Prevent footer from shrinking */
        }
        /* Add borders to the table */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
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

    $base_dir = 'serverImages/'; // Change this to the base directory you want to browse
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
    echo '<th>Date</th>';
    echo '<th>Options</th>';
    echo '</tr>';

    foreach ($files as $file) {
        if ($file == '.' || $file == '..') {
            continue;
        }
        $file_path = $current_dir . '/' . $file;
        echo '<tr>';
        echo '<td>';
        if (is_dir($file_path)) {
            echo '<span class="file-icon" style="background-image: url(' . $images_folder . '/folder-icon.png);"></span>';
            echo '<a href="?dir=' . urlencode($file_path) . '"style=" margin-left:10px"><strong>' . $file . '</strong></a>';
        } else {
            $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
            switch ($file_extension) {
                case 'txt':
                case 'php':
                case 'html':
                case 'css':
                case 'js':
                    $icon_path = $images_folder . '/text-file-icon.png';
                    break;
                case 'jpg':
                case 'jpeg':
                case 'png':
                case 'gif':
                    $icon_path = $images_folder . '/image-file-icon.png';
                    break;
                case 'mp4':
                case 'avi':
                case 'mov':
                case 'mkv':
                    $icon_path = $images_folder . '/video-file-icon.png';
                    echo '<span class="file-icon" style="background-image: url(' . $icon_path . ');"></span>';
                    echo '<a href="videoPage.html?video=' . urlencode($file_path) . '">' . $file . '</a>';
                    $isMedia = true;
                    break;
                default:
                    $icon_path = $images_folder . '/default-file-icon.png';
                    break;
            }
            if(!$isMedia) {
                echo '<span class="file-icon" style="background-image: url(' . $icon_path . ');"></span>';
                echo '<a  href="' . $file_path . '"style=" margin-left:10px";>' . $file . '</a>';
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
<footer class="footer"><p>© 2022 Darwin Server. All rights reserved.</p></footer>
<!-- Code injected by live-server -->
<script>
    // <![CDATA[  <-- For SVG support
    if ('WebSocket' in window) {
        (function () {
            function refreshCSS() {
                var sheets = [].slice.call(document.getElementsByTagName("link"));
                var head = document.getElementsByTagName("head")[0];
                for (var i = 0; i < sheets.length; ++i) {
                    var elem = sheets[i];
                    var parent = elem.parentElement || head;
                    parent.removeChild(elem);
                    var rel = elem.rel;
                    if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
                        var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
                        elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
                    }
                    parent.appendChild(elem);
                }
            }
            var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
            var address = protocol + window.location.host + window.location.pathname + '/ws';
            var socket = new WebSocket(address);
            socket.onmessage = function (msg) {
                if (msg.data == 'reload') window.location.reload();
                else if (msg.data == 'refreshcss') refreshCSS();
            };
            if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
                console.log('Live reload enabled.');
                sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
            }
        })();
    }
    else {
        console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
    }
    // ]]>
</script>
</body>
</html>