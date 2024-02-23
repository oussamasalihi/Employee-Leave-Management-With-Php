<?php 
// Include Configuration File 
include("../config.php");

// Fetch designation Data from the database
$sql = "SELECT * FROM tbl_designation";
$stmt = $conn->prepare($sql);
$stmt->execute();
$designations = $stmt->fetchAll(PDO::FETCH_OBJ);    

// Check if designation ID is provided for deletion
if(isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Prepare DELETE statement
    $sql = "DELETE FROM tbl_designation WHERE designation_id = :delete_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    // Execute the statement
    if($stmt->execute()) {
        $msg = "designation Deleted Successfully";
        header("location: manage_designation.php?msg={$msg}");
        exit;
    } else {
        $error = "Failed to Delete designation";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Designation</title>

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
                    <h3>Manage designation</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage designation</li>
                        </ol>
                    </nav>
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

        </div>
        
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class='table' id="table1">
                        <thead>
                            <tr>
                                <th>Designation Name</th>
                                <th>Designation Short Name</th>
                                <th>Creation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($designations as $designation) {?>
                            <tr>
                                <td><?php echo htmlentities($designation->designation_name) ?></td>
                                <td><?php echo htmlentities($designation->designation_description) ?></td>
                                <td><?php echo htmlentities($designation->creation_date) ?></td>
                                <td>
                                    <a href="editdesignation.php?id=<?php echo $designation->designation_id ?>"><i class="fa fa-pen text-success"></i></a> 
                                    <a href="manage_designation.php?delete_id=<?php echo $designation->designation_id ?>" onclick="return confirm('Are you sure you want to delete this designation?')"><i class="fa fa-trash text-danger"></i></a>
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
