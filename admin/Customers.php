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
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Blank Page - Omar &amp; Jenin</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="../assets/css/Ludens---1-Index-Table-with-Search--Sort-Filters-v20.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
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
                    <li class="nav-item"><a class="nav-link" href="admin_dash.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="vehicles.php"><i class="fas fa-car"></i><span>Vehicles</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="employee.php"><i class="fas fa-user-cog"></i><span>Employee</span></a></li>
                    <li class="nav-item"><a class="nav-link active" href="Customers.php"><i class="fas fa-user-tag"></i><span>Customers</span></a><a class="nav-link" href="sales.php"><i class="fas fa-money-bill-wave"></i><span>sales</span></a><a class="nav-link" href="transactions.php"><i class="fas fa-address-book"></i><span>Transactions</span></a><a class="nav-link" href="reports.php"><i class="fas fa-book"></i><span>Reports</span></a><a class="nav-link" href="profile.php"><i class="fas fa-cog"></i><span>settings</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">


                <?php include 'includes/header.php'; ?>

                    <h3 class="text-dark mb-1">Customers</h3>
                    <div class="container-fluid" style="border-style: none;">
                        <div class="card" id="TableSorterCard">

                            <!-- table for employees -->

                            <!-- header -->
                            <div class="card-header text-end py-3" style="height: 61px;border-style: none;">

                                <!-- row for add button -->
                                <div class="row">

                                    <!-- space separate -->
                                    <div class="col-md-6"></div>

                                </div>
                            </div>

                            <table id="clientsTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">First Name</th>
                                        <th class="text-center">Last Name</th>
                                        <th class="text-center">Address</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Notes</th>
                                    </tr>
                                </thead>

                                <?php
                                $query = "SELECT * FROM clients";
                                $result = mysqli_query($conn, $query);
                                ?>

                                <tbody>

                                <?php
                                while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $row['ClientID']; ?></td>
                                        <td class="text-center"><?php echo $row['FirstName']; ?></td>
                                        <td class="text-center"><?php echo $row['LastName']; ?></td>
                                        <td class="text-center"><?php echo $row['Address']; ?></td>
                                        <td class="text-center"><?php echo $row['Phone']; ?></td>
                                        <td class="text-center"><?php echo $row['Email']; ?></td>
                                        <td class="text-center"><?php echo $row['Notes']; ?></td>
                                    </tr>

                                    <?php
                                }
                                ?>

                                </tbody>


                            </table>

                            <!-- end of table for employees -->


                        </div>


                    <div/>

                <div class="container-fluid">





                </div>
            </div>

        </div>
            <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i>
            </a>
        </div>

        <footer class="bg-white sticky-footer">
            <div class="container my-auto">
                <div class="text-center my-auto copyright"><span>Copyright © Omar &amp; Jenin 2022</span></div>
            </div>
        </footer>
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
        <script type="text/javascript"
                src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>



        <script>
        $(document).ready(function() {
            $('#clientsTable').DataTable(
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
    </script>
</body>

</html>