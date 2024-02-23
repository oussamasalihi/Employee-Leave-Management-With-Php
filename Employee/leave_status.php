<?php
session_start();
    include("../config.php");

    try {
        $employee_id = $_SESSION["employee_id"];
        // Query to fetch leave data from the database
        $sql = "SELECT  leave_name, from_date, to_date, posting_date, remarks, leave_status FROM tbl_leave_application where employee_id=:employee_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam("employee_id",$employee_id, PDO::PARAM_INT);
        $stmt->execute();
        $leaveData = $stmt->fetchAll(PDO::FETCH_OBJ);
    } catch (\Throwable $th) {
        die('Error: ' . $th->getMessage());
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Status</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/vendors/simple-datatables/style.css">
    <link rel="stylesheet" href="../assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="../assets/css/app.css">
    <script defer src="../assets/fontawesome/js/all.min.js"></script>
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
                    <h3>Manage Leave Status</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Leave Status</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Display Success Message -->
        <?php if (!empty($_GET["msg"])) { ?>
        <div class="alert alert-success"><?php echo $_GET["msg"]; ?></div>
        <?php } ?>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class='table' id="table1">
                        <thead>
                            <tr>
                                <th>Leave Type</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Posting Date</th>
                                <th>Remark</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Loop through the fetched leave data and display it in the table
                            foreach ($leaveData as $leave) {
                            ?>
                            <tr>
                                <td><?php echo $leave->leave_name; ?></td>
                                <td><?php echo $leave->from_date; ?></td>
                                <td><?php echo $leave->to_date; ?></td>
                                <td><?php echo $leave->posting_date; ?></td>
                                <td>
                                    <?php 
                                        echo $leave->remarks ? $leave->remarks : 'waiting for approval';
                                    ?>
                                </td>

                                <td>
                                    <?php 
                                        switch ($leave->leave_status) {
                                            case 0:
                                                echo '<span class="badge bg-info">Pending</span>';
                                                break;
                                            case 1:
                                                echo '<span class="badge bg-success">Approved</span>';
                                                break;
                                            case 2:
                                                echo '<span class="badge bg-danger">Rejected</span>';
                                                break;
                                            default:
                                                echo 'Unknown';
                                                break;
                                        }
                                    ?>
                                </td>

                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/app.js"></script>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/js/vendors.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>