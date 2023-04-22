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


<!--########################################## modal for add employee ##########################################-->
<div class="modal fade" role="dialog" tabindex="-1" id="modalAddEmployee">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Add Employee</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>   <!-- header -->

            <div class="modal-body">

                <form class="needs-validation" novalidate action="employee/add_employee_admin.php" method="post">

                    <!--- form with validation -->

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
                        <label for="InputPhone">ID Number</label>
                        <input type="number" name="idNum" class="form-control" placeholder="employee ID" required>
                        <div class="invalid-feedback">
                            Please enter ID.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                    </div>   <!-- ID NUMBER -->


                    <div class="form-group">
                        <label for="InputPhone">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" placeholder="Date of Birth" required>

                        <div class="invalid-feedback">
                            Please enter Date of Birth.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                    </div>   <!--- date of birth -->

                    <div class="form-group">

                        <label for="Email">Email address</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1"
                               aria-describedby="emailHelp" placeholder="email" required>
                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                            else.</small>

                        <div class="invalid-feedback">
                            Please enter email address.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>   <!-- Email -->

                    <div class="form-group">
                        <label for="InputPhone">Phone Number</label>
                        <input type="number" name="phone" class="form-control" placeholder="Phone Number" required>
                        <div class="invalid-feedback">
                            Please enter phone number.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                    </div>   <!-- Phone -->

                    <div class="form-group">
                        <label for="InputAddress">Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Address" required>
                        <div class="invalid-feedback">
                            Please enter address.
                        </div>

                        <div class="valid-feedback">
                            Looks good!

                        </div>

                    </div>    <!-- Address -->

                    <div class="form-group">
                        <label for="InputNotes">Notes</label>
                        <textarea class="form-control" name="notes" rows="3" placeholder="What this employee do"
                                  ></textarea>

                        <div class="valid-feedback">
                            Looks good!
                        </div>

                        <div class="invalid-feedback">
                            Please enter notes.
                        </div>

                    </div>    <!-- Notes -->

                    <div class="form-group">
                        <label for="InputEmployeeType">Employee Type</label>
                        <select class="form-select" name="employeeType" id="selectEmployee" required>

                            <option value="" disabled selected>Select Employee Type</option>
                            <option value="0">Admin</option>
                            <option value="1">Salesperson</option>
                            <option value="2">Other Emp</option>

                        </select>
                    </div>     <!-- Employee Type -->

                    <div class="form-group" id="salaryField" style="display: none">
                        <label for="InputSalary">Salary</label>
                        <input type="number" name="salary" class="form-control" placeholder="Salary (empty = 0 )">
                        <div class="invalid-feedback">
                            Please enter salary.
                        </div>

                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>    <!-- Salary -->

                    <div class="form-group" id="bonusField" style="display: none">
                        <label for="InputBonus">Bonus</label>
                        <input type="number" name="bonus" class="form-control" placeholder="Bonus ( empty = 0 )">
                        <div class="invalid-feedback">
                            Please enter bonus or 0 for None.
                        </div>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>    <!-- Bonus -->

                    <div class="form-group">
                        <div class="dropdown-divider"></div>
                    </div>    <!-- divider -->

                    <button class="btn btn-primary" type="submit" name="addEmployee"
                            style="background:linear-gradient(to right, #606c88, #3f4c6b) ">Add Employee
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
               href="admin_dash.php">
                <div class="sidebar-brand-icon rotate-n-15"><i class="fas fa-car-side"></i></div>
                <div class="sidebar-brand-text mx-3"><span>Car dealer</span></div>
            </a>
            <hr class="sidebar-divider my-0">

            <ul class="navbar-nav text-light" id="accordionSidebar">
                <li class="nav-item"><a class="nav-link" href="admin_dash.php"><i
                                class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li class="nav-item"><a class="nav-link" href="vehicles.php"><i
                                class="fas fa-car"></i><span>Vehicles</span></a></li>
                <li class="nav-item"><a class="nav-link active" href="employee.php"><i
                                class="fas fa-user-cog"></i><span>Employee</span></a></li>
                <li class="nav-item"><a class="nav-link" href="Customers.php"><i class="fas fa-user-tag"></i><span>Customers</span></a>
                    <a class="nav-link" href="sales.php"><i class="fas fa-money-bill-wave"></i><span>sales</span></a>
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

            <h3 class="text-dark mb-1" style="margin-left: 25px;margin-top: 23px;margin-right: -1px;">Employees</h3>
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

                            <!-- Button for adding new employee -->
                            <div class="col-md-6">
                                <div class="text-end">
                                    <button class="btn btn-primary" type="button"
                                            style="background: linear-gradient(to right, #606c88, #3f4c6b);"
                                            data-bs-target="#modalAddEmployee" data-bs-toggle="modal"><i
                                                class="fa fa-plus"></i>&nbsp;Add Employee
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                    <table id="employeeTable" class="display" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">First Name</th>
                            <th class="text-center">Last Name</th>
                            <th class="text-center">Age</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Phone</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Position</th>
                            <th class="text-center">Notes</th>
                            <th class="text-center">Salary</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>

                        <?php
                        $query = "SELECT * FROM employee";
                        $result = mysqli_query($conn, $query);
                        ?>

                        <tbody>

                        <?php
                        while ($row = mysqli_fetch_array($result)) {

                            //calculate age
                            $dob = $row['dob'];
                            try {
                                $dob = new DateTime($dob);
                                $now = new DateTime();
                                $interval = $now->diff($dob);
                                $age = $interval->y;
                            } catch (Exception $e) {
                                $age = "";
                            }

                            ?>
                            <tr>


                                <?php

                                $EmpID = $row['EmpID'];
                                $query_emp = "SELECT * FROM sales_employee WHERE EmpID = '$EmpID'";
                                $result_emp = mysqli_query($conn, $query_emp);
                                $emp_type = "Admin";
                                $salary = "--";
                                if (mysqli_num_rows($result_emp) > 0) {
                                    $result_emp = mysqli_fetch_array($result_emp);
                                    $emp_type = "Sales Employee";
                                    $salary = $result_emp['salary'];
                                    $bonus = $result_emp['Bonus_Per_Sale'];
                                }

                                $query_emp = "SELECT * FROM other_emp WHERE EmpID = '$EmpID'";
                                $result_emp = mysqli_query($conn, $query_emp);
                                if (mysqli_num_rows($result_emp) > 0) {
                                    $result_emp = mysqli_fetch_array($result_emp);
                                    $emp_type = "Other Employee";
                                    $salary = $result_emp['salary'];
                                }
                                ?>
                                <td class="text-center"><?php echo $EmpID; ?></td>
                                <td class="text-center"><?php echo $row['FirstName']; ?></td>
                                <td class="text-center"><?php echo $row['LastName']; ?></td>
                                <td class="text-center"><?php echo $age; ?></td>
                                <td class="text-center"><?php echo $row['Address']; ?></td>
                                <td class="text-center"><?php echo $row['Phone']; ?></td>
                                <td class="text-center"><?php echo $row['Email']; ?></td>
                                <td class="text-center"><?php echo $emp_type; ?></td>
                                <td class="text-center"><?php echo $row['Notes']; ?></td>
                                <td class="text-center"><?php echo $salary; ?></td>


                                <?php

                                $query_user = "SELECT * FROM users WHERE EmpID = '$EmpID'";
                                $result_user = mysqli_query($conn, $query_user);
                                if (mysqli_num_rows($result_user) > 0) {
                                    $result_user = mysqli_fetch_array($result_user);
                                    $user_id = $result_user['UserID'];
                                } else {
                                    $user_id = "-1";
                                }


                                if ($_SESSION['UserID'] == $user_id) {
                                    echo "<td class='text-center'>";
                                    echo " This Is You ";
                                    //smily face
                                    echo "<i class='fas fa-smile'></i>";

                                    echo "</td>";

                                } else {
                                    echo "<td class='text-center'>
                                               <a href='employee/editEmployee.php?EmpID=$EmpID'><i class='fas fa-edit ' ></i></a>
                                               <a href='employee/deleteEmp.php?EmpID=$EmpID'><i class='fas fa-trash-alt' style='color: #d91e18' ></i></a>                                         
                                          </td>";
                                }
                                ?>
                            </tr>
                  <?php } ?>


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
        $('#selectEmployee').on('change', function () {
            if (this.value === '1') {
                $("#salaryField").show();
                $("#bonusField").show();
            } else if (this.value === '2') {
                $("#salaryField").show();
                $("#bonusField").hide();

            } else if (this.value === '0') {
                $("#salaryField").hide();
                $("#bonusField").hide();
            }

        });
    });
</script>        <!-- to hide or show the fields depends on the emp type in add employee -->

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