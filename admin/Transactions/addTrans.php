<?php

include '../../helper/db_con.php';
session_start();

if (!isset($_SESSION['UserID']) || $_SESSION['isAdmin'] != 1) {
    session_destroy();
    header("Location: ../../login.php");
    exit;
}

if (isset($_POST['addTrans'])) {

    $salesId = trim($_POST['sale_id']);
    $amount = trim($_POST['amount']);
    $date = date('Y-m-d');

    $sql = "select * from sales where sales_ID = '$salesId'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) < 0) {
        header("Location: ../Transactions.php?error=SalesIDNotFound");
        exit();
    }

    $sql = "insert into transactions (sale_ID, amount, date_of_payment) values ('$salesId', '$amount', '$date')";
    if(mysqli_query($conn, $sql)){
        header("Location: ../Transactions.php?success=TransactionAdded");
    } else {
        header("Location: ../Transactions.php?error=TransactionNotAdded");
    }
    exit();

}

header("Location: ../Transactions.php?error=TransactionNotAdded");
exit();









