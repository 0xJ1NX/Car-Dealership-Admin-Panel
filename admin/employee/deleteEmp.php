<?php

session_start();
include '../../helper/db_con.php';
if(!isset($_SESSION['UserID'])  || $_SESSION['isAdmin'] != 1 ) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}

//get the employee id from the url
$empID = $_GET['EmpID'];

//delete the employee
$sql = "DELETE FROM employee WHERE EmpID = '$empID'";
$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: ../../admin/employee.php?success=employeeDeleted");
    exit;
} else {
    header("Location: ../../admin/employee.php?error=employeeNotDeleted");
    exit;
}





