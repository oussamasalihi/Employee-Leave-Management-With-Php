<?php 
include("../config.php");

// // Check if 'id' parameter is provided in the URL
// if (!isset($_GET['id']) || empty($_GET['id'])) {
//     // Redirect to an error page 
//     $error_message = "There is no id parameter provided in the URL Or Not Found.";
//     header("Location: ../error.php?error=". urlencode($error_message));
//     exit();
// }

// Retrieve leave ID from the URL
$leave_id = intval($_GET['id']);

// code for update the read notification status
$isread=1;
$sql="update tbl_leave_application set IsRead=:isread where leave_id=:leave_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':isread',$isread,PDO::PARAM_INT);
$stmt->bindParam(':leave_id',$leave_id,PDO::PARAM_INT);
$stmt->execute();

// Fetch leave details based on the leave ID
$sql = "SELECT * FROM tbl_leave_application WHERE leave_id = :leave_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":leave_id", $leave_id, PDO::PARAM_INT);
$stmt->execute();
$leave = $stmt->fetch(PDO::FETCH_OBJ); 

// Check if leave details exist
if (!$leave) {
    // Redirect to an error page 
    $error_message = "Leave details not found.";
    header("Location: ../error.php?error=". urlencode($error_message));
    exit();
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
    <title>Edit Leave Application</title>

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
                    <h3>Edit Leave Application</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Leave Application</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Display Error Message -->
        <?php if (!empty($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php } ?>

        <!-- Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="post" action="update_leave.php">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="reference-number">Reference Number</label>
                                                <input type="text" class="form-control" id="reference-number"
                                                    name="reference_number"
                                                    value="<?php echo htmlspecialchars($leave->reference_number); ?>"
                                                    readonly>
                                            </div>
                                        </div>
                                    
                                    
                                    <div class="col-md-6 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="leave-name">Leave Name</label>
                                            <input type="text" class="form-control" id="leave-name" name="leave_name"
                                                value="<?php echo htmlspecialchars($leave->leave_name); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="posting-date">Posting Date</label>
                                            <input type="date" class="form-control" id="posting-date"
                                                name="posting_date"
                                                value="<?php echo htmlspecialchars($leave->posting_date); ?>"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="leave-description">Leave Description</label>
                                            <input type="text" class="form-control" id="leave-description"
                                                name="leave_description"
                                                value="<?php echo htmlspecialchars($leave->leave_description); ?>"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="from-date">From Date</label>
                                            <input type="date" class="form-control" id="from-date" name="from_date"
                                                value="<?php echo htmlspecialchars($leave->from_date); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="to-date">To Date</label>
                                            <input type="date" class="form-control" id="to-date" name="to_date"
                                                value="<?php echo htmlspecialchars($leave->to_date); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="leave-status">Leave Status</label>
                                            <input type="text" class="form-control" id="leave-status"
                                                name="leave_status"
                                                value="<?php echo htmlspecialchars($leave->leave_status); ?>"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="remarks">Remarks</label>
                                            <input type="text" class="form-control" id="remarks" name="remarks"
                                                value="<?php echo htmlspecialchars($leave->remarks); ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group has-icon-left">
                                            <label for="date-of-approval">Date of Approval</label>
                                            <input type="date" class="form-control" id="date-of-approval"
                                                name="date_of_approval"
                                                value="<?php echo htmlspecialchars($leave->date_of_approval); ?>"
                                                readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1"
                                                name="submit">Update</button>
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
    <!-- Basic multiple Column Form section end -->
    </div>

    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/app.js"></script>

    <script src="../assets/js/main.js"></script>
</body>

</html>