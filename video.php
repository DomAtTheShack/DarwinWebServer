<?php
if (isset($_GET['video'])) {
    $video_path = $_GET['video'];

    if (file_exists($video_path)) {
        header('Content-Type: video/mp4');

        $handle = fopen($video_path, 'rb');
        if ($handle === false) {
            echo "Error: Unable to open video file.";
            exit;
        }

        // Omit Content-Length header for streamed content
        // header('Content-Length: ' . filesize($video_path));

        $streamed = fpassthru($handle);
        if ($streamed === false) {
            echo "Error: Failed to stream video file.";
        }

        fclose($handle);
    } else {
        echo "Error: Video file not found.";
    }
} else {
    echo "Error: Video path not provided.";
}
?>
