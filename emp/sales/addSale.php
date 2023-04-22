<?php

include '../../helper/db_con.php';
session_start();

if (!isset($_SESSION['UserID']) || $_SESSION['isAdmin'] != 0) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}

if (isset($_POST['sellCar'])) {
    $idNum = $_POST['idNum'];

    //check if client is already in database
    $sql = "SELECT * FROM clients WHERE ClientID = '$idNum'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        //client is not in database, add him
        $fName = $_POST['fName'];
        $lName = $_POST['lName'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $notes = $_POST['notes'];
        $sql = "INSERT INTO clients (ClientID, FirstName, LastName, Address, Phone, Email, Notes) VALUES ('$idNum', '$fName', '$lName', '$address', '$phone', '$email', '$notes')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            header("Location: ../sales.php?error=Error adding client");
            exit;
        }

        //add sale
        //get the emp id of the user id
        $userid = $_SESSION['UserID'];
        $sql = "SELECT EmpID FROM users WHERE UserID = '$userid'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $emp_Id = $row['EmpID'];


        $paymentId = $_POST['paymentMethode'];
        $carId = $_POST['carId'];
        $amount = $_POST['finalPrice'];




        $sql = "INSERT INTO sales (Client_ID,Vehicle_ID,emp_id,pm_id,date_of_purchase,final_price) VALUES ('$idNum','$carId','$emp_Id','$paymentId',NOW(),'$amount')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            header("Location: ../sales.php?error=Error adding sale:");
            exit;
        }

        header("Location: ../sales.php?success=Sale added successfully");
        exit;

    }else{

        //add sale
        //get the emp id of the user id
        $userid = $_SESSION['UserID'];
        $sql = "SELECT EmpID FROM users WHERE UserID = '$userid'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $emp_Id = $row['EmpID'];


        $paymentId = $_POST['paymentMethode'];
        $carId = $_POST['carId'];
        $amount = $_POST['finalPrice'];



        $sql = "INSERT INTO sales (Client_ID,Vehicle_ID,emp_id,pm_id,date_of_purchase,final_price) VALUES ('$idNum','$carId','$emp_Id','$paymentId',NOW(),'$amount')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $error = mysqli_error($conn);
            header("Location: ../sales.php?error=$error adding sale");
            exit;
        }

        header("Location: ../sales.php?success=Sale added successfully");
        exit;


    }

}
