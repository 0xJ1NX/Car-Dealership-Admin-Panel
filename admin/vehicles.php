<?php
include '../helper/db_con.php';
session_start();

if (!isset($_SESSION['UserID']) || $_SESSION['isAdmin'] != 1) {
    session_destroy();
    header("Location: ../login.php");
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Table - Omar &amp; Jenin</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>


</head>


<body id="page-top">


<!--########################################## modal for add CAR ##########################################-->
<div class="modal fade" role="dialog" tabindex="-1" id="modalAddVehicle">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Add Vehicles</h4>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>   <!-- header -->

            <div class="modal-body">

                <form class="needs-validation " novalidate  action="vehicles/add_vehicels_admin.php" method="post">

                    <!--- form with validation -->

                    <!-- Vehicle Brand-->
                    <div class="form-group">
                        <label for="vehicleBrand">Vehicle Brand</label>
                        <input type="text" class="form-control" id="vehicleBrand" name="vehicleBrand" placeholder="Vehicle Brand " required>

                        <div class="invalid-feedback">
                            Vehicle Brand
                        </div>

                    </div>


                    <!-- Vehicle Model-->
                    <div class="form-group">
                        <label for="vehicleModel">Vehicle Model</label>
                        <input type="text" class="form-control" id="vehicleModel" name="vehicleModel" placeholder="Vehicle Model " required>

                        <div class="invalid-feedback">
                            Vehicle Model
                        </div>

                    </div>


                    <!-- vehicle Type new or used -->
                    <div class="form-group">
                        <label for="vehicleType">Vehicle Type</label>
                        <select class="form-control" id="vehicleType" name="vehicleType" required>
                            <option value="" disabled selected>Vehicle Type</option>
                            <option value="new">New</option>
                            <option value="used">Used</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a vehicle type.
                        </div>
                    </div>

                    <!-- vehicle transmission automatic or manual-->
                    <div class="form-group">
                        <label for="vehicleTransmission">Vehicle Transmission</label>
                        <select class="form-control" id="vehicleTransmission" name="vehicleTransmission" required>
                            <option value="" disabled selected>Vehicle Transmission</option>
                            <option value="automatic">Automatic</option>
                            <option value="Manual">Manual</option>
                        </select>
                        <div class="invalid-feedback">
                            Please select a vehicle transmission.
                        </div>
                    </div>

                    <!-- year of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleYear">Vehicle Year</label>
                        <input type="number" class="form-control" id="vehicleYear" name="vehicleYear" placeholder="Vehicle Year" required>
                        <div class="invalid-feedback">
                            vehicle year.
                        </div>
                    </div>

                    <!-- enter the key number of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleKey">Vehicle Key</label>
                        <input type="number" class="form-control" id="vehicleKey" name="vehicleKey" placeholder="Vehicle Key" required>
                        <div class="invalid-feedback">
                            vehicle key.
                        </div>
                    </div>


                    <!-- enter the KM of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleKM">Vehicle KM</label>
                        <input type="number" class="form-control" id="vehicleKM" name="vehicleKM" placeholder="Vehicle KM" required>
                        <div class="invalid-feedback">
                            vehicle KM.
                        </div>
                    </div>

                    <!-- enter the FuelType of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleFuelType">Vehicle Fuel Type</label>
                        <input type="text" class="form-control" id="vehicleFuelType" name="vehicleFuelType" placeholder="Fuel Type" required>
                        <div class="invalid-feedback">
                            fuel type.
                        </div>
                    </div>

                    <!-- enter the motor cc of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleMotorCC">Vehicle Motor CC</label>
                        <input type="number" class="form-control" id="vehicleMotorCC" name="vehicleMotorCC" placeholder="Motor CC" required>
                        <div class="invalid-feedback">
                            motor cc.
                        </div>
                    </div>

                    <!-- enter the color of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleColor">Vehicle Color</label>
                        <input type="text" class="form-control" id="vehicleColor" name="vehicleColor" placeholder="Color" required>
                        <div class="invalid-feedback">
                            vehicle color.
                        </div>
                    </div>

                    <!-- enter the chassis of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleChassis">Vehicle Chassis</label>
                        <input type="text" class="form-control" id="vehicleChassis" name="vehicleChassis" placeholder="Chassis" required>
                        <div class="invalid-feedback">
                            vehicle chassis.
                        </div>
                    </div>

                    <!-- enter the waranty of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleWaranty">Vehicle Waranty</label>
                        <input type="number" class="form-control" id="vehicleWaranty" name="vehicleWaranty" placeholder="Waranty" required>
                        <div class="invalid-feedback">
                            vehicle waranty.
                        </div>
                    </div>

                    <!-- enter the buying price of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleBuyingPrice">Vehicle Buying Price</label>
                        <input type="number" class="form-control" id="vehicleBuyingPrice" name="vehicleBuyingPrice" placeholder="Buying Price" required>
                        <div class="invalid-feedback">
                            buying price.
                        </div>
                    </div>

                    <!-- enter the export price of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleExportPrice">Vehicle Export Price</label>
                        <input type="number" class="form-control" id="vehicleExportPrice" name="vehicleExportPrice" placeholder="Export Price" required>
                        <div class="invalid-feedback">
                            export price.
                        </div>
                    </div>


                    <!-- enter the selling price of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleSellingPrice">Vehicle Selling Price</label>
                        <input type="number" class="form-control" id="vehicleSellingPrice" name="vehicleSellingPrice" placeholder="Selling Price" required>
                        <div class="invalid-feedback">
                            selling price.
                        </div>
                    </div>

                    <!-- enter the description of the vehicle-->
                    <div class="form-group">
                        <label for="vehicleDescription">Vehicle Description</label>
                        <textarea class="form-control" id="vehicleDescription" name="vehicleDescription" rows="3" placeholder="Description" required></textarea>
                        <div class="invalid-feedback">
                            vehicle description.
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="dropdown-divider"></div>
                    </div>    <!-- divider -->

                    <button class="btn btn-primary" type="submit" name="addVehicles" style="background:linear-gradient(to right, #606c88, #3f4c6b) ">Add Vehicle</button>

                </form>


                <script>

                    //  JavaScript for disabling form submissions if there are invalid fields
                    (function () {
                        'use strict';
                        window.addEventListener('load', function () {
                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            var forms = document.getElementsByClassName('needs-validation');
                            // Loop over them and prevent submission
                            var validation = Array.prototype.filter.call(forms, function (form) {
                                form.addEventListener('submit', function (event) {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        }, false);
                    })();
                </script>


            </div>

        </div>
    </div>
</div>
<!--############################################################################################################-->




<div id="wrapper">

    <!-- Sidebar -->
    <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0"
         style="background: linear-gradient(to left, #cb2d3e, #ef473a);">
        <div class="container-fluid d-flex flex-column p-0">
            <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0"
               href="admin_dash.php">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-car-side"></i></div>
                <div class="sidebar-brand-text mx-3"><span>Car dealer</span></div>
            </a>
            <hr class="sidebar-divider my-0">

            <ul class="navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item"><a class="nav-link" href="admin_dash.php"><i
                                class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li class="nav-item"><a class="nav-link active" href="vehicles.php"><i class="fas fa-car"></i><span>Vehicles</span></a></li>
                <li class="nav-item"><a class="nav-link " href="employee.php"><i
                                class="fas fa-user-cog"></i><span>Employee</span></a></li>
                <li class="nav-item"><a class="nav-link" href="Customers.php"><i class="fas fa-user-tag"></i><span>Customers</span></a>
                    <a class="nav-link " href="sales.php"><i class="fas fa-money-bill-wave"></i><span>sales</span></a>
                    <a class="nav-link" href="transactions.php"><i
                                class="fas fa-address-book"></i><span>Transactions</span></a>
                    <a class="nav-link" href="reports.php"><i class="fas fa-book"></i><span>Reports</span></a>
                    <a class="nav-link" href="profile.php"><i class="fas fa-cog"></i><span>settings</span></a></li>
            </ul>


            <div class="text-center d-none d-md-inline">
                <button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button>
            </div>

        </div>

    </nav>
    <!-- End of Sidebar -->


    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">

            <?php include 'includes/header.php'; ?>

            <h3 class="text-dark mb-1" style="margin-left: 25px;margin-top: 23px;margin-right: -1px;">Vehicles</h3>
            <div class="container-fluid" style="border-style: none;">
                <div class="card" id="TableSorterCard">

                    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

                    <?php
                    if (isset($_GET['error'])) {
                        $error = $_GET['error'];
                        ?>
                        <script>
                            swal({
                                title: "Error",
                                text: "<?php echo  $error; ?>",
                                icon: "error",
                                button: "OK",
                            });
                        </script>
                        <?php
                    }
                    if (isset($_GET['success'])) {
                        $success = $_GET['success'];
                        ?>
                        <script>
                            swal({
                                title: "Success",
                                text: "<?php echo  $success; ?>",
                                icon: "success",
                                button: "OK",
                            });
                        </script>
                        <?php
                    }
                    ?>



                    <!-- header -->
                    <div class="card-header text-end py-3" style="height: 61px;border-style: none;">

                        <!-- row for add button -->
                        <div class="row">

                            <!-- space separate -->
                            <div class="col-md-6"></div>

                            <!-- add button -->
                                <div class="col-md-6">
                                    <div class="text-end">
                                        <button class="btn btn-primary" type="button"
                                                style="background: linear-gradient(to right, #606c88, #3f4c6b);"
                                                data-bs-target="#modalAddVehicle" data-bs-toggle="modal"><i
                                                    class="fa fa-plus"></i>&nbsp;Add Vehicles
                                        </button>
                                    </div>
                                </div>


                        </div>
                    </div>

                    <table id="employeeTable" class="display" style="width: 100%" >
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Model</th>
                            <th class="text-center">Transmission</th>
                            <th class="text-center">Year</th>
                            <th class="text-center">KM</th>
                            <th class="text-center">Fuel</th>
                            <th class="text-center">Color</th>
                            <th class="text-center">CC</th>
                            <th class="text-center">Warranty</th>
                            <th class="text-center">Buying_Price</th>
                            <th class="text-center">Export_Price</th>
                            <th class="text-center">Selling_Price</th>
                            <th class="text-center">Features</th>
                            <th class="text-center">status</th>
                            <th class="text-center">Action</th>

                        </tr>
                        </thead>

                        <?php
                        $query = "SELECT * FROM vehicles";
                        $result = mysqli_query($conn, $query);
                        ?>

                        <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {

                            $id = $row['VehicleID'];

                            ?>
                            <tr >
                                <td class="text-center"><?php echo $id; ?></td>
                                <td class="text-center"><?php echo $row['Type']; ?></td>
                                <?php
                                $query2 = "SELECT brands.Name,models.Name FROM models inner JOIN brands on models.BrandID = brands.BrandID WHERE models.ModelID = '".$row['ModelID']."'";
                                $result2 = mysqli_query($conn, $query2);
                                $row2 = mysqli_fetch_array($result2);
                                $brandName = $row2[0];
                                $modelName = $row2[1];
                                ?>
                                <td class="text-center"><?php echo $brandName." ".$modelName; ?></td>
                                <td class="text-center"><?php echo $row['Transmission']; ?></td>
                                <td class="text-center"><?php echo $row['Year']; ?></td>
                                <td class="text-center"><?php echo $row['KM']; ?></td>
                                <td class="text-center"><?php echo $row['Fuel']; ?></td>
                                <td class="text-center"><?php echo $row['Color']; ?></td>
                                <td class="text-center"><?php echo $row['CC']; ?></td>
                                <td class="text-center"><?php echo $row['Warranty']; ?></td>
                                <td class="text-center"><?php echo $row['Buying_Price']; ?></td>
                                <td class="text-center"><?php echo $row['Export_Price']; ?></td>
                                <td class="text-center"><?php echo $row['Selling_Price']; ?></td>
                                <td class="text-center"><?php echo $row['Features']; ?></td>

                                <?php
                                    //see if the vehicle is sold or not by joining the sales table and the vehicles table
                                    $query2 = "SELECT * FROM sales inner join vehicles on sales.Vehicle_ID = vehicles.VehicleID where vehicles.VehicleID = '".$row['VehicleID']."'";
                                    $result2 = mysqli_query($conn, $query2);
                                    if (mysqli_num_rows($result2) > 0) {
                                        ?>
                                        <td class="text-center"><a class="btn-sm btn-danger" > <?php echo "Sold"; ?></a> </td>
                                        <?php
                                    } else {
                                        ?>
                                        <td class="text-center"><a class=" btn-sm btn-success "  > <?php echo "Available"; ?></a> </td>
                                        <?php
                                    }
                                ?>

                                <td class='text-center'>
                                    <!-- row for edit and delete button -->
                                    <div class="col">

                                        <a href='vehicles/expenseVehicles.php?vID=<?php echo $id ?>' style= " color:#6e707e  ; margin: 5px"  ><i class='fas fa-car-crash'></i></a>
                                        <a href='vehicles/editVehicles.php?vID=<?php echo $id ?>' ><i class='fas fa-edit ' style="margin: 5px" ></i></a>
                                        <a href='vehicles/expensesView.php?vID=<?php echo $id ?>' ><i class='fas fa-file-text'  style="margin: 5px ; color: #cb2d3e"></i></a>
                                        <a href='vehicles/deleteVehicles.php?vID=<?php echo $id ?>' style="margin: 5px"><i class='fas fa-trash-alt' style='color:#be2617  ' ></i></a>

                                    </div>
                                </td>



                            </tr>


                            <?php
                        } ?>

                        </tbody>


                    </table>

                    <!-- end of table for employees -->


                </div>
            </div>
        </div>


        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © Omar &amp; Jenin 2022</span></div>
            </div>
        </footer>



    </div>

    <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>


</div>


<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/js/bs-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="../assets/js/theme.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-1.10.16/r-2.2.1/datatables.min.js"></script>



<script>
    $(document).ready(function () {
        $('#employeeTable').DataTable(
            {

                scrollX: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        text: '<i class="fa fa-print" style="color:#1c1c21 "></i>',
                        titleAttr: 'Print',
                        className: 'btn btn-sm btn-rounded ',

                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel" style="color: #107c10"></i>',
                        titleAttr: 'Excel',
                        className: 'btn btn-sm btn-rounded'

                    },
                    {
                        extend: 'csv',
                        text: '<i class="fa fa-file-text" style="color: #224abe"></i>',
                        titleAttr: 'CSV',
                        className: 'btn btn-sm btn-rounded'
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf" style="color: #cb2d3e"></i>',
                        titleAttr: 'PDF',
                        className: 'btn btn-sm btn-rounded'
                    }
                ]

            }


        );


    });
</script>        <!-- pdf csv print Buttons in the table -->








</body>


</html>