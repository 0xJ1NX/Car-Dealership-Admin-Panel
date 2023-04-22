<?php

session_start();
include_once '../../helper/db_con.php';

if(!isset($_SESSION['UserID'])  || $_SESSION['isAdmin'] != 0 ){
    session_destroy();
    header("Location: ../login.php");
    exit;
}

$CarId = -1;
if (isset($_GET['vID'])) {
$CarId = $_GET['vID'];
}

if (isset($_GET['deleteID'])) {

    $deleteID = $_GET['deleteID'];
    $sql = "DELETE FROM expenses WHERE ExpenseID = $deleteID";
    $result = $conn->query($sql);
    if ($result) {
        header("Location: ../vehicles.php?success= Expense Deleted");
    } else {
        header("Location: ../vehicles.php?error=expense Not Deleted");
    }
    exit;


}

?>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Expenses View</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome-all.min.css">
    <link rel="stylesheet" href="../../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.css"/>

</head>


<body id="page-top">

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg">
                <div class="card-header">
                    <h4 class="text-center">Vehicle Expenses</h4>
                </div>
                <div class="card-body">

                    <table id="expT" class="display" >

                        <thead>
                            <tr>
                                <th class="text-center">Expense ID</th>
                                <th class="text-center">Vehicles ID</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Notes</th>
                                <th class="text-center">Actions</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $sql = "SELECT * FROM expenses WHERE VehicleId = '$CarId'";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td class='text-center'>" . $row["ExpenseID"] . "</td>";
                                    echo "<td class='text-center'>" . $row["VehicleID"] . "</td>";
                                    echo "<td class='text-center'>" . $row["Date"] . "</td>";
                                    echo "<td class='text-center'>" . $row["Description"] . "</td>";
                                    echo "<td class='text-center'>" . $row["Amount"] . "</td>";
                                    echo "<td class='text-center'>" . $row["Notes"] . "</td>";
                                    echo "<td class='text-center'>
                                            <a href='expensesView.php?deleteID=" . $row["ExpenseID"] . "'><i class='fas fa-trash-alt' style='color: #d91e18' ></i></a>
                                        </td>";
                                    echo "<tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>









    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="../../assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="../../assets/js/theme.js"></script>
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
    $(document).ready(function () {
        $('#expT').DataTable(
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





