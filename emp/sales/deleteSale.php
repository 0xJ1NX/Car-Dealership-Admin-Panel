<?php

include '../../helper/db_con.php';
session_start();

if (!isset($_SESSION['UserID']) || $_SESSION['isAdmin'] != 0) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['saleID'])) {
    $saleId = $_GET['saleID'];
    $sql = "DELETE FROM sales WHERE sales_ID = '$saleId'";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        header("Location: ../sales.php?error=Error deleting sale");
        exit;
    }
    header("Location: ../sales.php?success=Sale deleted successfully");
    exit;
}


