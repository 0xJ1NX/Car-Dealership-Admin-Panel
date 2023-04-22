
<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    include "helper/db_con.php";

    $email_error = null;

    if (isset($_POST['forgotPassButton'])) {

        $email =strtolower(trim( $_POST['email'] ));
        if (empty($email)) {
            $email_error = "Email is required";
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_error = "Invalid email format";
            }
        }

        if ($email_error == null) {

            $query = "SELECT * FROM users WHERE email_for_web = '$email'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);

                //generate random password and send it to user's email
                $password = substr(md5(rand(0,1000)), 0, 10);
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $query = "UPDATE users SET password = '$hashed_password' WHERE email_for_web = '$email'";
                $result = mysqli_query($conn, $query);

                //send email
                $to = $email;
                $subject = "Password Reset";
                $message = "Your new password is: " . $password;
                $headers = "From: Vienna Motors (= ";
                echo "<script>alert('Password has been sent to your email' +
                        '  $password ')</script>";
                echo "<script>window.location.href='login.php'</script>";




//
//                //Load Composer's autoloader
//                require 'vendor/autoload.php';
//
//                //Create an instance; passing `true` enables exceptions
//                $mail = new PHPMailer(true);

//                try {
//                    //Server settings
//                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//                    $mail->isSMTP();                                            //Send using SMTP
//                    $mail->Host = 'smtp.example.com';                     //Set the SMTP server to send through
//                    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
//                    $mail->Username = 'user@example.com';                     //SMTP username
//                    $mail->Password = 'secret';                               //SMTP password
//                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//                    $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
//
//                    //Recipients
//                    $mail->setFrom('from@example.com', 'Mailer');
//                    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
//                    $mail->addAddress('ellen@example.com');               //Name is optional
//                    $mail->addReplyTo('info@example.com', 'Information');
//                    $mail->addCC('cc@example.com');
//                    $mail->addBCC('bcc@example.com');
//
//                    //Attachments
//                    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//                    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
//
//                    //Content
//                    $mail->isHTML(true);                                  //Set email format to HTML
//                    $mail->Subject = 'Here is the subject';
//                    $mail->Body = 'This is the HTML message body <b>in bold!</b>';
//                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//
//                    $mail->send();
//                    echo 'Message has been sent';
//                } catch (Exception $e) {
//                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//                }



            } else {
                $email_error = "Email does not exist";
            }
        }

    }

?>







<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Forgotten Password - Omar &amp; Jenin</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css">
</head>

<body class="bg-gradient-primary" style="background: linear-gradient(to left, #cb2d3e, #ef473a);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-password-image" style="background: url(&quot;assets/img/dogs/you-forgot-your-hyec25.jpg&quot;) center / contain space;"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-2">Forgot Your Password?</h4>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user" method="post" >
                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email" >
                                            <?php if (isset($email_error)) { ?>
                                                <div class="alert alert-danger">
                                                    <?php echo $email_error; ?>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <button class="btn btn-primary d-block btn-user w-100" type="submit" name="forgotPassButton" style="background: linear-gradient(to right, #606c88, #3f4c6b);">Reset Password</button>
                                    </form>
                                    <div class="text-center">
                                        <hr>
                                    </div>
                                    <div class="text-center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-1.js"></script>
    <script src="assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>