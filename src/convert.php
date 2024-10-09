<?php
// Function to convert MKV to MP4 using FFmpeg
function convertMKVtoMP4($inputFile, $outputFile) {
    // Use FFmpeg command to perform the conversion
    exec("ffmpeg -i \"$inputFile\" -c:v libx264 -crf 23 -c:a aac -strict -2 \"$outputFile\"", $output, $returnVar);
    if ($returnVar !== 0) {
        echo "Conversion failed for file: $inputFile<br>";
        die("Conversion halted.");
    }
}

// Function to redirect to video player HTML page
function redirectToVideoPlayer($videoPath) {
    header('Location: video_player.html?video=' . urlencode($videoPath));
}

// Check if the requested video is an MKV file
$requestedVideo = $_GET['video']; // Get the requested video from the URL parameter
$videoExtension = pathinfo($requestedVideo, PATHINFO_EXTENSION); // Get the file extension

if ($videoExtension == 'mkv') {
    // Convert MKV to MP4
    $tempDirectory = 'temp/';
    $outputFileName = $tempDirectory . 'converted_video.mp4';
    echo "Converting file: $requestedVideo<br>";
    convertMKVtoMP4($requestedVideo, $outputFileName);

    // Redirect to the video player HTML page with the converted video as a parameter
    redirectToVideoPlayer($outputFileName);
} else {
    // If the requested video is not an MKV file, pass it to the video player HTML page
    redirectToVideoPlayer($requestedVideo);
}
?>
