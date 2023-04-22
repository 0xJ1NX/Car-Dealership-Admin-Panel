<?php
include 'helper/db_con.php';

session_start();

$email_error = $password_error = "";

if (isset($_POST['login'])) {
    $email =strtolower(trim( $_POST['email'] ));
    $password = trim($_POST['password']);

    if (empty($email)) {
        $email_error = "Email is required";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format";
    }

    if (empty($password)) {
        $password_error = "Password is required";
    }

    if (empty($email_error) && empty($password_error)) {
        $email = mysqli_real_escape_string($conn, $email);
        $password = mysqli_real_escape_string($conn, $password);

        $query = "SELECT * FROM users WHERE email_for_web = '$email'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) ==0) {
            $email_error = "Email is not registered";
        }else{

            $hash = $row['password'];

            if (password_verify($password, $hash)) {
                $_SESSION['isAdmin'] = $row['isAdmin'];
                $_SESSION['UserID'] = $row['UserID'];


                header("Location: index.php");
                exit();
            } else {
                $password_error = "Password is incorrect";
            }

        }
    }




    if (!empty($email_error) || !empty($password_error)) {
        echo '<script>window.location.href = "login.php?email_error='.$email_error .'&password_error='.$password_error.'";</script>';
        exit();
    }






}
