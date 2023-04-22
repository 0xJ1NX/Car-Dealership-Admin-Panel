<?php

    //get the error message from the url
    if (isset($_GET['email_error'])) {
        $email_error = $_GET['email_error'];
    }
    if (isset($_GET['password_error'])) {
        $password_error = $_GET['password_error'];
    }


?>



<!DOCTYPE html>
<html style="--bs-primary: #d6353d;--bs-primary-rgb: 214,53,61;" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Omar &amp; Jenin</title>
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

                        <!-- Login image -->
                        <div class="col-lg-6 d-none d-lg-flex">
                            <div class="flex-grow-1 bg-login-image" style="background: url(assets/img/dogs/logo.png) center / contain;"></div>
                        </div>
                        <!-- end of login image -->


                        <div class="col-lg-6">

                            <div class="p-5">


                                <div class="text-center">
                                    <h4 class="text-dark mb-4">Welcome Back!</h4>
                                </div>


                                <p class="text-center">" Hey , you look gorgeous Today , yes you "&nbsp;</p>


                                <form class="user" method="post" action="login_check.php" >

                                    <div class="mb-3">
                                        <input class="form-control form-control-user" type="email" id="InputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..."
                                               name="email"  >
                                    </div>



                                    <?php if (isset($email_error)  && !empty($email_error)) { ?>
                                        <div class="alert alert-danger">
                                            <?php echo $email_error; ?>
                                        </div>
                                    <?php } ?>



                                    <div class="mb-3">
                                        <input class="form-control form-control-user" type="password" id="InputPassword" placeholder="Password" name="password" >
                                    </div>

                                    <?php if (isset($password_error)  && !empty($password_error)) { ?>
                                        <div class="alert alert-danger " >
                                            <?php echo $password_error; ?>
                                        </div>
                                    <?php } ?>


                                    <div class="mb-3">
                                        <div class="custom-control custom-checkbox small">
                                            <div class="form-check">
                                                <input class="form-check-input custom-control-input" name="RemMe" type="checkbox" id="formCheck-1" value="on">
                                                <label class="form-check-label custom-control-label" for="formCheck-1">Remember Me</label>
                                            </div>
                                        </div>
                                    </div>


                                    <button class="btn btn-primary d-block btn-user w-100" type="submit" name="login"
                                            value="login" style="background: linear-gradient(to right, #606c88, #3f4c6b);">Login
                                    </button>

                                    <hr>

                                </form>
                                <div class="text-center"><a class="small" href="forget-password.php" style="color: #606c88;">Forgot Password?</a></div>
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