<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage User</title>

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
                    <h3>Manage User</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php" class="text-success">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage User</li>
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
                                <th>Contact</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Admin Admin</td>
                                <td>09123456789</td>
                                <td>Admin</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td><a href="editDesignation.php"><i class="fa fa-pen text-success"></i></a> <a
                                        href="editDesignation.php"><i class="fa fa-trash text-danger"></i></a></td>
                            </tr>
                            <tr>
                                <td>John Doe</td>
                                <td>09123456789</td>
                                <td>Staff</td>
                                <td><span class="badge bg-success">Active</span></td>
                                <td><a href="editDesignation.php"><i class="fa fa-pen text-success"></i></a> <a
                                        href="editDesignation.php"><i class="fa fa-trash text-danger"></i></a></td>
                            </tr>
                            <tr>
                                <td>Jane Doe</td>
                                <td>09123456789</td>
                                <td>Staff</td>
                                <td><span class="badge bg-danger">Deactivated</span></td>
                                <td><a href="editDesignation.php"><i class="fa fa-pen text-success"></i></a> <a
                                        href="editDesignation.php"><i class="fa fa-trash text-danger"></i></a></td>
                            </tr>
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