<?php

include '../../helper/db_con.php';
session_start();

if (!isset($_SESSION['UserID']) || $_SESSION['isAdmin'] != 1) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['TransID'])) {
    $TransID = $_GET['TransID'];
    $sql = "DELETE FROM transactions WHERE TransID = '$TransID'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        header("Location: ../Transactions.php?error=Error deleting transaction");
        exit;
    }
    header("Location: ../Transactions.php?success=Transaction deleted successfully");
    exit;
}
