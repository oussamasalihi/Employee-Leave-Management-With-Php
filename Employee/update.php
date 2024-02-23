<?php 
session_start();
error_reporting(0);
    include("../config.php");
    
        $employee_id  = $_SESSION["employee_id"];

        // Fetch employee details
        $sql = "SELECT * from tbl_employee WHERE employee_id=:employee_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam("employee_id", $employee_id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_OBJ); 
        handle_database_error($stmt);
  



        
        if(isset($_POST["update"])){
            $gender = filter_data($_POST["gender"]);
            $first_name = filter_data($_POST["first_name"]);
            $middle_name = filter_data($_POST["middle_name"]);
            $last_name = filter_data($_POST["last_name"]);
            $age = filter_data($_POST["age"]);
            $email_address = filter_data($_POST["email_address"]);
            $contact_number = filter_data($_POST["contact_number"]);
            $department_short_name = filter_data($_POST["department_short_name"]);
            $designation_name = filter_data($_POST["designation_name"]);
            
            $sql = "UPDATE tbl_employee SET gender=:gender, first_name=:first_name ,middle_name=:middle_name,last_name=:last_name,age=:age,email_address=:email_address,contact_number=:contact_number,department_short_name=:department_short_name,designation_name=:designation_name where employee_id =:employee_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam("gender", $gender, PDO::PARAM_STR);
            $stmt->bindParam("first_name", $first_name, PDO::PARAM_STR);
            $stmt->bindParam("middle_name", $middle_name, PDO::PARAM_STR);
            $stmt->bindParam("last_name", $last_name, PDO::PARAM_STR);
            $stmt->bindParam("age", $age, PDO::PARAM_INT);
            $stmt->bindParam("email_address", $email_address, PDO::PARAM_STR);
            $stmt->bindParam("contact_number", $contact_number, PDO::PARAM_STR);
            $stmt->bindParam("department_short_name", $department_short_name, PDO::PARAM_STR);
            $stmt->bindParam("designation_name", $designation_name, PDO::PARAM_STR);
            $stmt->bindParam("employee_id", $employee_id, PDO::PARAM_INT);
            $stmt->execute();
            handle_database_error($stmt);
            
                $msg="Successfully Updated";
                header("location:update.php?msg={$msg}");
                exit;
        }

    
    // Function to handle database errors
    function handle_database_error($stmt) {
        if (!$stmt) {
            die("Database error: " . $stmt->errorInfo()[2]);
        }
    }
    // Function to sanitize input data
    function filter_data($data){
        $data = trim($data);
        $data = stripslashes($data);   
        $data = htmlspecialchars($data);
        return $data;
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.css">

    <script defer src="../assets/fontawesome/js/all.min.js"></script>
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
</head>

<body>
    <!-- Start Slidebar Section -->
    <?php include("includes/slidebar.php"); ?>
    <!-- End SlideBar Section -->
    <!-- Start Navbar Section -->
    <?php include("includes/navbar.php"); ?>
    <!-- End Navbar Section -->

    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Update Profile</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>


        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="post">
                                    <div class="row">


                                    <!-- Display Error Message -->
                                    <?php if (!empty($error)) { ?>
                                        <div class="alert alert-danger"><?php echo $error; ?></div>
                                    <?php } ?>
                                    <!-- Display Success Message -->
                                    <?php if (!empty($_GET["msg"])) { ?>
                                        <div class="alert alert-success"><?php echo $_GET["msg"]; ?></div>
                                    <?php } ?>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">ID Number</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="id number"
                                                        id="first-name-icon" value="<?php echo htmlentities($results->employee_id_number) ?>"  name="employee_id_number" readonly>
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-hash"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Gender</label>
                                                <div class="position-relative">
                                                    <fieldset class="form-group">
                                                    <select class="form-select" id="basicSelect" name="gender">
                                                        <option value="Male" <?php if ($results->gender === "Male") echo "selected"; ?>>Male</option>
                                                        <option value="Female" <?php if ($results->gender === "Female") echo "selected"; ?>>Female</option>
                                                    </select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">First Name</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="first name"
                                                        id="first-name-icon" value="<?php echo htmlentities($results->first_name) ?>"  name="first_name">
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Middle Name</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="middle name"
                                                        id="first-name-icon" value="<?php echo htmlentities($results->middle_name) ?>"  name="middle_name">
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Last Name</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="last name"
                                                        id="first-name-icon" value="<?php echo htmlentities($results->last_name) ?>"  name="last_name">
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Age</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="age"
                                                        id="first-name-icon" value="<?php echo htmlentities($results->age) ?>"  name="age">
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Email</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="email"
                                                        id="first-name-icon" value="<?php echo htmlentities($results->email_address) ?>"  name="email_address">
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-envelope"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Contact</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="contact"
                                                        id="first-name-icon" value="<?php echo htmlentities($results->contact_number) ?>"  name="contact_number">
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-phone"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Profile</label>
                                                <div class="position-relative">
                                                    <input type="file" class="form-control" placeholder=""
                                                        id="first-name-icon">
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="country-floating">Department</label>
                                                <fieldset class="form-group">
                                                <select class="form-select" id="basicSelect" name="department_short_name">
<!-- List Departments -->
<?php 
    $sql = "SELECT department_short_name FROM tbl_department";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results1 = $stmt->fetchAll(PDO::FETCH_OBJ);
    if($stmt->rowCount() > 0){
        foreach($results1 as $resultD){
            if($resultD->department_short_name == $results->department_short_name ){
                echo "<option value=".$resultD->department_short_name." selected>".$resultD->department_short_name."</option>";
            } else {
    ?>
            <option value="<?php echo htmlentities($resultD->department_short_name) ?>">
                <?php echo htmlentities($resultD->department_short_name) ?>
            </option>
<?php
            }
        }
    }
?>
                                                </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="company-column">Designation</label>
                                                <fieldset class="form-group">
                                                <select class="form-select" id="basicSelect" name="designation_name">
    <!-- List Designation -->
    <?php 
        $sql = "SELECT designation_name FROM tbl_designation";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results2 = $stmt->fetchAll(PDO::FETCH_OBJ);
        if($stmt->rowCount() > 0){
            foreach($results2 as $resultDs){
                if($resultDs->designation_name == $results->designation_name ){
                    echo "<option value=".$resultDs->designation_name." selected>".$resultDs->designation_name."</option>";
                } else {
        ?>
                <option value="<?php echo htmlentities($resultDs->designation_name) ?>">
                    <?php echo htmlentities($resultDs->designation_name) ?>
                </option>
        <?php
                }
            }
        }
        ?>
    </select>

                                                </fieldset>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Username</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="username"
                                                        id="first-name-icon" value="<?php echo htmlentities($results->username)?>" readonly>
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Password</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control" placeholder="passsword"
                                                        id="first-name-icon">
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-key"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1" name="update">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
    </div>

    </div>
    </div>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/app.js"></script>

    <script src="../assets/js/main.js"></script>
</body>

</html>