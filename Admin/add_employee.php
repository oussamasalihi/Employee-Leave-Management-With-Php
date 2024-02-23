<?php
// Include Configuration File 
include("../config.php");

    
    // // Generate a unique ID For employee Id Number
    // $generated_id = sprintf("%03d", uniqid());
    // $employee_id_numberG = "Emp" . $generated_id;

    // Function to generate a reference number
    function generateEmpId() {
        // Generate a unique ID with the format EMP-XXXX (XXXX is a random 5-digit number)
        $uniqueID = 'EMP-' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        return $uniqueID;
    }

try {
// Check if the form is submitted
if (isset($_POST["add"])) {
    

    // Retrieve form data
    $employee_id_number = $_POST['employee_id_number'];
    $gender = $_POST['gender'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];
    $email_address = $_POST['email_address']; // Corrected naming convention
    $contact_number = $_POST['contact_number']; // Corrected naming convention
    $department_short_name = $_POST['department_short_name'];
    $designation_name = $_POST['designation_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $account_status = 1; // Assuming this is a hardcoded value
    

    // Prepare and execute SQL query to insert data into the database
    $sql = "INSERT INTO tbl_employee (employee_id_number, gender, first_name, middle_name, last_name, age, email_address, contact_number, department_short_name, designation_name, username, password, account_status)
        VALUES (:employee_id_number, :gender, :first_name, :middle_name, :last_name, :age, :email_address, :contact_number, :department_short_name, :designation_name, :username, :password, :account_status)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':employee_id_number', $employee_id_number);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':first_name', $first_name);
    $stmt->bindParam(':middle_name', $middle_name);
    $stmt->bindParam(':last_name', $last_name);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':email_address', $email_address);
    $stmt->bindParam(':contact_number', $contact_number);
    $stmt->bindParam(':department_short_name', $department_short_name);
    $stmt->bindParam(':designation_name', $designation_name);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':account_status', $account_status);


    // Execute the statement
    if($stmt->execute()){
        // Redirect to a success page or display a success message
        $msg = "Employee added successfully.";
        header("location: manage_employee.php?msg={$msg}");
        exit;
    } else {
        // Redirect to an error page or display an error message
        $error = "Failed To add Department : ". $stmt->errorInfo()[2];

    }
}
  
} catch (\Throwable $th) {
    echo 'Error: ' . $th->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.css">

    <script defer src="../assets/fontawesome/js/all.min.js"></script>
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <style type="text/css">
    .notif:hover {
        background-color: rgba(0, 0, 0, 0.1);
    }
    </style>

    <!-- <script type="text/javascript">
    function valid() {
        if (document.addemp.password.value != document.addemp.confirmpassword.value) {
            alert("New Password and Confirm Password Field do not match  !!");
            document.addemp.confirmpassword.focus();
            return false;
        }
        return true;
    }
    </script>

    <script>
    function checkAvailabilityEmpid() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data: 'empcode=' + $("#employee_id_number").val(),
            type: "POST",
            success: function(data) {
                $("#empid-availability").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
    </script>

    <script>
    function checkAvailabilityEmailid() {
        $("#loaderIcon").show();
        jQuery.ajax({
            url: "check_availability.php",
            data: 'emailid=' + $("#email").val(),
            type: "POST",
            success: function(data) {
                $("#emailid-availability").html(data);
                $("#loaderIcon").hide();
            },
            error: function() {}
        });
    }
    </script> -->
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
                    <h3>Add Employee</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Employee</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>

        <!-- Display Error Message -->
        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>
        <!-- Display Success Message -->
        <?php if (!empty($_GET["msg"])) { ?>
            <div class="alert alert-success"><?php echo $_GET["msg"]; ?></div>
        <?php } ?>

        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="post" name="addemp">
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
                                                <label for="first-name-icon">ID Number(Must be unique)</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="id number"
                                                        id="first-name-icon" value="<?php echo generateEmpId() ?>" name="employee_id_number" required>
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
                                                        <option value="Male" >Male</option>
                                                        <option value="Female">Female</option>
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
                                                        id="first-name-icon"  name="first_name" required>
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
                                                        id="first-name-icon"  name="middle_name">
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
                                                        id="first-name-icon"   name="last_name" required>
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
                                                        id="first-name-icon"   name="age" required>
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
                                                    <input type="text" class="form-control" placeholder="Email"
                                                        id="first-name-icon"   name="email_address" required>
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
                                                        id="first-name-icon"   name="contact_number" required>
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
    ?>
            <option value="<?php echo htmlentities($resultD->department_short_name) ?>">
                <?php echo htmlentities($resultD->department_short_name) ?>
            </option>
<?php
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
        $sql = "SELECT * FROM tbl_designation";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results2 = $stmt->fetchAll(PDO::FETCH_OBJ);
        if($stmt->rowCount() > 0){
            foreach($results2 as $resultDs){
        ?>
                <option value="<?php echo htmlentities($resultDs->designation_name) ?>">
                    <?php echo htmlentities($resultDs->designation_name) ?>
                </option>
        <?php

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
                                                        id="first-name-icon" name="username" required>
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Password</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control" placeholder="passsword"
                                                        id="first-name-icon" name="password" required>
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-key"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1" name="add" >Submit</button>
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