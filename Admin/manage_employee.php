<?php
    // Include Configuration File 
    include("../config.php");

    // Fetch employee Data from the database
    $sql = "SELECT * FROM tbl_employee";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $employees = $stmt->fetchAll(PDO::FETCH_OBJ);

    // Check if employee ID is provided for deletion
    if(isset($_GET['delete_id'])) {
        $employee_id = $_GET['delete_id'];
        // Prepare DELETE statement
        $sql = "DELETE FROM tbl_employee WHERE employee_id = :employee_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':employee_id', $employee_id, PDO::PARAM_INT);
        // Execute the statement
        if($stmt->execute()) {
            $msg = "Employee Deleted Successfully";
            header("location: manage_employee.php?msg={$msg}");
            exit;
        } else {
            $error = "Failed to Delete Employee";
        }
    }

    // Check if employee ID is provided for editing
    if(isset($_GET['edit_id'])) {
        $edit_id = $_GET['edit_id'];
        // Fetch employee details
        $sql = "SELECT * FROM tbl_employee WHERE employee_id = :edit_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':edit_id', $edit_id, PDO::PARAM_INT);
        $stmt->execute();
        $employee = $stmt->fetch(PDO::FETCH_OBJ);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employee</title>

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
                    <h3>Manage Employee</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Employee</li>
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
                                <th>Emp ID</th>
                                <th>Full Name</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Reg Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($employees as $employee) {?>
                                <tr>
                                    <td><?php echo htmlentities($employee->employee_id) ?></td>
                                    <td><?php echo htmlentities($employee->first_name);?>&nbsp;<?php echo htmlentities($employee->last_name);?></td>
                                    <td><?php echo htmlentities($employee->department_short_name) ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo ($employee->account_status == 1) ? 'success' : 'danger'; ?>">
                                            <?php echo ($employee->account_status == 1) ? 'Active' : 'Inactive'; ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlentities($employee->reg_date) ?></td>
                                    <td>
                                        <a href="editEmployee.php?edit_id=<?php echo $employee->employee_id ?>"><i class="fa fa-pen text-success"></i></a> 
                                        <a href="manage_employee.php?delete_id=<?php echo $employee->employee_id ?>" onclick="return confirm('Are you sure you want to delete this employee?')"><i class="fa fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </section>
    </div>
    </div>
    </div>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/app.js"></script>

    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/js/vendors.js"></script>

    <script src="../assets/js/main.js"></script>
</body>

</html>

