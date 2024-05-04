<?php
session_start();
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

            <?php
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                echo "<h1>Welcome {$_SESSION['username']} to Darwin Server </h1>";
            } else {
                header("Location: index.html");
            }
            ?>

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
    <section class="content">
        <!-- Add content to your main section here-->
        <h1>Welcome to the primary hub for my Darwin Server!</br></br></h1>
        <p>This website serves as a central platform primarily utilized by myself, Hot Karl, and potentially Jorge. Its security is complete crap, feel free to explore and utilize its features.</br></br>
            It's worth noting that the server's name, "Darwin," pays homage to Darwin Raglan Caspian Ahab Poseidon Nicodemius Watterson the 3rd not the Scientist.</br></br>
            Feel free to navigate through the code and look at how horrendous it is. Enjoy your time here watching Bluey Dom!</p>
    </section>
</main>
<footer class="footer">
    <p>© 2022 Darwin Server. All rights reserved.</p>
    <form method="post" action="logout.php" style="position: absolute; bottom: 30px; right: 30px;">
        <button type="submit" name="logout" style="padding: 7px 15px; font-size: 0.6em;">Logout</button>
    </form>
</footer>
</body>
</html>