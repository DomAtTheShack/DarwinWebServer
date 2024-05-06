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
            <h1>Welcome to Darwin Server </h1>
            <p>Your gateway to the World Wide Web</p>
        </div>
        <div>
            <a href="index.html">
                <img src="serverImages/favicon.ico" alt="Website Icon">
            </a>
        </div>
    </section>
    <section style="background-color: #eeeeee; font-size:3vh; border-top: 2px dashed black; border-bottom: 2px dashed black; text-align:center; padding: .5%">
        <a href="Upload.php" style="margin-right: 2vw;"> Login/Register</a>
        <a href="Upload.php" style="margin-right: 2vw;"> Upload</a>
        <a href="Upload.php" style="margin-right: 2vw;"> File Browser</a>
        <a href="About.html" style="margin-right: 2vw;"> About this Server</a>
    </section>
</header>
<main>
    <section class="content">
        <?php
        error_reporting(E_ALL);
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            header("location: LoginHome.php");
            exit;
        }

        // Additional debugging
        var_dump($_POST);

        require __DIR__ . '/vendor/autoload.php';

        $dotenv = Dotenv\Dotenv::createImmutable("/var/www/", "pass.env");
        $dotenv->load();

        //$config = parse_ini_file(__DIR__ . 'pass.env');

        $dbhost = $_ENV['DB_HOST'];
        $dbuser = $_ENV['DB_USER'];
        $dbpass = $_ENV['DB_PASS'];
        $dbname = $_ENV['DB_NAME'];

        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

        if ($conn->connect_error) {
            echo "<div class=\"content\" style=\"text-align:center;\"><p>Connection failed: " . $conn->connect_error . "</p></div>";
            header("refresh:3; url=login.html"); // Here's the delay and redirect
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $passwordFromUser = $_POST["password"];

            $query = $conn->prepare("SELECT * FROM User WHERE username=?");
            $query->bind_param("s", $username);
            $query->execute();

            $result = $query->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                $hashedPasswordFromDatabase = $user["password"];

                if (password_verify($passwordFromUser, $hashedPasswordFromDatabase)) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] = $username;
                    unset($_SESSION["failed_login_count"]);
                    header("location: LoginHome.php");
                } else {
                    $_SESSION["failed_login_count"] = isset($_SESSION["failed_login_count"]) ? $_SESSION["failed_login_count"] + 1 : 1;

                    if ($_SESSION["failed_login_count"] >= 3) {
                        echo "<div class=\"content\" style=\"text-align:center;\"><p>You have made too many failed login attempts. Please try again later.</p></div>";
                        // Here's the delay and redirect
                    } else {
                        echo "<div class=\"content\" style=\"text-align:center;\"><p>Invalid password. You have " . (3 - $_SESSION["failed_login_count"]) . " attempts left.</p></div>";
                        // Here's the delay and redirect
                    }
                    header("refresh:3; url=login.html");
                }
            } else {
                echo "<div class=\"content\" style=\"text-align:center;\"><p>Invalid Username</p></div>";
                header("refresh:3; url=login.html"); // Here's the delay and redirect
            }
        }

        $conn->close();
        ?>
    </section>
</main>
<footer class="footer"><p> © 2022 Darwin Server. All rights reserved.</p></footer>
</body>
</html>
