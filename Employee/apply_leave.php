<?php
// Include database connection and any other necessary files
try {
session_start();
    include("../config.php");
    

// Function to generate a reference number
function generateReferenceNumber() {
    // generate a unique reference number with the format REF-XXXXX (XXXXX is a random 5-digit number)
    $uniqueRefID = 'REF-' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
    return $uniqueRefID;
}

// Check if the form is submitted
if(isset($_POST['submit'])) {
    // Retrieve form data
    $reference_number = $_POST['reference_number'];
    $employee_id = $_SESSION["employee_id"];
    $leave_name = $_POST['leave_name'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $leave_description = $_POST["leave_description"]  ;


    // Insert data into the database
        $sql = "INSERT INTO tbl_leave_application (reference_number, employee_id, from_date, to_date, leave_description, leave_name, leave_status) 
            VALUES (:reference_number, :employee_id, :from_date, :to_date, :leave_description, :leave_name, :leave_status)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':reference_number', $reference_number);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->bindParam(':leave_name', $leave_name);
        $stmt->bindParam(':from_date', $from_date);
        $stmt->bindParam(':to_date', $to_date);
        $stmt->bindParam(':leave_description', $leave_description);
        $stmt->bindValue(':leave_status', 0); // Assuming the default status is pending
        $stmt->execute();

    // Check if the insertion was successful
    if($stmt->rowCount() > 0) {
        // Data inserted successfully
        // Redirect to a success page or do any additional processing
        $msg = "Leave Submit successfully.";
        header("Location: leave_status.php?msg={$msg}");
        exit();
    } else {
        // Failed to insert data
        // Handle the error appropriately, display an error message, or redirect to an error page
        $error =  "Failed to submit leave. Please try again.";
    }
}
} catch (\Throwable $th) {
    die('Error: ' . $th->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave</title>

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
                    <h3>Apply for Leave</h3>
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
                                <form class="form" method="post" action="apply_leave.php">
                                    <div class="row">
                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="reference-number">Reference Number</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" id="reference-number"
                                                        name="reference_number"
                                                        value="<?php echo generateReferenceNumber(); ?>" readonly>
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-hash"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="leave-type">Select Leave Type</label>
                                                <div class="position-relative">
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="leave-type" name="leave_name">
                                                            <?php
                    // Fetch leave types from tbl_leave_type
                    $sql = "SELECT * FROM tbl_leave_type";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $leave_types = $stmt->fetchAll(PDO::FETCH_OBJ);

                    // Check if leave types exist
                    if ($stmt->rowCount() > 0) {
                        foreach ($leave_types as $leave_type) {
                            echo "<option value='" . $leave_type->leave_name . "'>" . $leave_type->leave_name . "</option>";
                        }
                    } else {
                        echo "<option value='' disabled>No leave types available</option>";
                    }
                    ?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="from-date">From Date</label>
                                                <div class="position-relative">
                                                    <input type="date" class="form-control" id="from-date"
                                                        name="from_date" required>
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="to-date">To Date</label>
                                                <div class="position-relative">
                                                    <input type="date" class="form-control" id="to-date" name="to_date"
                                                        required>
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="leave-description">Leave Description</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" id="leave-description" name="leave_description" placeholder="Enter leave description" required>
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1"
                                                name="submit">Submit</button>
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