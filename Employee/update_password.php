<?php 

session_start();
include("../config.php");

// If change Password
if (isset($_POST["updatePassword"])) {
    $oldPassword = $_POST["oldPassword"];
    $newPassword = $_POST["newPassword"];
    $newCPassword = $_POST["newCPassword"];
    $employee_id = $_SESSION["employee_id"];
    
    // Retrieve the hashed password from the database
    $sql = "SELECT password FROM tbl_employee WHERE employee_id = :employee_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":employee_id", $employee_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    
    // Verify the old password
    if ($result && password_verify($oldPassword, $result->password)) {
        if ($newPassword == $newCPassword) {
            $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            // Update the password
            $sql = "UPDATE tbl_employee SET password = :newPassword WHERE employee_id = :employee_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":newPassword", $newHashedPassword, PDO::PARAM_STR);
            $stmt->bindParam(":employee_id", $employee_id, PDO::PARAM_INT);
            $stmt->execute();
            $msg = "Your Password has been successfully changed.";
        } else {
            $error = "Please confirm your new password correctly.";
        }
    } else {
        $error = "Your current password is wrong!";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>

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
                    <h3>Update Password</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update Password</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>


        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-8">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" method="post">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group has-icon-left">

                                                    <!-- Display Error Message -->
                                                <?php if (!empty($error)) { ?>
                                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                                <?php } ?>
                                                <!-- Display Success Message -->
                                                <?php if (!empty($msg)) { ?>
                                                    <div class="alert alert-success"><?php echo $msg ?></div>
                                                <?php } ?>
                                                    
                                                    <br>
                                                <label for="first-name-icon">Old Password</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control"
                                                        placeholder="old password" id="first-name-icon" name="oldPassword" required>
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-key"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">New Password</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control"
                                                        placeholder="new password" id="first-name-icon" name="newPassword" required>
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-key"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group has-icon-left">
                                                <label for="first-name-icon">Confirm Password</label>
                                                <div class="position-relative">
                                                    <input type="password" class="form-control"
                                                        placeholder="confirm passsword" id="first-name-icon" name="newCPassword" required>
                                                    <div class="form-control-icon">
                                                        <i class="fa fa-key"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1" name="updatePassword">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
    </div>

    </div>
    </div>
    <script src="../assets/js/feather-icons/feather.min.js"></script>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/app.js"></script>

    <script src="../assets/js/main.js"></script>
</body>

</html>