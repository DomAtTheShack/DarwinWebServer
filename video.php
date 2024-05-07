<?php
// Path to the video file
$video_path = 'C:\Users\ctehannd67\Downloads\B.mp4';

// Set appropriate headers for video streaming
header('Content-Type: video/mp4');
header('Content-Length: ' . filesize($video_path));

// Open the video file
$handle = fopen($video_path, 'rb');

// Stream the video file
fpassthru($handle);

// Close the file handle
fclose($handle);
?>
