<?php

session_start();
if (!isset($_SESSION['UserID']) || $_SESSION['isAdmin'] != 0) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}

include '../../helper/db_con.php';

//delete vehicle
if(isset($_GET['vID'])){
    $delete_id = $_GET['vID'];
    echo "<script>alert('$delete_id')</script>";
    $delete_vehicle = "delete from vehicles where VehicleID='$delete_id'";
    $run_delete = mysqli_query($conn,$delete_vehicle);

    if($run_delete){
        header("Location: ../vehicles.php?success=Vehicle Deleted successfully");
    }
    else{
        header("Location: ../vehicles.php?error=Vehicle Delete failed");
    }
    exit();
}

