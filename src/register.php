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
        <?php
        session_start();
        echo "Start";
        use Dotenv\Dotenv;
        use PHPMailer\PHPMailer\Exception;
        use PHPMailer\PHPMailer\PHPMailer;
        echo "Start1.5";
        require __DIR__ . '/vendor/autoload.php';
        require __DIR__ . '/vendor/phpMailer/phpmailer/src/Exception.php';
        require __DIR__ . '/vendor/phpMailer/phpmailer/src/PHPMailer.php';
        require __DIR__ . '/vendor/phpMailer/phpmailer/src/SMTP.php';
        echo "Start2";

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        echo "Start3";

        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
            header("location: LoginHome.php");
            exit;
        }
        echo "Start4";

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "Start5";

            $mail = new PHPMailer(true);
            try {
                try {
                    $dotenv = Dotenv::createImmutable("/var/www/", "pass.env");
                    $dotenv->load();

                   // $config = parse_ini_file(__DIR__ . 'pass.env');
                    echo "Start6";

                    $mail->Username = $_ENV['MAIL_USERNAME'];
                    $mail->Password = $_ENV['MAIL_PASSWORD'];
                    $mail->isSMTP();
                    $mail->Host = 'mail.domsmacshack.com';
                    $mail->SMTPAuth = true;
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
<div id="footer"></div>
<script src="format.js"></script>
</body>
</html>

