<?php 
// Session Start
session_start();
// Including the configuration file
include("../config.php");

$employee_id = $_SESSION["employee_id"];

// SQL query to get the number of pending leaves
$sql_pending_leaves = "SELECT count(*) AS total_pending_leaves FROM tbl_leave_application WHERE leave_status = 0 and employee_id=:employee_id";
$stmt_pending_leaves = $conn->prepare($sql_pending_leaves);
$stmt_pending_leaves->bindParam("employee_id", $employee_id, PDO::PARAM_INT);
$stmt_pending_leaves->execute();
// Fetching the number of pending leaves
$total_pending_leaves = $stmt_pending_leaves->fetchColumn();

// SQL query to get the number of approved leaves
$sql_approved_leaves = "SELECT count(*) AS total_approved_leaves FROM tbl_leave_application WHERE leave_status = 1 and employee_id=:employee_id";
$stmt_approved_leaves = $conn->prepare($sql_approved_leaves);
$stmt_approved_leaves->bindParam("employee_id", $employee_id, PDO::PARAM_INT);
$stmt_approved_leaves->execute();
// Fetching the number of approved leaves
$total_approved_leaves = $stmt_approved_leaves->fetchColumn();

// SQL query to get the number of rejected leaves
$sql_rejected_leaves = "SELECT count(*) AS total_rejected_leaves FROM tbl_leave_application WHERE leave_status = 2 and employee_id=:employee_id";
$stmt_rejected_leaves = $conn->prepare($sql_rejected_leaves);
$stmt_rejected_leaves->bindParam("employee_id", $employee_id, PDO::PARAM_INT);
$stmt_rejected_leaves->execute();
// Fetching the number of rejected leaves
$total_rejected_leaves = $stmt_rejected_leaves->fetchColumn();

// Total number of leaves
$total_leaves = $total_pending_leaves + $total_approved_leaves + $total_rejected_leaves;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Leave Management System</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <script defer src="../assets/fontawesome/js/all.min.js"></script>
    <link rel="stylesheet" href="../assets/vendors/chartjs/Chart.min.css">
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <link rel="shortcut icon" href="../assets/images/favicon.svg" type="image/x-icon">
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
            <h3>Dashboard</h3>
        </div>
        <section class="section">
            <div class="row mb-2">
                <!-- Card displaying information about all leaves -->
                <div class="col-xl-4 col-md-12 mb-4" onclick="location.href = 'leave_status.php';">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between p-md-1">
                                <div class="d-flex flex-row">
                                    <div class="align-self-center">
                                        <i class="fa fa-calendar text-primary fa-3x me-4"></i>
                                    </div>
                                    <div>
                                        <h4>Total Leaves</h4>
                                        <!-- Displaying the total number of leaves -->
                                        <h2 class="h1 mb-0"><?php echo $total_leaves; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card displaying information about pending leaves -->
                <div class="col-xl-4 col-md-12 mb-4" onclick="location.href = 'leave_status.php';">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between p-md-1">
                                <div class="d-flex flex-row">
                                    <div class="align-self-center">
                                        <i class="fa fa-info text-warning fa-3x me-4"></i>
                                    </div>
                                    <div>
                                        <h4>Pending Leaves</h4>
                                        <!-- Displaying the total number of pending leaves -->
                                        <h2 class="h1 mb-0"><?php echo $total_pending_leaves; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card displaying information about approved leaves -->
                <div class="col-xl-4 col-md-12 mb-4" onclick="location.href = 'leave_status.php';">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between p-md-1">
                                <div class="d-flex flex-row">
                                    <div class="align-self-center">
                                        <i class="fa fa-check text-info fa-3x me-4"></i>
                                    </div>
                                    <div>
                                        <h4>Approved Leaves</h4>
                                        <!-- Displaying the total number of approved leaves -->
                                        <h2 class="h1 mb-0"><?php echo $total_approved_leaves; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card displaying information about rejected leaves -->
                <div class="col-xl-4 col-md-12 mb-4" onclick="location.href = 'leave_status.php';">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between p-md-1">
                                <div class="d-flex flex-row">
                                    <div class="align-self-center">
                                        <i class="fa fa-trash text-danger fa-3x me-4"></i>
                                    </div>
                                    <div>
                                        <h4>rejected Leaves</h4>
                                        <!-- Displaying the total number of rejected leaves -->
                                        <h2 class="h1 mb-0"><?php echo $total_rejected_leaves; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
    </div>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/app.js"></script>
    <script src="../assets/vendors/chartjs/Chart.min.js"></script>
    <script src="../assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="../assets/js/pages/dashboard.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>