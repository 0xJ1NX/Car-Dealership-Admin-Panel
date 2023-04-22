<?php


session_start();
include_once '../../helper/db_con.php';

if(!isset($_SESSION['UserID'])  || $_SESSION['isAdmin'] != 1 ){
    session_destroy();
    header("Location: ../login.php");
    exit;
}

$CarId = -1;
if (isset($_GET['vID'])) {

    $CarId = $_GET['vID'];

}

if (isset($_POST['addExpense'])) {

    $CarId = $_POST['vID'];

    $description = trim($_POST['Description']);
    $amount = trim($_POST['Amount']);
    $notes = trim($_POST['notes']);


    $sql = "INSERT INTO expenses (VehicleID, Description, Amount, Notes, Date) VALUES ($CarId, '$description', '$amount', '$notes', NOW())";
    if (mysqli_query($conn, $sql)) {
        header("Location: ../vehicles.php?success=Expense added successfully");
    }
    else {
        $error = mysqli_error($conn);
        header("Location: ../vehicles.php?error='$error' . '$CarId'");
    }
    exit();


}


?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Edit Employee</title>
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
                    <h4 class="text-center">Add Expense</h4>
                </div>
                <div class="card-body">

                    <form class="needs-validation" novalidate action="expenseVehicles.php" method="post">

                        <!--- form with validation -->

                        <div class="form-group">
                            <label for="inputCarId">Vehicle ID</label>
                            <input type="number" name="vID" class="form-control" value="<?php echo $CarId ?>" readonly>
                        </div>   <!-- ID vehicle -->


                        <div class="form-group">


                            <label for="inputDescription">Description</label>

                            <input type="text" name="Description" class="form-control" placeholder="Description" required
                                   onkeydown="return /[a-z]/i.test(event.key)">

                            <div class="invalid-feedback">
                                Please enter Description.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Description -->


                        <div class="form-group">
                            <label for="Amount">Amount</label>
                            <input type="number" name="Amount" class="form-control"
                                   placeholder="Amount" required>
                            <div class="invalid-feedback">
                                Please enter Amount.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Amount -->



                        <div class="form-group">
                            <label for="InputNotes">Notes</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="Notes"
                                      required></textarea>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                            <div class="invalid-feedback">
                                Please enter notes.
                            </div>

                        </div>    <!-- Notes -->



                        <div class="form-group">
                            <div class="dropdown-divider"></div>
                        </div>    <!-- divider -->

                        <button class="btn btn-primary" type="submit" name="addExpense"
                                style="background:linear-gradient(to right, #606c88, #3f4c6b) ">Add Expense
                        </button>

                        <a href="../vehicles.php" class="btn btn-primary">Back</a>

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


</body>


