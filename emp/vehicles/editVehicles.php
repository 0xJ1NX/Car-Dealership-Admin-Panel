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
    $sql = "SELECT * FROM vehicles WHERE VehicleID = $CarId";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $keyNumber = $row['KeyNo'];
        $Type = $row['Type'];
        $ModelID = $row['ModelID'];
        $Transmission = $row['Transmission'];
        $Year = $row['Year'];
        $KM = $row['KM'];
        $Fuel = $row['Fuel'];
        $CC = $row['CC'];
        $Color = $row['Color'];
        $warranty = $row['Warranty'];
        $Chassis = $row['Chassis'];
        $buyPrice = $row['Buying_Price'];
        $exportPrice = $row['Export_Price'];
        $sellPrice = $row['Selling_Price'];
        $features = $row['Features'];

        //get the Model Name and Brand Name
        $sql = "SELECT models.Name AS modelName,brands.Name AS brandName FROM models inner JOIN brands ON models.BrandID = brands.BrandID WHERE models.ModelID = $ModelID";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            //result to array
            $row = mysqli_fetch_assoc($result);
            $ModelName = $row['modelName'];
            $BrandName = $row['brandName'];

        }


    }
}


if (isset($_POST['editVehicle'])) {
    $CarId = trim($_POST['vID']);
    $KeyNo = trim($_POST['KeyNo']);
    $Type = trim($_POST['Type']);
    $Brand = trim($_POST['Brand']);
    $Model = trim($_POST['Model']);
    $Transmission = trim($_POST['Transmission']);
    $Year = trim($_POST['Year']);
    $KM = trim($_POST['KM']);
    $Fuel = trim($_POST['Fuel']);
    $cc = trim($_POST['CC']);
    $Color = trim($_POST['Color']);
    $Warrenty = trim($_POST['Warranty']);
    $Chassis = trim($_POST['Chassis']);
    $buyPrice = trim($_POST['BuyPrice']);
    $exportPrice = trim($_POST['exportPrice']);
    $sellPrice = trim($_POST['SellPrice']);
    $features = trim($_POST['Features']);


    $sql = "SELECT * FROM models WHERE Name  = '$Model'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $modelID = $row['ModelID'];
        //update the vehicle
        $sql = "UPDATE vehicles SET KeyNo = '$KeyNo', Type = '$Type', ModelID = '$modelID', Transmission = '$Transmission', Year = '$Year', KM = '$KM', Fuel = '$Fuel', CC = '$cc', Color = '$Color', Warranty = '$Warrenty', Chassis = '$Chassis', Buying_Price = '$buyPrice', Export_Price = '$exportPrice', Selling_Price = '$sellPrice', Features = '$features' WHERE VehicleID = '$CarId'";
        if (mysqli_query($conn, $sql)) {
            header("Location: ../vehicles.php?success=Vehicle Updated successfully");
            exit();
        }else{
           $error = "Error updating record: " . mysqli_error($conn);
            header("Location: ../vehicles.php?error='$error' . $sellPrice");
            exit();
        }

    } else {

        //insert new model
        //check if brand already exists
        $sql = "SELECT * FROM brands WHERE Name  = '$Brand'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $brandID = $row['BrandID'];
            //insert new model
            $sql = "INSERT INTO models ( Name, BrandID ) VALUES ('$Model', '$brandID')";
            $result = mysqli_query($conn, $sql);
            $modelID = mysqli_insert_id($conn);
            //insert new vehicle
            $sql = "UPDATE vehicles SET KeyNo = '$KeyNo', Type = '$Type', ModelID = '$modelID', Transmission = '$Transmission', Year = '$Year', KM = '$KM', Fuel = '$Fuel', CC = '$cc', Color = '$Color', Warranty = '$Warrenty', Chassis = '$Chassis', Buying_Price = '$buyPrice', Export_Price = '$exportPrice', Selling_Price = '$sellPrice', Features = '$features' WHERE VehicleID = '$CarId'";            if (mysqli_query($conn, $sql)) {
                header("Location: ../vehicles.php?success=Vehicle Updated successfully");
                exit();
            }

        } else {
            //insert new brand
            $sql = "INSERT INTO brands ( Name ,Country) VALUES ('$Brand',' ')";
            $result = mysqli_query($conn, $sql);
            $brandID = mysqli_insert_id($conn);
            //insert new model
            $sql = "INSERT INTO models ( Name, BrandID ) VALUES ('$Model', '$brandID')";
            $result = mysqli_query($conn, $sql);
            $modelID = mysqli_insert_id($conn);
            //insert new vehicle
            $sql = "UPDATE vehicles SET KeyNo = '$KeyNo', Type = '$Type', ModelID = '$modelID', Transmission = '$Transmission', Year = '$Year', KM = '$KM', Fuel = '$Fuel', CC = '$cc', Color = '$Color', Warranty = '$Warrenty', Chassis = '$Chassis', Buying_Price = '$buyPrice', Export_Price = '$exportPrice', Selling_Price = '$sellPrice', Features = '$features' WHERE VehicleID = '$CarId'";            if (mysqli_query($conn, $sql)) {
                header("Location: ../vehicles.php?success=Vehicle Updated successfully");
                exit();
            }

        }

    }

    header("Location: ../vehicles.php?error=Vehicle not Updated");
    exit();



}

?>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Edit vehicle</title>
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
                    <h4 class="text-center">Edit Vehicle</h4>
                </div>
                <div class="card-body">

                    <form class="needs-validation" novalidate action="editVehicles.php" method="post">

                        <!--- form with validation -->

                        <div class="form-group">
                            <label for="inputCarId">Vehicle ID</label>
                            <input type="number" name="vID" class="form-control" value="<?php echo $CarId ?>" readonly>
                        </div>   <!-- ID vehicle -->

                        <div class="form-group">
                            <label for="KeyNo">KeyNo</label>
                            <input type="number" name="KeyNo" class="form-control"
                                   placeholder="KeyNo" value="<?php echo $keyNumber ?>" required>
                            <div class="invalid-feedback">
                                Please enter KeyNo.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- KeyNo -->

                        <div class="form-group">
                            <label for="Type">Type</label>
                            <input type="text" name="Type" class="form-control"
                                   placeholder="Type" value="<?php echo $Type ?>" required>
                            <div class="invalid-feedback">
                                Please enter Type.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Type -->

                        <div class="form-group">
                            <label for="Brand">Brand</label>
                            <input type="text" name="Brand" class="form-control"
                                   placeholder="Brand" value="<?php echo $BrandName ?>" required>
                            <div class="invalid-feedback">
                                Please enter Brand.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Brand -->

                        <div class="form-group">
                            <label for="Model">Model</label>
                            <input type="text" name="Model" class="form-control"
                                   placeholder="Model" value="<?php echo $ModelName ?>" required>
                            <div class="invalid-feedback">
                                Please enter Model.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Model -->

                        <div class="form-group">
                            <label for="Transmission">Transmission</label>
                            <input type="text" name="Transmission" class="form-control"
                                   placeholder="Transmission" value="<?php echo $Transmission ?>" required>
                            <div class="invalid-feedback">
                                Please enter Transmission.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Transmission -->

                        <div class="form-group">
                            <label for="Year">Year</label>
                            <input type="number" name="Year" class="form-control"
                                   placeholder="Year" value="<?php echo $Year ?>" required>
                            <div class="invalid-feedback">
                                Please enter Year.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Year -->

                        <div class="form-group">
                            <label for="KM">KM</label>
                            <input type="number" name="KM" class="form-control"
                                   placeholder="KM" value="<?php echo $KM ?>" required>
                            <div class="invalid-feedback">
                                Please enter KM.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- KM -->


                        <div class="form-group">
                            <label for="Fuel">Fuel</label>
                            <input type="text" name="Fuel" class="form-control"
                                   placeholder="Fuel" value="<?php echo $Fuel ?>" required>
                            <div class="invalid-feedback">
                                Please enter Fuel.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Fuel -->


                        <!--- cc -->
                        <div class="form-group">
                            <label for="CC">CC</label>
                            <input type="number" name="CC" class="form-control"
                                   placeholder="CC" value="<?php echo $CC ?>" required>
                            <div class="invalid-feedback">
                                Please enter CC.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- CC -->


                        <div class="form-group">
                            <label for="Color">Color</label>
                            <input type="text" name="Color" class="form-control"
                                   placeholder="Color" value="<?php echo $Color ?>" required>
                            <div class="invalid-feedback">
                                Please enter Color.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Color -->


                        <div class="form-group">
                            <label for="Warranty">Warranty</label>
                            <input type="text" name="Warranty" class="form-control"
                                   placeholder="Warranty" value="<?php echo $warranty ?>" required>
                            <div class="invalid-feedback">
                                Please enter Warranty.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Warranty -->


                        <div class="form-group">
                            <label for="Chassis">Chassis</label>
                            <input type="text" name="Chassis" class="form-control"
                                   placeholder="Chassis" value="<?php echo $Chassis ?>" required>
                            <div class="invalid-feedback">
                                Please enter Chassis.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- Chassis -->

                        <div class="form-group">
                            <label for="BuyPrice">BuyPrice</label>
                            <input type="number" name="BuyPrice" class="form-control"
                                   placeholder="BuyPrice" value="<?php echo $buyPrice ?>" required>
                            <div class="invalid-feedback">
                                Please enter BuyPrice.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- BuyPrice -->


                        <div class="form-group">
                            <label for="exportPrice">exportPrice</label>
                            <input type="number" name="exportPrice" class="form-control"
                                   placeholder="export Price" value="<?php echo $exportPrice ?>" required>
                            <div class="invalid-feedback">
                                Please enter SellPrice.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- export price -->



                        <div class="form-group">
                            <label for="SellPrice">SellPrice</label>
                            <input type="number" name="SellPrice" class="form-control"
                                   placeholder="SellPrice" value="<?php echo $sellPrice ?>" required>
                            <div class="invalid-feedback">
                                Please enter SellPrice.
                            </div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>

                        </div>   <!-- SellPrice -->


                        <!-- text area for features -->
                        <div class="form-group">
                            <label for="Features">Features</label>
                            <textarea name="Features" class="form-control"
                                      placeholder="Features" required><?php echo $features ?></textarea>
                            <div class="invalid-feedback">
                                Please enter Features.
                            </div>

                            <div class="valid-feedback">
                                Looks good!

                            </div>

                        </div>   <!-- Features -->




                        <div class="form-group">
                            <div class="dropdown-divider"></div>
                        </div>    <!-- divider -->

                        <button class="btn btn-primary" type="submit" name="editVehicle"
                                style="background:linear-gradient(to right, #606c88, #3f4c6b) ">Edit Vehicle
                        </button>

                        <a href="../vehicles.php" class="btn btn-primary">Back</a>

                    </form>


                    <script>       //validation for the form


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
