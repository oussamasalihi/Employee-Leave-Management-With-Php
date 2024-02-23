<?php 
// Include configuration file
include("../config.php");

// Check if form is submitted
if(isset($_POST['submit'])){
    // Retrieve designation ID, Description , and name from form
    $designation_id = $_POST['designation_id'];
    $designation_description = filter_data($_POST['designation_description']);
    $designation_name = filter_data($_POST['designation_name']);

    // Prepare UPDATE statement
    $sql = "UPDATE tbl_designation SET designation_description = :designation_description, designation_name = :designation_name WHERE designation_id = :designation_id";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':designation_description', $designation_description, PDO::PARAM_STR);
    $stmt->bindParam(':designation_name', $designation_name, PDO::PARAM_STR);
    $stmt->bindParam(':designation_id', $designation_id, PDO::PARAM_INT);

    // Execute the statement
    if($stmt->execute()){
        // Redirect to a success page or display a success message
        $msg = "Designation Updated Successfully";
        header("location: manage_designation.php?msg={$msg}");
        exit;
    } else {
        // Redirect to an error page or display an error message
        $error = "Failed To Update designation ";
    }
}

// Function to sanitize input data
function filter_data($data){
    $data = trim($data);
    $data = stripslashes($data);   
    $data = htmlspecialchars($data);
    return $data;
}

// Fetch designation details for editing
if(isset($_GET['id'])){
    $designation_id = $_GET['id'];
    $sql = "SELECT * FROM tbl_designation WHERE designation_id = :designation_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':designation_id', $designation_id, PDO::PARAM_INT);
    $stmt->execute();
    $designation = $stmt->fetch(PDO::FETCH_OBJ);
    if(!$designation){
        // Redirect to an error page or display an error message
        $error = "Designation not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit designation</title>

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
                    <h3>Edit designation</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="manage_designation.php" class="text-success">Manage designation</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit designation</li>
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

                                        <input type="hidden" name="designation_id" value="<?php echo $designation->designation_id; ?>">

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="first-name-icon">Designation Description</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control"
                                                            placeholder="Input designation" id="first-name-icon" name="designation_description" value="<?php echo $designation->designation_description; ?>" required>
                                                        <div class="form-control-icon">
                                                            <i class="fa fa-table"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group has-icon-left">
                                                    <label for="email-id-icon">Designation Name</label>
                                                    <div class="position-relative">
                                                        <input type="text" class="form-control"
                                                            placeholder="Input designation Name" id="email-id-icon" name="designation_name" value="<?php echo $designation->designation_name; ?>" required>
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
