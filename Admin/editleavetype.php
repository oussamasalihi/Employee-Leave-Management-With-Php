<?php
    include("../config.php");

    // // Check if 'id' parameter is provided in the URL
    // if (!isset($_GET['id']) || empty($_GET['id'])) {
    //     // Redirect to an error page 
    //     $error_message = "There is no id parameter provided in the URL Or Not Found.";
    //     header("Location: ../error.php?error=". urlencode($error_message));
    //     exit();
    // }
    
    // Retrieve leave type ID from the URL
    $leave_type_id = intval($_GET['id']);

    // Fetch leave type details
    $sql = "SELECT * FROM tbl_leave_type WHERE leave_type_id = :leave_type_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":leave_type_id", $leave_type_id, PDO::PARAM_INT);
    $stmt->execute();
    $leave_type = $stmt->fetch(PDO::FETCH_OBJ); 

    // Handle form submission
    if(isset($_POST["update"])){
        // Retrieve form data
        $leave_name = filter_data($_POST["leave_name"]);
        $leave_description = filter_data($_POST["leave_description"]);
        $number_days_allowed = intval($_POST["number_days_allowed"]);
        
        // Prepare and execute SQL query to update data in the database
        $sql = "UPDATE tbl_leave_type SET leave_name=:leave_name, leave_description=:leave_description, number_days_allowed=:number_days_allowed WHERE leave_type_id=:leave_type_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':leave_name', $leave_name, PDO::PARAM_STR);
        $stmt->bindParam(':leave_description', $leave_description, PDO::PARAM_STR);
        $stmt->bindParam(':number_days_allowed', $number_days_allowed, PDO::PARAM_INT);
        $stmt->bindParam(":leave_type_id", $leave_type_id, PDO::PARAM_INT);
        if($stmt->execute()){
            // Redirect to manage leave type
            $msg  = "Leave Type Updated Successfully";
            header("Location: manage_leave_type.php?msg=" . urlencode($msg));
            exit();
        } else {
            $error = "Error updating leave type: " . $stmt->errorInfo()[2];
        }
    }

    // Function to sanitize input data
    function filter_data($data){
        return htmlspecialchars(strip_tags(trim($data)));
    }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Leave Type</title>
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
                    <h3>Edit Leave Type</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Leave Type</li>
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
                                <form class="form form-vertical" method="post">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="leave_name">Leave Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control" placeholder="Input leave type" id="leave_name" name="leave_name" value="<?php echo htmlspecialchars($leave_type->leave_name); ?>" required>
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
                                                        <input type="text" class="form-control" placeholder="Input Description" id="description" name="leave_description" value="<?php echo htmlspecialchars($leave_type->leave_description); ?>" required>
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
                                                        <input type="number" class="form-control" placeholder="Input days allowed" id="number_days_allowed" name="number_days_allowed" value="<?php echo htmlspecialchars($leave_type->number_days_allowed); ?>" required>
                                                        <div class="form-control-icon">
                                                            <i class="fa fa-table"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" name="update" class="btn btn-primary me-1 mb-1">Update</button>
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
