<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
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
        <meta http-equiv="refresh" content="5;url=login.html" />
        <h2>You are not logged in!</h2>
        <p>You will be redirected to the login page in 5 seconds...</p>
    </main>
    <div id="footer"></div>
    <script src="format.js"></script>
    </body>
    </html>
    <?php
    exit;
}
header("Location: ./LoginHome.php"); // send user to home screen if logged in
exit;
?>