<?php
session_start();
?>
            <?php
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                echo "<h1>Welcome {$_SESSION['username']} to Darwin Server </h1>";
            } else {
                header("Location: index.html");
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
    <section class="content">
        <!-- Add content to your main section here-->
        <h1>Welcome to the primary hub for my Darwin Server!</br></br></h1>
        <p>This website serves as a central platform primarily utilized by myself, Hot Karl, and potentially Jorge. Its security is complete crap, feel free to explore and utilize its features.</br></br>
            It's worth noting that the server's name, "Darwin," pays homage to Darwin Raglan Caspian Ahab Poseidon Nicodemius Watterson the 3rd not the Scientist.</br></br>
            Feel free to navigate through the code and look at how horrendous it is. Enjoy your time here watching Bluey Dom!</p>
    </section>
</main>
<div id="footer"></div>
<script src="format.js"></script>
</body>
</html>