<?php

    $db_host = "";
    $db_user = "";
    $db_pass = "";
    $db_name = "";

    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

    if(!$conn){
        die("Database connection failed: Contact The Admin " . mysqli_error($conn));
    }




