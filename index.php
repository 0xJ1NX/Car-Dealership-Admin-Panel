
<?php
    session_start();

    if (isset($_SESSION['isAdmin']) ){
        if ($_SESSION['isAdmin'] == 1){
            echo '<script>window.location.href = "admin/admin_dash.php";</script>';
            exit;
        }
        else if ($_SESSION['isAdmin'] == 0 ){
            echo '<script>window.location.href = "emp/emp_dash.php";</script>';
            exit;
        }
    }else{
        echo '<script>window.location.href = "login.php";</script>';
        exit;
    }