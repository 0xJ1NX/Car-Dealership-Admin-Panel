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


<!--########################################## modal for add employee ##########################################-->
<div class="modal fade" role="dialog" tabindex="-1" id="modalPayment">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Add Payment</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>   <!-- header -->

            <div class="modal-body">

                <form class="needs-validation" novalidate action="Transactions/addTrans.php" method="post">

                    <!--- form with validation -->

                    <div class="form-group">
                        <label for="sale_id">Sale ID</label>
                        <select class="form-control" id="sale_id" name="sale_id" required>
                            <option value="" disabled selected>Select Sale ID</option>
                            <?php
                            $sql = "SELECT * FROM sales";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['sales_ID'] . '">' . $row['sales_ID'] . '</option>';
                            }

                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Please select a sale ID.
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="InputPhone">Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Amount" required>
                        <div class="invalid-feedback">
                            Please enter Payment Amount.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                    </div>   <!-- Amount -->

                    <div class="form-group">
                        <div class="dropdown-divider"></div>
                    </div>    <!-- divider -->

                    <button class="btn btn-primary" type="submit" name="addTrans"
                            style="background:linear-gradient(to right, #606c88, #3f4c6b) ">Add Payment
                    </button>

                </form>


                <script>       //validation for form

                    // disabling form submissions if there are invalid fields
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
                <li class="nav-item"><a class="nav-link" href="sales.php"><i class="fas fa-money-bill-wave"></i><span>sales</span></a></li>
                <li class="nav-item"><a class="nav-link active" href="transactions.php"><i class="fas fa-address-book"></i><span>Transactions</span></a></li>
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

            <h3 class="text-dark mb-1" style="margin-left: 25px;margin-top: 23px;margin-right: -1px;">Transactions</h3>
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
                    ?>
                    <?php
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

                    <!-- table for transacttioon -->

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
                                            data-bs-target="#modalPayment" data-bs-toggle="modal"><i
                                                class="fa fa-plus"></i>&nbsp;Add Payment
                                    </button>
                                </div>
                            </div>


                        </div>
                    </div>

                    <table id="transTable" class="display" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">sale ID</th>
                            <th class="text-center">amount</th>
                            <th class="text-center">date</th>
                            <th class="text-center">Action</th>

                        </tr>
                        </thead>

                        <?php
                        $query = "SELECT * FROM transactions";
                        $result = mysqli_query($conn, $query);
                        ?>

                        <tbody>

                        <?php
                        while ($row = mysqli_fetch_array($result)) {

                            $transID = $row['TransID'];
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $transID; ?></td>
                                <td class="text-center"><?php echo $row['sale_ID']; ?></td>
                                <td class="text-center"><?php echo $row['amount']; ?></td>
                                <td class="text-center"><?php echo $row['date_of_payment']; ?></td>
                                <td class="text-center">
                                    <a href='Transactions/deleteTrans.php?TransID=<?php echo $transID?>'><i class='fas fa-trash-alt' style='color: #d91e18'></i></a>
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
        $('#transTable').DataTable(
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