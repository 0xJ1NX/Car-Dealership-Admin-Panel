<?php
session_start();
include '../../helper/db_con.php';

if (!isset($_SESSION['UserID']) || $_SESSION['isAdmin'] != 1) {
    session_destroy();
    header("Location: ../../login.php");
    exit;
}

if (isset($_GET['EmpID']) && $_GET['EmpID'] !== "" ) {
    $id = $_GET['EmpID'];

    //protect from sql injection
    $id = mysqli_real_escape_string($conn, $id);

    $sql = "SELECT * FROM employee WHERE EmpID = $id";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $firstName = $row['FirstName'];
        $lastName = $row['LastName'];

        $dob = $row['dob'];
        $address = $row['Address'];
        $phone = $row['Phone'];
        $email = $row['Email'];
        $notes = $row['Notes'];


        $query_emp = "SELECT * FROM sales_employee WHERE EmpID = '$id'";
        $result_emp = mysqli_query($conn, $query_emp);
        $emp_type = "Admin";
        $emp_type_id = 0;
        $salary = 0;
        $bonus = 0;


        if (mysqli_num_rows($result_emp) > 0) {
            $result_emp = mysqli_fetch_array($result_emp);
            $emp_type = "Sales Employee";
            $emp_type_id = 1;
            $salary = $result_emp['salary'];
            $bonus = $result_emp['Bonus_Per_Sale'];
        }

        $query_emp = "SELECT * FROM other_emp WHERE EmpID = '$id'";
        $result_emp = mysqli_query($conn, $query_emp);
        if (mysqli_num_rows($result_emp) > 0) {
            $result_emp = mysqli_fetch_array($result_emp);
            $emp_type = "Other Employee";
            $emp_type_id = 2;
            $salary = $result_emp['salary'];
        }


    } else {
        header("Location: ../employee.php");
        exit;
    }


}

if (isset($_POST['editEmp'])) {



    $IdNum = $_POST['IdNum'];
    $fName = $_POST['fName'];
    $lName = $_POST['lName'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $notes = $_POST['notes'];
    $emp_type = $_POST['employeeTypeEdit'];
    $salary = trim($_POST['salary']);
    if (empty($salary)){
        $salary = 0;
    }
    $bonus = trim($_POST['bonus']);
    if (empty($bonus)){
        $bonus = 0;
    }


    $IdNum = mysqli_real_escape_string($conn, $IdNum);
    $fName = mysqli_real_escape_string($conn, $fName);
    $lName = mysqli_real_escape_string($conn, $lName);
    $dob = mysqli_real_escape_string($conn, $dob);
    $email = mysqli_real_escape_string($conn, $email);
    $phone = mysqli_real_escape_string($conn, $phone);
    $address = mysqli_real_escape_string($conn, $address);
    $notes = mysqli_real_escape_string($conn, $notes);
    $emp_type = mysqli_real_escape_string($conn, $emp_type);
    $salary = mysqli_real_escape_string($conn, $salary);
    $bonus = mysqli_real_escape_string($conn, $bonus);

    //check if email already exists
    $sql = "SELECT * FROM employee WHERE Email = '$email'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0) {
        $row = mysqli_fetch_array($result);
        if ($row['EmpID'] != $IdNum) {
            header("Location: ../employee.php?error=emailExists");
            exit;
        }
    }

    if ($notes == ""){
        $notes = "No notes";
    }


    $sql = "UPDATE employee SET FirstName = '$fName', LastName = '$lName', dob = '$dob', Email = '$email', Phone = '$phone', Address = '$address', Notes = '$notes' WHERE EmpID = '$IdNum'";
    $result = mysqli_query($conn, $sql);
    if ($result) {

        if($emp_type == 0){
            //delete from sales employee table if it exists
            $sql = "DELETE FROM sales_employee WHERE EmpID = '$IdNum'";
            $result1 = mysqli_query($conn, $sql);
            //delete from other employee table if it exists
            $sql = "DELETE FROM other_emp WHERE EmpID = '$IdNum'";
            $result2 = mysqli_query($conn, $sql);

            //check if users table has the employee
            $sql = "SELECT * FROM users WHERE EmpID = '$IdNum'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $sql = "UPDATE users SET isAdmin = 1 WHERE EmpID = '$IdNum'";
            }
            else{
                $sql = "INSERT INTO users (EmpID,email_for_web,password, isAdmin) VALUES ('$IdNum','$email','002', 1)";
            }
            $result = mysqli_query($conn, $sql);

            if ($result) {
                header("Location: ../employee.php?success=edit");
            }
            else{
                header("Location: ../employee.php?error=edit");
            }
            exit;


        }  //done
        else if($emp_type == 1){

            //check if sales employee already exists
            $sql = "SELECT * FROM sales_employee WHERE EmpID = '$IdNum'";
            $result = mysqli_query($conn, $sql);


            if(mysqli_num_rows($result) > 0){
                //update sales employee
                $sql = "UPDATE sales_employee SET salary = '$salary', Bonus_Per_Sale = '$bonus' WHERE EmpID = '$IdNum'";

            }else{

                //delete from other employee table if it exists
                $sql = "DELETE FROM other_emp WHERE EmpID = '$IdNum'";
                $result = mysqli_query($conn, $sql);


                //insert into sales employee table
                $sql = "INSERT INTO sales_employee (EmpID, salary, Bonus_Per_Sale) VALUES ('$IdNum', '$salary', '$bonus')";
                $result = mysqli_query($conn, $sql);

                if($result) {
                    //check if employee has a user
                    $sql = "SELECT * FROM users WHERE EmpID = '$IdNum'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        //change user type to non admin
                        $sql = "UPDATE users SET isAdmin = 0 WHERE EmpID = '$IdNum'";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            header("Location: ../employee.php?success=editEmp");
                        } else {
                            header("Location: ../employee.php?error=editEmp");
                        }
                        exit;
                    }else{
                        //create user
                        $sql = "INSERT INTO users (EmpID,email_for_web,password, isAdmin) VALUES ('$IdNum','$email','00', 0)";
                        $result = mysqli_query($conn, $sql);
                        if ($result) {
                            header("Location: ../employee.php?success=editEmp");
                        } else {
                            header("Location: ../employee.php?error=editEmp");
                        }
                        exit;
                    }
                }
            }
            $result = mysqli_query($conn, $sql);
            if ($result) {
                header("Location: ../employee.php?success=editEmp");
                exit;
            } else {
                header("Location: ../employee.php?error=editEmp");
                exit;
            }

        }else if($emp_type == 2){

            //check if other employee already exists
            $sql = "SELECT * FROM other_emp WHERE EmpID = '$IdNum'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0){
                //update other employee
                $sql = "UPDATE other_emp SET salary = '$salary' WHERE EmpID = '$IdNum'";

            }else{
                //delete from sales employee table if it exists
                $sql = "DELETE FROM sales_employee WHERE EmpID = '$IdNum'";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    header("Location: ../../admin/employee.php?error=sqlError");
                    exit;
                }

                //delete user if it exists
                $sql = "DELETE FROM users WHERE EmpID = '$IdNum'";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    header("Location: ../../admin/employee.php?error=sqlError");
                    exit;
                }

                //insert into other employee table
                $sql = "INSERT INTO other_emp (EmpID, salary) VALUES ('$IdNum', '$salary')";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    header("Location: ../../admin/employee.php?error=sqlError");
                    exit;
                }

                header("Location: ../../admin/employee.php?success=editEmp");
                exit;

            }
            $result = mysqli_query($conn, $sql);
            if (!$result) {
                header("Location: ../../admin/employee.php?error=sqlError");
                exit();
            }
            header("Location: ../../admin/employee.php?edit=success");
            exit;

        }


    } else {
        header("Location: ../../admin/employee.php?error=edit Employee not successful");
        exit;
    }


}


?>

<html lang="en">

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

<!-- form to edit employee -->
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card shadow-lg">


                <div class="card-header">
                    <h4 class="text-center">Edit Employee</h4>
                </div>


                <div class="card-body">

                    <form class="needs-validation" novalidate method="post" action="editEmployee.php">

                        <!--- form with validation -->

                        <div class="form-group">
                            <label for="InputPhone">ID Number</label>
                            <input type="number" name="IdNum" class="form-control" value="<?php echo $id ?>"
                                   placeholder="employee ID" required readonly>
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
                                   value="<?php echo $firstName ?>" onkeydown="return /[a-z]/i.test(event.key)">

                            <div class="invalid-feedback">
                                Please enter First Name.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- FirstName -->

                        <div class="form-group">

                            <label for="InputLastName">Last Name</label>
                            <input type="text" name="lName" class="form-control" placeholder="Last Name"
                                   value="<?php echo $lastName ?>" required onkeydown="return /[a-z]/i.test(event.key)">

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                            <div class="invalid-feedback">
                                Please enter Last Name.
                            </div>

                        </div>  <!-- LastName -->

                        <div class="form-group">
                            <label for="InputPhone">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="<?php echo $dob ?>"
                                   placeholder="Date of Birth" required>

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
                                   aria-describedby="emailHelp" value="<?php echo $email ?>" placeholder="email"
                                   required>
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
                            <input type="number" name="phone" class="form-control" value="<?php echo $phone ?>"
                                   placeholder="Phone Number" required>
                            <div class="invalid-feedback">
                                Please enter phone number.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Phone -->

                        <div class="form-group">
                            <label for="InputAddress">Address</label>
                            <input type="text" name="address" class="form-control" value="<?php echo $address ?>"
                                   placeholder="Address" required>
                            <div class="invalid-feedback">
                                Please enter address.
                            </div>

                            <div class="valid-feedback">
                                Looks good!

                            </div>

                        </div>    <!-- Address -->

                        <div class="form-group">
                            <label for="InputNotes">Notes</label>
                            <textarea class="form-control" name="notes" rows="3" placeholder="What this employee do"><?php echo $notes ?></textarea>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                            <div class="invalid-feedback">
                                Please enter notes.
                            </div>

                        </div>    <!-- Notes -->


                        <div class="form-group">
                            <label for="InputEmployeeType">Employee Type</label>
                            <select class="form-select" name="employeeTypeEdit" id="selectEmployeeEdit" required>
                                <?php if ($emp_type_id === 0) {
                                    echo '<option value="0" selected>Admin</option>
                                                  <option value="1">Salesperson</option>
                                                  <option value="2">Other Emp</option>';

                                } elseif ($emp_type_id === 1) {
                                    echo '<option value="0">Admin</option>
                                                  <option value="1" selected>Salesperson</option>
                                                  <option value="2">Other Emp</option>';
                                } else {
                                    echo '<option value="0">Admin</option>
                                                  <option value="1">Salesperson</option>
                                                  <option value="2" selected>Other Emp</option>';
                                } ?>

                            </select>
                        </div>     <!-- Employee Type -->


                        <div class="form-group" id="salaryFieldEdit" style="display: none">
                            <label for="InputSalary">Salary</label>
                            <input type="number" name="salary" class="form-control" <?php if ($salary > 0) {
                                echo 'value="$salary"';
                            } ?> placeholder="Salary (empty = 0 )">

                            <div class="invalid-feedback">
                                Please enter salary.
                            </div>
                            <div class="valid-feedback">
                                Looks good!
                            </div>


                        </div>    <!-- Salary -->

                        <div class="form-group" id="bonusFieldEdit" style="display: none">
                            <label for="InputBonus">Bonus</label>
                            <input type="number" name="bonus" class="form-control"
                                   <?php if ($bonus !== null && $bonus > 0) {
                                       echo 'value="$bonus"';
                                   } ?>placeholder="Bonus ( empty = 0 )">
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



                        <button class="btn btn-primary"  name="editEmp" value="editEmp"
                                style="background:linear-gradient(to right, #606c88, #3f4c6b) ">Save Changes
                        </button>

                        <a href="../employee.php" class="btn btn-primary">Back</a>

                    </form>


                    <script>

                        //  for disabling form submissions if there are invalid fields
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
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/af-2.4.0/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js"></script>


<script>
    $(document).ready(function () {         //to show the salary and bonus fields or hide them


        $('#selectEmployeeEdit').on('change', function () {
            if (this.value === '1') {
                $("#salaryFieldEdit").show();
                $("#bonusFieldEdit").show();
            } else if (this.value === '2') {
                $("#salaryFieldEdit").show();
                $("#bonusFieldEdit").hide();

            } else if (this.value === '0') {
                $("#salaryFieldEdit").hide();
                $("#bonusFieldEdit").hide();
            }

        });
    });
</script>


</body>


</html>
