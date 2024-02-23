<?php 
// Include the database connection file
include("../config.php");


 
// Define variables to store form data
$leave_name = $leave_description = $number_days_allowed = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add"])) {
    // Retrieve form data
    $leave_name = filter_data($_POST['leave_name']);
    $leave_description = filter_data($_POST['leave_description']);
    $number_days_allowed = filter_data($_POST['number_days_allowed']);

    // Prepare and execute SQL query to insert data into the database
    $sql = "INSERT INTO tbl_leave_type (leave_name, leave_description, number_days_allowed, creation_date) VALUES (:leave_name, :leave_description, :number_days_allowed, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':leave_name', $leave_name);
    $stmt->bindParam(':leave_description', $leave_description);
    $stmt->bindParam(':number_days_allowed', $number_days_allowed);
    if($stmt->execute()){
        // Redirect to manage leave type
        $msg  = "Leave Type Added Successfuly";
        header("Location: manage_leave_type.php?msg={$msg}");
        exit();

    }else{
        $error =  "Error! Can't add new Leave Type.";
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
    <title>Add Leave Type</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <script defer src="../assets/fontawesome/js/all.min.js"></script>
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <style type="text/css">
        .notif:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }
    </style>
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
                    <h3>Add Leave Type</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Leave Type</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
        <!-- Display Error Message -->
        <?php if (!empty($error)) { ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="leave_name">Leave Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Input leave type" id="leave_name" name="leave_name" value="<?php echo htmlspecialchars($leave_name); ?>">
                                                        <div class="form-control-icon">
                                                            <i class="fa fa-table"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="description">Description</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Input Description" id="description" name="leave_description" value="<?php echo htmlspecialchars($leave_description); ?>">
                                                        <div class="form-control-icon">
                                                            <i class="fa fa-table"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="number_days_allowed	">Number of days Allowed</label>
                                                    <div class="position-relative">
                                                        <input type="number" class="form-control" placeholder="Input days allowed" id="number_days_allowed" name="number_days_allowed" value="<?php echo htmlspecialchars($number_days_allowed); ?>">
                                                        <div class="form-control-icon">
                                                            <i class="fa fa-table"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" name="add" class="btn btn-primary me-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic Vertical form layout section end -->
    </div>

    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>


