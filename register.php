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
    <section class="content">
        <?php
        session_start();
        use Dotenv\Dotenv;
	use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;

        require __DIR__ . '/vendor/autoload.php';
        require __DIR__ . '/phpMailer/src/Exception.php';
        require __DIR__ . '/phpMailer/src/PHPMailer.php';
        require __DIR__ . '/phpMailer/src/SMTP.php';

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            header("location: LoginHome.php");
            exit;
        }
        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            $mail = new PHPMailer(true);
            try {
                try {
                    $dotenv = Dotenv::createImmutable("/var/www/", "pass.env");
                    $dotenv->load();

                   // $config = parse_ini_file(__DIR__ . 'pass.env');

                    $mail->Username = $_ENV['MAIL_USERNAME'];
                    $mail->Password = $_ENV['MAIL_PASSWORD'];
                    $mail->isSMTP();
                    $mail->Host = 'mail.domsmacshack.com';
                    $mail->SMTPAuth = true;
                    echo getenv('MAIL_USERNAME');
                    echo getenv('MAIL_PASSWORD');
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $fname = $_POST["fname"];
                    $lname = $_POST["lname"];
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                    $comment = $_POST["largeInput"];
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $date = date('Y-m-d H:i:s');

                    $mail->setFrom($email, $fname. " ".$lname);
                    $mail->addAddress("dominic@domsmacshack.com", "Dom" . ' ' . "Hann");

                    $mail->isHTML(true);
                    $mail->Subject = "Registration to Server - " . $fname . " " . $lname;
                    $mail->Body = "This is an automated response from lila.domserver.xyz. This is a request from " . $fname . " " . $lname . " to be registered to your server.<br />" .
                        "This came from IP: " . $ip . " at " . $date . ". Here is all of the info about the user:<br />" .
                        "First Name: " . $fname . "<br />" .
                        "Last Name: " . $lname . "<br />" .
                        "Email: " . $email . "<br />" .
                        "Hashed Password: " . $hashed_password . "<br />" .
                        "User comment below if any:<br />" . $comment;
                    $mail->send();
                }catch (Exception $e) {
                    echo "There was an error sending the email. Mailer error: " . $mail->ErrorInfo;
                    echo '<script type="text/javascript">
                            setTimeout(function(){
                            window.location.href = "index.html";
                            }, 5000);
                        </script>';
                    exit;
                }
                echo "Registration information was sent to the email successfully.";
                echo '<script type="text/javascript">
                            setTimeout(function(){
                            window.location.href = "index.html";
                            }, 5000);
                        </script>';
            } catch (Exception $e) {
                echo "There was an error sending the email.";
                echo '<script type="text/javascript">
                            setTimeout(function(){
                            window.location.href = "index.html";
                            }, 5000);
                        </script>';
            }
        }
        ?>
    </section>
</main>
<footer class="footer"><p> © 2022 Darwin Server. All rights reserved.</p></footer>
</body>
</html>

