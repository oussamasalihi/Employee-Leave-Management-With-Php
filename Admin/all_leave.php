<?php 
try {

    include("../config.php");
    
    $sql = "SELECT leave_id , tbl_leave_application.employee_id, tbl_employee.first_name, tbl_employee.last_name, leave_name, posting_date, leave_status FROM tbl_leave_application JOIN tbl_employee on tbl_leave_application.employee_id = tbl_employee.employee_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);

} catch (\Throwable $th) {
    echo "", $th->getMessage(),"";
}    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Leaves Application</title>

    <link rel="stylesheet" href="../assets/css/bootstrap.css">

    <link rel="stylesheet" href="../assets/vendors/simple-datatables/style.css">

    <script defer src="../assets/fontawesome/js/all.min.js"></script>
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
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Leave Application</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Leave Application</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class='table' id="table1">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Leave Type</th>
                                <th>Posting Date</th>
                                <th>leave_status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($stmt->rowCount() >0) {
                                foreach($results as $result){?>
                            <tr>
                                <td><?php echo $result->first_name . " " . $result->last_name; ?></td>
                                <td><?php echo $result->leave_name; ?></td>
                                <td><?php echo $result->posting_date; ?></td>
                                <td>
                                    <?php $stats = $result->leave_status;
                                    if ($stats == 0) {
                                        ?>
                                        <span class="badge bg-info">Pending</span>
                                        <?php }
                                    if ($stats == 1) { ?>
                                        <span class="badge bg-success">Approved</span>
                                        <?php }
                                    if ($stats == 2) { ?>
                                        <span class="badge bg-danger">Not Approved</span>
                                    <?php } ?>
                                </td>
                                <td><a href="leave_details.php?id=<?php echo $result->leave_id ?>"><i class="fa fa-eye text-success"></i></a></td>
                            </tr>
                            <?php }} ?>
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
