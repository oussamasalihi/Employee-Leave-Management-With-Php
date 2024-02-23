<?php 
// Include configuration file
include("../config.php");

// Check if form is submitted
if(isset($_POST['submit'])){
    // Retrieve department ID, short name, and name from form
    $department_id = $_POST['department_id'];
    $department_short_name = filter_data($_POST['department_short_name']);
    $department_name = filter_data($_POST['department_name']);

    // Prepare UPDATE statement
    $sql = "UPDATE tbl_department SET department_short_name = :department_short_name, department_name = :department_name WHERE department_id = :department_id";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':department_short_name', $department_short_name, PDO::PARAM_STR);
    $stmt->bindParam(':department_name', $department_name, PDO::PARAM_STR);
    $stmt->bindParam(':department_id', $department_id, PDO::PARAM_INT);

    // Execute the statement
    if($stmt->execute()){
        // Redirect to a success page or display a success message
        $msg = "Department Updated Successfully";
        header("location: manage_department.php?msg={$msg}");
        exit;
    } else {
        // Redirect to an error page or display an error message
        $error = "Failed To Update Department ";
    }
}

// Function to sanitize input data
function filter_data($data){
    $data = trim($data);
    $data = stripslashes($data);   
    $data = htmlspecialchars($data);
    return $data;
}

// Fetch department details for editing
if(isset($_GET['id'])){
    $department_id = $_GET['id'];
    $sql = "SELECT * FROM tbl_department WHERE department_id = :department_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':department_id', $department_id, PDO::PARAM_INT);
    $stmt->execute();
    $department = $stmt->fetch(PDO::FETCH_OBJ);
    if(!$department){
        // Redirect to an error page or display an error message
        $error = "Department not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department</title>

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
                    <h3>Edit Department</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="manage_department.php" class="text-success">Manage Department</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Department</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>


        <!-- Basic Vertical form layout section start -->
        <section id="basic-vertical-layouts">
            <div class="row match-height">
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-vertical" method="post">
                                    <div class="form-body">
                                        <!-- Display Error Message -->
                                        <?php if (!empty($error)) { ?>
                                            <div class="alert alert-danger"><?php echo $error; ?></div>
                                        <?php } ?>

                                        <input type="hidden" name="department_id" value="<?php echo $department->department_id; ?>">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="first-name-icon">Department Short Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control"
                                                            placeholder="Input Department" id="first-name-icon" name="department_short_name" value="<?php echo $department->department_short_name; ?>" required>
                                                        <div class="form-control-icon">
                                                            <i class="fa fa-table"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="email-id-icon">Department Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control"
                                                            placeholder="Input Department Name" id="email-id-icon" name="department_name" value="<?php echo $department->department_name; ?>" required>
                                                        <div class="form-control-icon">
                                                            <i class="fa fa-table"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" name="submit" class="btn btn-primary me-1 mb-1">Submit</button>
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
</body>

</html>
