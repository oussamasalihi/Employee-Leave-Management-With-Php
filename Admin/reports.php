<?php 
// Including the configuration file
include("../config.php");

// SQL query to get the number of pending leaves
$sql_pending_leaves = "SELECT count(*) AS total_pending_leaves FROM tbl_leave_application WHERE leave_status = 0";
$stmt_pending_leaves = $conn->prepare($sql_pending_leaves);
$stmt_pending_leaves->execute();
// Fetching the number of pending leaves
$total_pending_leaves = $stmt_pending_leaves->fetchColumn();

// SQL query to get the number of approved leaves
$sql_approved_leaves = "SELECT count(*) AS total_approved_leaves FROM tbl_leave_application WHERE leave_status = 1";
$stmt_approved_leaves = $conn->prepare($sql_approved_leaves);
$stmt_approved_leaves->execute();
// Fetching the number of approved leaves
$total_approved_leaves = $stmt_approved_leaves->fetchColumn();

// SQL query to get the number of rejected leaves
$sql_rejected_leaves = "SELECT count(*) AS total_rejected_leaves FROM tbl_leave_application WHERE leave_status = 2";
$stmt_rejected_leaves = $conn->prepare($sql_rejected_leaves);
$stmt_rejected_leaves->execute();
// Fetching the number of rejected leaves
$total_rejected_leaves = $stmt_rejected_leaves->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>

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
                    <h3>Reports</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Reports</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>


        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-12 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card-body">
                                                    <div class="chart chart-lg">
                                                        <canvas id="chartjs-pie"></canvas>
                                                    </div>
                                                </div>
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
    </div>
    </div>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/app.js"></script>

    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/chart.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pie chart
        new Chart(document.getElementById("chartjs-pie"), {
            type: "pie",
            data: {
                labels: ["Approved", "Pending", "Cancelled"],
                datasets: [{
                    data: [<?php echo $total_approved_leaves.",".$total_pending_leaves.",".$total_rejected_leaves ?>],
                    backgroundColor: [
                        window.theme.primary,
                        window.theme.warning,
                        window.theme.danger,
                    ],
                    borderColor: "transparent"
                }]
            },
            options: {
                maintainAspectRatio: true,
                legend: {
                    display: true
                }
            }
        });
    });
    </script>
</body>

</html>