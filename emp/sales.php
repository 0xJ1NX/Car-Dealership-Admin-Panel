<?php
include '../helper/db_con.php';
session_start();

if (!isset($_SESSION['UserID']) || $_SESSION['isAdmin'] != 0) {
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


<!--########################################## modal for add sale ##########################################-->
<div class="modal fade" role="dialog" tabindex="-1" id="modalSellCar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Add Employee</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>   <!-- header -->

            <div class="modal-body">

                <form class="needs-validation" novalidate action="sales/addSale.php" method="post">

                    <!--- form with validation -->


                    <div class="form-group">
                        <label for="InputPhone">Client ID </label>
                        <input type="number" name="idNum" class="form-control" placeholder="Client ID" required>
                        <div class="invalid-feedback">
                            Please enter ID.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                    </div>   <!-- ID NUMBER -->

                    <div class="form-group">

                        <label for="InputFirstName">First Name</label>

                        <input type="text" name="fName" class="form-control" placeholder="First Name" required
                               onkeydown="return /[a-z]/i.test(event.key)">

                        <div class="invalid-feedback">
                            Please enter First Name.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                    </div>   <!-- FirstName -->

                    <div class="form-group">

                        <label for="InputLastName">Last Name</label>
                        <input type="text" name="lName" class="form-control" placeholder="Last Name" required
                               onkeydown="return /[a-z]/i.test(event.key)">

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                        <div class="invalid-feedback">
                            Please enter Last Name.
                        </div>

                    </div>  <!-- LastName -->

                    <div class="form-group">

                        <label for="InputFirstName">Address</label>

                        <input type="text" name="address" class="form-control" placeholder="Address" required
                               onkeydown="return /[a-z]/i.test(event.key)">

                        <div class="invalid-feedback">
                            Please enter First Name.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                    </div>   <!-- Address -->

                    <div class="form-group">
                        <label for="InputPhone">Phone Number</label>
                        <input type="number" name="phone" class="form-control" placeholder="Phone Number" required>

                        <div class="invalid-feedback">
                            enter phone number.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                    </div>   <!-- phone number-->

                    <div class="form-group">

                        <label for="Email">Email address</label>
                        <input type="email" class="form-control" name="email" id="emailClient"
                               aria-describedby="emailHelp" placeholder="email" required>


                        <div class="invalid-feedback">
                            Please enter email address.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>   <!-- Email -->

                    <div class="form-group">
                        <label for="InputNotes">Notes</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="notes About Client"
                                  required></textarea>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                        <div class="invalid-feedback">
                            Please enter notes.
                        </div>

                    </div>    <!-- Notes -->

                    <div class="form-group">

                        <label for="InputCar">Car ID</label>
                        <select class="form-control" name="carId" id="carId" required>
                            <option value="">Select Car ID</option>
                            <?php
                            //select non sold cars by joining car and sale tables
                            $sql = "SELECT * FROM vehicles WHERE vehicles.VehicleID NOT IN (SELECT VehicleID FROM sales)";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['VehicleID'] . '">' . $row['VehicleID'] . '</option>';
                            }
                            ?>
                        </select>


                    </div>   <!--  Car ID NUMBER -->

                    <div class="form-group">
                        <label for="paymentMethode">paymentMethode</label>
                        <select class="form-control" name="paymentMethode" required>
                            <option value="" selected>Select payment methode</option>
                            <?php
                            $sql = "SELECT * FROM payment_methods";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['pm_id'] . '">' . $row['Name']. " --> " . $row['First_Amount_Percent'] ."%  ". $row['Percent_Per_Month']. "%  ". '</option>';
                            }
                            ?>

                        </select>

                        <div class="invalid-feedback">
                            Please enter payment methode.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                    </div>    <!-- paymentMethode -->

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" name="finalPrice" class="form-control" placeholder="Final Price" required>

                        <div class="invalid-feedback">
                            Please enter Final Price.

                        </div>

                        <div class="valid-feedback">
                            Looks good!

                        </div>

                    </div>    <!-- finalPrice -->




                    <div class="form-group">
                        <div class="dropdown-divider"></div>
                    </div>    <!-- divider -->

                    <button class="btn btn-primary" type="submit" name="sellCar"
                            style="background:linear-gradient(to right, #606c88, #3f4c6b) ">Sell
                    </button>

                </form>


                <script>       //to show the salary and bonus fields or hide them


                    // Example starter JavaScript for disabling form submissions if there are invalid fields
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
               href="emp_dash.php">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-car-side"></i></div>
                <div class="sidebar-brand-text mx-3"><span>Car dealer</span></div>
            </a>
            <hr class="sidebar-divider my-0">

            <ul class="navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item"><a class="nav-link " href="emp_dash.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li class="nav-item"><a class="nav-link " href="vehicles.php"><i class="fas fa-car"></i><span>Vehicles</span></a></li >
                <li class="nav-item"><a class="nav-link active" href="sales.php"><i class="fas fa-money-bill-wave"></i><span>sales</span></a></li>
                <li class="nav-item"><a class="nav-link " href="transactions.php"><i class="fas fa-address-book"></i><span>Transactions</span></a></li>
                <li class="nav-item"><a class="nav-link" href="profile.php"><i class="fas fa-cog"></i><span>settings</span></a></li>
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

            <h3 class="text-dark mb-1" style="margin-left: 25px;margin-top: 23px;margin-right: -1px;">Sales</h3>
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


                    <!-- table for employees -->

                    <!-- header -->
                    <div class="card-header text-end py-3" style="height: 61px;border-style: none;">

                        <!-- row for add button -->
                        <div class="row">

                            <!-- space separate -->
                            <div class="col-md-6"></div>

                            <!-- add button to make a sell -->
                            <div class="col-md-6">
                                <div class="text-end">
                                    <button class="btn btn-primary" type="button"
                                            style="background: linear-gradient(to right, #606c88, #3f4c6b);"
                                            data-bs-target="#modalSellCar" data-bs-toggle="modal"><i
                                                class="fa fa-plus"></i>&nbsp;Sell A Car
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <table id="employeeTable" class="display" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Client ID</th>
                            <th class="text-center">Vehicle ID</th>
                            <th class="text-center">empID</th>
                            <th class="text-center">Payment details</th>
                            <th class="text-center">date</th>
                            <th class="text-center">price</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>

                        <?php
                        $query = "SELECT * FROM sales";
                        $result = mysqli_query($conn, $query);
                        ?>

                        <tbody>

                        <?php
                        while ($row = mysqli_fetch_array($result)) {

                            $id = $row['sales_ID'];

                            ?>
                            <tr>

                                <td class="text-center"><?php echo $id; ?></td>
                                <td class="text-center"><?php echo $row['Client_ID']; ?></td>
                                <td class="text-center"><?php echo $row['Vehicle_ID']; ?></td>
                                <td class="text-center"><?php echo $row['emp_id']; ?></td>

                                <?php

                                $pm_id =$row['pm_id'];
                                $query2 = "SELECT * FROM payment_methods WHERE pm_id = '$pm_id'";
                                $result2 = mysqli_query($conn, $query2);
                                $row2 = mysqli_fetch_array($result2);
                                echo "<td class='text-center'>".$row2['Name']. " -> ". $row2['First_Amount_Percent'] ."%  ". $row2['Percent_Per_Month'] . "% ". "</td>";

                                ?>

                                <td class="text-center"><?php echo $row['date_of_purchase']; ?></td>
                                <td class="text-center"><?php echo $row['final_price']; ?></td>

                                <?php
                                //check if the sum of  money in transaction table of the same id is equal to the final price
                                $query2 = "SELECT SUM(amount) AS total FROM transactions WHERE sale_ID = '$id'";
                                $result2 = mysqli_query($conn, $query2);
                                $row2 = mysqli_fetch_array($result2);
                                $total = $row2['total'];
                                if ($total >= $row['final_price']) {
                                    ?>
                                    <td class="text-center"><a class=" btn-sm btn-success "  > <?php echo "Paid"; ?></a></td>
                                <?php } else { ?>
                                    <td class="text-center"><a class="btn-sm btn-danger" > <?php echo "Not Paid"; ?></a> </td>
                                <?php } ?>

                                <td class="text-center">
                                    <a href='sales/deleteSale.php?saleID=<?php echo $id?>'><i class='fas fa-trash-alt' style='color: #d91e18'></i></a>
                                </td>

                            </tr>


                            <?php
                        }
                        ?>

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


<script>
    $(document).ready(function () {
        $('#employeeTable').DataTable(
            {

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