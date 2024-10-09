<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: LoginRedirect.php");
    exit;
}

// Get the video file path from the query string
if(isset($_GET['video'])) {
    $video_path = $_GET['video'];
} else {
    // If no video path is provided, exit
    exit('No video path provided.');
}

// Determine the MIME type of the video file
$mime_type = mime_content_type($video_path);

// Set the appropriate MIME type header
header("Content-Type: $mime_type");
header("Accept-Ranges: bytes");

// Open the video file
$video_file = fopen($video_path, 'rb');

// Get the file size
$file_size = filesize($video_path);

// Set the content length header
header("Content-Length: $file_size");

// Check if the client supports range requests
if (isset($_SERVER['HTTP_RANGE'])) {
    // Parse the range header to get the byte range
    list($start, $end) = explode('-', $_SERVER['HTTP_RANGE']);
    $start = intval($start);
    $end = $end ? intval($end) : $file_size - 1;

    // Set the appropriate headers for partial content
    header("HTTP/1.1 206 Partial Content");
    header("Content-Range: bytes $start-$end/$file_size");

    // Seek to the start position
    fseek($video_file, $start);

    // Calculate the length of the content to be sent
    $length = $end - $start + 1;
    header("Content-Length: $length");
} else {
    // If no range is requested, send the entire video
    $length = $file_size;
}

// Output the content in chunks
while (!feof($video_file) && ($length > 0)) {
    $chunk_size = min(1024 * 16, $length); // Send 16KB chunks
    echo fread($video_file, $chunk_size);
    $length -= $chunk_size;
}

// Close the file
fclose($video_file);
?>