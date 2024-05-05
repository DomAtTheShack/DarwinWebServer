<?php
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="en" xmlns="http://www.w3.org/1999/html">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome to Darwin Server</title>
        <link rel="stylesheet" href="style.css">
        <link rel="icon" href="serverImages/favicon.ico" type="image/x-icon">
    </head>
    <body data-extension-installed="2.3.0">
    <header>
        <section class="header-container">
            <div>
                <h1>Welcome to Darwin Server </h1>
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
            <a href="Upload.php" style="margin-right: 2vw;"> File Browser</a>
            <a href="About.html" style="margin-right: 2vw;"> About this Server</a>
        </section>
    </header>
    <main>
        <meta http-equiv="refresh" content="5;url=login.html" />
        <h1>You are not logged in!</h1>
        <p>You will be redirected to the login page in 5 seconds...</p>
    </main>
    <footer class="footer"><p> © 2022 Darwin Server. All rights reserved.</p></footer>
    </body>
    </html>
    <?php
    exit;
}
header("Location: ./index.html"); // send user to home screen if logged in
exit;
?>