<?php
// Include the database connection file
include("../config.php");

    // Fetch leave types from the database
    $sql = "SELECT * FROM tbl_leave_type";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $leave_types = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Check if employee ID is provided for deletion
    if(isset($_GET['id'])) {
        $leave_type_id = $_GET['id'];
        // Prepare DELETE statement
        $sql = "DELETE FROM tbl_leave_type WHERE leave_type_id = :leave_type_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':leave_type_id', $leave_type_id, PDO::PARAM_INT);
        // Execute the statement
        if($stmt->execute()) {
            $msg = "Leave type Deleted Successfully";
            header("location: manage_leave_type.php?msg={$msg}");
            exit;
        } else {
            $error = "Failed to Delete Leave type";
        }
    }
    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leave Type</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/vendors/simple-datatables/style.css">
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
                    <h3>Manage Leave Type</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Leave Type</li>
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
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class='table' id="table1">
                        <thead>
                            <tr>
                                <th>Leave Name</th>
                                <th>Description</th>
                                <th>Days Allowed</th>
                                <th>Creation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($leave_types as $leave): ?>
                            <tr>
                                <td><?php echo $leave->leave_name; ?></td>
                                <td><?php echo $leave->leave_description; ?></td>
                                <td><?php echo $leave->number_days_allowed; ?></td>
                                <td><?php echo $leave->creation_date; ?></td>
                                <td>
                                    <a href="editleavetype.php?id=<?php echo $leave->leave_type_id; ?>"><i
                                            class="fa fa-pen text-success"></i></a>
                                    <a href="manage_leave_type.php?id=<?php echo $leave->leave_type_id; ?>" onclick="return confirm('Are u sure you want to delete this Leave ?')"><i
                                            class="fa fa-trash text-danger"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
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