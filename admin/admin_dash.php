
<?php
    session_start();
    //if the user is not logged in, redirect to the login page
    if(!isset($_SESSION['UserID'])  || $_SESSION['isAdmin'] != 1 ){
        session_destroy();
        header("Location: ../login.php");
        exit;
    }

    include '../helper/db_con.php';

    //querey to get total number of clients
    $sql = "SELECT COUNT(*) FROM clients";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $total_clients = $row[0];

    //querey to get total number of employees
    $sql = "SELECT COUNT(*) FROM employee";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $total_employees = $row[0];

//profit for the month



    //querey to get the money paid by customer in the month
    $sql = "SELECT SUM(amount) FROM transactions WHERE MONTH(date_of_payment) = MONTH(CURRENT_DATE())";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $money_earned = $row[0];

    //salary of the salesEmployee and bonus percentage of the car sold by the employee
    $sql = "SELECT SUM(salary) FROM sales_employee";
    $result = mysqli_query($conn, $sql);
    $salary_given_salesEmp = 0;
    if ($result) {
        $row = mysqli_fetch_array($result);
        $salary_given_salesEmp = $row[0];
    }

    $sql = "SELECT final_price, Bonus_Per_Sale FROM sales_employee,sales WHERE sales_employee.EmpID = sales.emp_id AND MONTH(sales.date_of_purchase) = MONTH(CURRENT_DATE())";
    $result = mysqli_query($conn, $sql);
    $salary_given_salesEmp_bonus = 0;
    if ($result) {
        //for each row in the result, multiply the final price by the bonus percentage and add it to the total
        while ($row = mysqli_fetch_array($result)) {
            $salary_given_salesEmp_bonus += $row['final_price'] * $row['Bonus_Per_Sale']/100;
        }
    }
    $salary_given_salesEmp = $salary_given_salesEmp + $salary_given_salesEmp_bonus;


    //total salary given to the other employees
    $sql = "SELECT SUM(salary) FROM other_emp";
    $result = mysqli_query($conn, $sql);
    $salary_given_otherEmp = 0;
    if ($result) {
        $row = mysqli_fetch_array($result);
        $salary_given_otherEmp = $row[0];
    }


    //calculate money paid on buying the vehicle this month
    $sql = "SELECT SUM(Buying_Price) FROM vehicles WHERE MONTH(date_added) = MONTH(CURRENT_DATE())";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $money_paid_on_buying = $row[0];
    } else {
        $money_paid_on_buying = 0;
    }
    $sql = "SELECT SUM(Export_Price) FROM vehicles WHERE MONTH(date_added) = MONTH(CURRENT_DATE())";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $money_paid_on_export = $row[0];
    } else {
        $money_paid_on_export = 0;
    }
    //calculate total expenses
    $sql = "SELECT SUM(amount) FROM expenses WHERE MONTH(Date) = MONTH(CURRENT_DATE())";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $total_expenses = $row[0];
    } else {
        $total_expenses = 0;
    }
    $money_paid_on_car = $money_paid_on_buying + $money_paid_on_export + $total_expenses;

    //calculate total profit
    $total_profit_month = $money_earned - $salary_given_salesEmp - $salary_given_otherEmp - $money_paid_on_car;





    //array of total profit for each month initially set to 0
    $profit_every_month = array(0,0,0,0,0,0,0,0,0,0,0,0);
    $today_month = intval(date('m'));
    $profit_every_month[$today_month] = $total_profit_month;
    $profit_of_the_year = 0;
    for ($i = 0 ; $i < sizeof($profit_every_month) ; $i++) {
        $profit_of_the_year += $profit_every_month[$i];
    }









    //querys to get the number of cars sold every month
    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_jan = $row[0];

    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 2";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_feb = $row[0];

    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 3";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_mar = $row[0];

    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 4";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_apr = $row[0];

    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 5";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_may = $row[0];

    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 6";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_jun = $row[0];

    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 7";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_jul = $row[0];

    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 8";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_aug = $row[0];

    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 9";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_sep = $row[0];

    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 10";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_oct = $row[0];

    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 11";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_nov = $row[0];

    $sql = "SELECT COUNT(*) FROM sales WHERE MONTH(date_of_purchase) = 12";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $cars_sold_dec = $row[0];





    //query to get total sold vehicles by joining the tables of vehicles and sales
    $sql = "SELECT COUNT(*) FROM vehicles INNER JOIN sales ON vehicles.VehicleID = sales.vehicle_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    $total_sold_vehicles = $row[0];

    //query to get availabel vehicles by subtracting the total sold vehicles from the total vehicles
    $sql = "SELECT COUNT(*) FROM vehicles";
    $result = mysqli_query($conn, $sql);
    $available_vehicles = 0;
    if ($result) {
        $row = mysqli_fetch_array($result);
        $total_vehicles = $row[0];
        $available_vehicles = $total_vehicles - $total_sold_vehicles;
    }


    //query to get the top demand vehicles model
    $sql = "SELECT vehicles.ModelID, COUNT(*) FROM vehicles INNER JOIN sales ON vehicles.VehicleID = sales.vehicle_id GROUP BY vehicles.ModelID ORDER BY COUNT(*) DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $top_demand_vehicle_model = $row[0];
    } else {
        $top_demand_vehicle_model = "No vehicles sold";
    }


    //get the name and the brand of the top demand vehicle model
    $sql = "SELECT models.Name, brands.Name FROM models INNER JOIN brands ON models.BrandID = brands.BrandID WHERE ModelID = $top_demand_vehicle_model";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $top_demand_vehicle_model_name = $row[0];
        $top_demand_vehicle_brand_name = $row[1];
    } else {
        $top_demand_vehicle_model_name = "No vehicles sold";
        $top_demand_vehicle_brand_name = "";
    }







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
                    <li class="nav-item"><a class="nav-link active" href="admin_dash.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="vehicles.php"><i class="fas fa-car"></i><span>Vehicles</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="employee.php"><i class="fas fa-user-cog"></i><span>Employee</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="Customers.php"><i class="fas fa-user-tag"></i><span>Customers</span></a>
                        <a class="nav-link" href="sales.php"><i class="fas fa-money-bill-wave"></i><span>sales</span></a>
                        <a class="nav-link" href="transactions.php"><i class="fas fa-address-book"></i><span>Transactions</span></a>
                        <a class="nav-link" href="reports.php"><i class="fas fa-book"></i><span>Reports</span></a>
                        <a class="nav-link" href="profile.php"><i class="fas fa-cog"></i><span>settings</span></a></li>
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
                        <h3 class="text-dark mb-0">Dashboard</h3>
                        <a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="../helper/generate_report.php" style="background: linear-gradient(to right, #606c88, #3f4c6b);">
                            <i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report
                        </a>
                    </div>


                    <div class="row">


                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2" style="height: 94.8px;">
                                <div class="card-body" style="height: 61px;">
                                    <div class="row align-items-center no-gutters" style="height: 61px;">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span style="color: var(--bs-danger);">Profit of the Month</span></div>

                                            <div class=" <?php if ($total_profit_month >=0 ){echo "text-dark ";}?>fw-bold h5 mb-0 " <?php if ($total_profit_month <0 ){echo "style='color: var(--bs-danger);'";} ?>>
                                                <span>$<?php echo $total_profit_month ?></span>
                                            </div>


                                        </div>
                                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>          <!-- Earnings (Monthly) -->


                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-warning py-2" style="height: 94.8px;">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters" style="height: 61px;">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span style="color: var(--bs-danger);">Yearly Earniing</span></div>
                                            <div class=" <?php if ($profit_of_the_year >=0 ){echo "text-dark ";}?> fw-bold h5 mb-0"  <?php if ($profit_of_the_year <0 ){echo "style='color: var(--bs-danger);'";} else {echo "style='color: var(--bs-success);'";} ?>>
                                                <span>$<?php echo $profit_of_the_year ?></span>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="far fa-calendar-alt fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>          <!--yearly earning-->


                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-info py-2" style="height: 94.8px;">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters" style="height: 62px;">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span style="color: var(--bs-danger);">CLIENTS NUMBER</span></div>
                                            <div class="row g-0 align-items-center">
                                                <div class="col-auto">
                                                    <div class="text-dark fw-bold h5 mb-0 me-3"><span><?php echo $total_clients ?></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-user-tag fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>          <!-- total clients number -->


                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-warning py-2" style="height: 94.8px;">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters" style="height: 61px;">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span style="color: var(--bs-danger);">EMPLOYEE NUMBER</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php echo $total_employees ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-user-cog fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>          <!-- total employee number -->

                    </div>      <!-- top row -->


                    <div class="row">

                        <div class="col-lg-7 col-xl-8">

                            <div class="card shadow mb-4" style="--bs-primary: #e86164;--bs-primary-rgb: 232,97,100;">

                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="text-primary fw-bold m-0" style="color: var(--bs-danger);">Sales Overview</h6>
                                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">

                                            <p class="text-center dropdown-header">hey , down here</p>
                                            <a class="dropdown-item" href="sales.php">&nbsp;Info </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">&nbsp;print </a>

                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="chart-area" style="--bs-primary: #d6353d;--bs-primary-rgb: 214,53,61;">
                                        <canvas data-bss-chart="{&quot;type&quot;:&quot;line&quot;,
                                                        &quot;data&quot;:{&quot;labels&quot;:[&quot;Jan&quot;,&quot;Feb&quot;,&quot;Mar&quot;,&quot;Apr&quot;,&quot;May&quot;,&quot;Jun&quot;,&quot;Jul&quot;,&quot;Aug&quot;,&quot;Sep&quot;,&quot;Oct&quot;,&quot;Nov&quot;,&quot;Dec&quot;],
                                                        &quot;datasets&quot;:[{&quot;label&quot;:&quot;Earnings&quot;,&quot;fill&quot;:true,&quot;data&quot;:[&quot;<?php echo $cars_sold_jan?>&quot;,&quot;<?php echo $cars_sold_feb?>&quot;,&quot;<?php echo $cars_sold_mar?>&quot;,&quot;<?php echo $cars_sold_apr?>&quot;,&quot;<?php echo $cars_sold_may?>&quot;,&quot;<?php echo $cars_sold_jun?>&quot;,&quot;<?php echo $cars_sold_jul?>&quot;,&quot;<?php echo $cars_sold_aug?>&quot;,&quot;<?php echo $cars_sold_sep?>&quot;,&quot;<?php echo $cars_sold_oct?>&quot;,&quot;<?php echo $cars_sold_nov?>&quot;,&quot;<?php echo $cars_sold_dec?>&quot;],
                                                        &quot;backgroundColor&quot;:&quot;rgba(78, 115, 223, 0.05)&quot;,
                                                        &quot;borderColor&quot;:&quot;rgba(78, 115, 223, 1)&quot;}]},
                                                        &quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false,&quot;labels&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}},&quot;title&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;},&quot;scales&quot;:{&quot;xAxes&quot;:[{&quot;gridLines&quot;:{&quot;color&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;drawBorder&quot;:false,&quot;drawTicks&quot;:false,&quot;borderDash&quot;:[&quot;2&quot;],&quot;zeroLineBorderDash&quot;:[&quot;2&quot;],&quot;drawOnChartArea&quot;:false},&quot;ticks&quot;:{&quot;fontColor&quot;:&quot;#858796&quot;,&quot;fontStyle&quot;:&quot;normal&quot;,&quot;padding&quot;:20}}],&quot;yAxes&quot;:[{&quot;gridLines&quot;:{&quot;color&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;drawBorder&quot;:false,&quot;drawTicks&quot;:false,&quot;borderDash&quot;:[&quot;2&quot;],&quot;zeroLineBorderDash&quot;:[&quot;2&quot;]},&quot;ticks&quot;:{&quot;fontColor&quot;:&quot;#858796&quot;,&quot;fontStyle&quot;:&quot;normal&quot;,&quot;padding&quot;:20}}]}}}"></canvas>
                                    </div>
                                </div>       <!-- chart-area -->



                            </div>
                        </div>               <!-- chart buttons and area -->

                        <div class="col-lg-5 col-xl-4" style="margin: 0 0 20px;">
                            <div class="card shadow border-start-warning py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-warning fw-bold text-xs mb-1"><span style="color: var(--bs-danger);">Top demand Brand</span></div>
                                            <div class="text-dark fw-bold h5 mb-0"><span><?php echo $top_demand_vehicle_brand_name . ' (' . $top_demand_vehicle_model_name . ') '  ?></span></div>
                                        </div>
                                        <div class="col-auto"><i class="fas fa-fire-alt fa-2x text-gray-300"></i></div>
                                    </div>
                                </div>
                            </div>                <!-- top demand vehicle brand -->

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
                        </div>


                    </div>


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