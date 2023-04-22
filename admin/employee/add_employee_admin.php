
<?php

    session_start();
    if(!isset($_SESSION['UserID'])  || $_SESSION['isAdmin'] != 1 ){
        session_destroy();
        header("Location: ../login.php");
        exit;

    }     //check if logged in

    include '../../helper/db_con.php';



    //insert new employee
    if(isset($_POST['addEmployee'])) {

        $firstName = trim($_POST['fName']);
        $lastName = trim($_POST['lName']);
        $IdNumber = trim($_POST['idNum']);
        $dob = trim($_POST['dob']);
        $email = trim(strtolower($_POST['email']));
        $phoneNumber = trim($_POST['phone']);
        $address = trim($_POST['address']);
        $notes = trim($_POST['notes']);
        $employeeType = trim($_POST['employeeType']);
        $salary = trim($_POST['salary']);
        if (empty($salary)){
            $salary = 0;
        }
        $bonus = trim($_POST['bonus']);
        if (empty($bonus)){
            $bonus = 0;
        }



        //protect from sql injection
        $firstName = mysqli_real_escape_string($conn, $firstName);
        $lastName = mysqli_real_escape_string($conn, $lastName);
        $IdNumber = mysqli_real_escape_string($conn, $IdNumber);
        $dob = mysqli_real_escape_string($conn, $dob);
        $email = mysqli_real_escape_string($conn, $email);
        $phoneNumber = mysqli_real_escape_string($conn, $phoneNumber);
        $address = mysqli_real_escape_string($conn, $address);
        $notes = mysqli_real_escape_string($conn, $notes);

        //check if employee already exists
        $sql = "SELECT * FROM employee WHERE EmpID = '$IdNumber'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0) {
            header("Location: ../../admin/employee.php?error=employeeExists");
            exit;
        }


        //check if email already exists
        $sql = "SELECT * FROM employee WHERE Email = '$email'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0) {
            header("Location: ../../admin/employee.php?error=emailExists");
            exit;
        }

        if ($notes == ""){
            $notes = "No notes";
        }

        $sql = "INSERT INTO employee (EmpID,firstName, lastName,dob, email, Phone, address, notes) VALUES (?,?, ?,?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../../admin/employee.php?error=Error");
            exit();
        }
        else {
            $dob = date("Y-m-d", strtotime($dob));
            mysqli_stmt_bind_param($stmt, "ssssssss",$IdNumber, $firstName, $lastName,$dob, $email, $phoneNumber, $address, $notes);
            mysqli_stmt_execute($stmt);


            if ($employeeType == "0") {
                //create a user account for the employee admin
                $sql = "SELECT * FROM users WHERE email_for_web = '$email'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                if($resultCheck > 0) {
                    //delete the added employee
                    $sql = "DELETE FROM employee WHERE EmpID = '$IdNumber'";
                    $result = mysqli_query($conn, $sql);
                    header("Location: ../../admin/employee.php?error=emailExists");
                    exit;
                }

                //create a random password
                $password = substr(md5(rand(0,1000)), 0, 10);
                //hash the password
                $hashedPwd = password_hash($password, PASSWORD_DEFAULT);


                $sql = "INSERT INTO users (EmpID, email_for_web,password, isAdmin) VALUES (?,?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../../admin/employee.php?error=sqlerror");
                }
                else {
                    $i = 1;
                    mysqli_stmt_bind_param($stmt, "ssss", $IdNumber, $email, $hashedPwd,$i);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../../admin/employee.php?success=employeeAdded");
                }

                exit();


            }

            else if ($employeeType == "1") {
                //create a user account for the employee sales

                //check if the employee email already exists
                $sql = "SELECT * FROM users WHERE email_for_web = '$email'";
                $result = mysqli_query($conn, $sql);
                $resultCheck = mysqli_num_rows($result);
                if($resultCheck > 0) {
                    //delete the added employee
                    $sql = "DELETE FROM employee WHERE EmpID = '$IdNumber'";
                    $result = mysqli_query($conn, $sql);
                    header("Location: ../../admin/employee.php?error=emailExists");
                    exit;
                }

                //create a random password
                $password = substr(md5(rand(0,1000)), 0, 10);
                //hash the password
                $hashedPwd = password_hash($password, PASSWORD_DEFAULT);



                $sql = "INSERT INTO users (EmpID, email_for_web,password, isAdmin) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $sql)) {
                    $sql = "DELETE FROM employee WHERE EmpID = '$IdNumber'";
                    $result = mysqli_query($conn, $sql);
                    header("Location: ../../admin/employee.php?error=sqlerror");
                    exit();
                }else {

                    $i = 0;
                    mysqli_stmt_bind_param($stmt, "sssi", $IdNumber, $email, $hashedPwd,$i);
                    mysqli_stmt_execute($stmt);

                    header("Location: ../../admin/employee.php?success=employeeAdded");

                }


                //insert into saleperson
                $sql = "INSERT INTO sales_employee (EmpID, salary, Bonus_Per_Sale) VALUES ( $IdNumber,$salary,$bonus)";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    $sql = "DELETE FROM employee WHERE EmpID = '$IdNumber'";
                    $result = mysqli_query($conn, $sql);
                    header("Location: ../../admin/employee.php?error=sqlError");
                    exit();
                }

                header("Location: ../../admin/employee.php?success=employeeAdded");
                exit();

            }
            else if ($employeeType == "2") {

                //insert into other employee

                $sql = "INSERT INTO other_emp (EmpID, salary) VALUES ( $IdNumber, $salary )";
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    $sql = "DELETE FROM employee WHERE EmpID = '$IdNumber'";
                    $result = mysqli_query($conn, $sql);
                    header("Location: ../../admin/employee.php?error=sqlerror");
                    exit();
                }
                header("Location: ../../admin/employee.php?success=employeeAdded");
                exit();

            }

        }
        exit;

    }


