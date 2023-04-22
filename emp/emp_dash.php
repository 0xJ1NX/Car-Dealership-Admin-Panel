<?php
session_start();
if(!isset($_SESSION['UserID'])  || $_SESSION['isAdmin'] != 0 ){
    session_destroy();
    header("Location: ../login.php");
    exit;
}

include '../helper/db_con.php';


$userID = $_SESSION['UserID'];

//get the emp id of the logged in user
$sql = "SELECT EmpID FROM users WHERE UserID = '$userID'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$emp_id = $row[0];


$sql = "SELECT COUNT(*) FROM vehicles INNER JOIN sales ON vehicles.VehicleID = sales.vehicle_id AND sales.emp_id = '$emp_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$total_sold_vehicles = $row[0];


$sql = "SELECT COUNT(*) FROM vehicles";
$result = mysqli_query($conn, $sql);
$available_vehicles = 0;
if ($result) {
    $row = mysqli_fetch_array($result);
    $total_vehicles = $row[0];
    $available_vehicles = $total_vehicles - $total_sold_vehicles;
}




$sql = "SELECT COUNT(*) FROM sales INNER JOIN clients ON sales.client_id = clients.ClientID AND sales.emp_id = '$emp_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
$total_sold_clients = $row[0];









?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Omar &amp; Jenin</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="../assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css">
</head>



<body id="page-top">
<div id="wrapper">
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="background: linear-gradient(to left, #cb2d3e, #ef473a);">
        <div class="container-fluid d-flex flex-column p-0"><a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-car-side"></i></div>
                <div class="sidebar-brand-text mx-3"><span>Car dealer</span></div>
            </a>
            <hr class="sidebar-divider my-0">
            <ul class="navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item"><a class="nav-link active" href="emp_dash.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li class="nav-item"><a class="nav-link " href="vehicles.php"><i class="fas fa-car"></i><span>Vehicles</span></a></li >
                <li class="nav-item"><a class="nav-link" href="sales.php"><i class="fas fa-money-bill-wave"></i><span>sales</span></a></li>
                <li class="nav-item"><a class="nav-link " href="transactions.php"><i class="fas fa-address-book"></i><span>Transactions</span></a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-cog"></i><span>settings</span></a></li>
            </ul>

            <div class="text-center d-none d-md-inline">
                <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
            </div>

        </div>
    </nav>

    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content" style="--bs-primary: #d6353d;--bs-primary-rgb: 214,53,61;">

            <?php include 'includes/header.php'; ?>


            <div class="container-fluid">

                <div class="d-sm-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark mb-0">The more You sell , the more you get</h3>
                </div>


                <div class="row">




                    <div class="card shadow border-start-info py-2" style="height: 94.8px;">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters" style="height: 62px;">
                                <div class="col me-2">
                                    <div class="text-uppercase text-info fw-bold text-xs mb-1"><span style="color: var(--bs-danger);">CLIENTS NUMBER</span></div>
                                    <div class="row g-0 align-items-center">
                                        <div class="col-auto">
                                            <div class="text-dark fw-bold h5 mb-0 me-3"><span><?php echo $total_sold_clients ?></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto"><i class="fas fa-user-tag fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>
                             <!-- total clients number -->


                    <div class="card shadow border-start-success py-2" style="height: 94.8px;margin-top: 25px;">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-success fw-bold text-xs mb-1" style="color: rgb(96,108,136);"><span style="color: var(--bs-danger);">TOTALE VEHICLE SOLD</span></div>
                                    <div class="text-dark fw-bold h5 mb-0"><span><?php echo $total_sold_vehicles?></span></div>
                                </div>
                                <div class="col-auto"><i class="fas fa-car fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>    <!-- total sold vehicles number -->

                    <div class="card shadow border-start-success py-2" style="height: 94.8px;margin-top: 25px;">
                        <div class="card-body">
                            <div class="row align-items-center no-gutters">
                                <div class="col me-2">
                                    <div class="text-uppercase text-success fw-bold text-xs mb-1" style="color: rgb(96,108,136);"><span style="color: var(--bs-danger);">TOTALE VEHICLE Available</span></div>
                                    <div class="text-dark fw-bold h5 mb-0"><span><?php echo $available_vehicles ?></span></div>
                                </div>
                                <div class="col-auto"><i class="fas fa-box fa-2x text-gray-300"></i></div>
                            </div>
                        </div>
                    </div>    <!-- available vehicles number -->


                </div>      <!-- top row -->

            </div>


        </div>


        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © Omar &amp; Jenin 2022</span></div>
            </div>
        </footer>



    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>



</div>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/js/chart.min.js"></script>
<script src="../assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="../assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20-1.js"></script>
<script src="../assets/js/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.js"></script>
<script src="../assets/js/theme.js"></script>
</body>

</html>