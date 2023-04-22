<?php

session_start();
include_once '../../helper/db_con.php';

if(!isset($_SESSION['UserID'])  || $_SESSION['isAdmin'] != 1 ){
    session_destroy();
    header("Location: ../login.php");
    exit;
}

//insert new vehicle
if(isset($_POST['addVehicles'])) {

    $Brand = trim($_POST['vehicleBrand']);
    $Model = trim($_POST['vehicleModel']);
    $type = trim($_POST['vehicleType']);
    $transmission = trim($_POST['vehicleTransmission']);
    $Year = trim($_POST['vehicleYear']);
    $keyNumber = trim($_POST['vehicleKey']);
    $km = trim($_POST['vehicleKM']);
    $fuel = trim($_POST['vehicleFuelType']);
    $cc = trim($_POST['vehicleMotorCC']);
    $color = trim($_POST['vehicleColor']);
    $chassis = trim($_POST['vehicleChassis']);
    $waranty = trim($_POST['vehicleWaranty']);
    $buyPrice = trim($_POST['vehicleBuyingPrice']);
    $exportPrice = trim($_POST['vehicleExportPrice']);
    $sellPrice = trim($_POST['vehicleSellingPrice']);
    $description = trim($_POST['vehicleDescription']);

    //check if model already exists
    $sql = "SELECT * FROM models WHERE Name  = '$Model'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $modelID = $row['ModelID'];
        //insert new vehicle
        $sql = "INSERT INTO vehicles ( KeyNo, Type, ModelID, Transmission, Year, KM, Fuel, CC, Color, Warranty, Chassis, Buying_Price, Export_Price, Selling_Price, Features,date_added) VALUES ('$keyNumber', '$type', '$modelID', '$transmission', '$Year', '$km', '$fuel', '$cc', '$color', '$waranty', '$chassis', '$buyPrice', '$exportPrice', '$sellPrice', '$description', NOW())";

        if (mysqli_query($conn, $sql)) {
            header("Location: ../vehicles.php?success=Vehicle added successfully");
            exit();
        }

    } else {

        //insert new model
        //check if brand already exists
        $sql = "SELECT * FROM brands WHERE Name  = '$Brand'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $brandID = $row['BrandID'];
            //insert new model
            $sql = "INSERT INTO models ( Name, BrandID ) VALUES ('$Model', '$brandID')";
            $result = mysqli_query($conn, $sql);
            $modelID = mysqli_insert_id($conn);
            //insert new vehicle
            $sql = "INSERT INTO vehicles ( KeyNo, Type, ModelID, Transmission, Year, KM, Fuel, CC, Color, Warranty, Chassis, Buying_Price, Export_Price, Selling_Price, Features,date_added) VALUES ('$keyNumber', '$type', '$modelID', '$transmission', '$Year', '$km', '$fuel', '$cc', '$color', '$waranty', '$chassis', '$buyPrice', '$exportPrice', '$sellPrice', '$description', NOW())";
            if (mysqli_query($conn, $sql)) {
                header("Location: ../vehicles.php?success=Vehicle added successfully");
                exit();
            }

        } else {
            //insert new brand
            $sql = "INSERT INTO brands ( Name ,Country) VALUES ('$Brand',' ')";
            $result = mysqli_query($conn, $sql);
            $brandID = mysqli_insert_id($conn);
            //insert new model
            $sql = "INSERT INTO models ( Name, BrandID ) VALUES ('$Model', '$brandID')";
            $result = mysqli_query($conn, $sql);
            $modelID = mysqli_insert_id($conn);
            //insert new vehicle
            $sql = "INSERT INTO vehicles ( KeyNo, Type, ModelID, Transmission, Year, KM, Fuel, CC, Color, Warranty, Chassis, Buying_Price, Export_Price, Selling_Price, Features,date_added) VALUES ('$keyNumber', '$type', '$modelID', '$transmission', '$Year', '$km', '$fuel', '$cc', '$color', '$waranty', '$chassis', '$buyPrice', '$exportPrice', '$sellPrice', '$description', NOW())";
            if (mysqli_query($conn, $sql)) {
                header("Location: ../vehicles.php?success=Vehicle added successfully");
                exit();
            }

        }

    }

    header("Location: ../vehicles.php?error=Vehicle not be added");











}


