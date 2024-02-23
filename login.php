</html>
<?php 
session_start();
include("config.php");

// If Login
$username = $email = $password = '';
if(isset($_POST["login"])){
    $username = filter_data($_POST["username"]);

    $sql = "SELECT employee_id, first_name, Password, account_status FROM tbl_employee WHERE username=:username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Fetch The results
    $results = $stmt->fetchAll(PDO::FETCH_OBJ);
    if($stmt->rowCount() > 0){
        foreach($results as $result){
            if (password_verify($_POST["password"], $result->Password)) {
                // Password is correct, check account status
                if ($result->account_status == 1) {
                    // Account is active, proceed with login
                    $_SESSION["employee_id"] = $result->employee_id;
                    $_SESSION["first_name"] = $result->first_name;
                    $_SESSION["username"] = $username;
                    header("Location: Employee/update_password.php");
                    exit; 
                } else {
                    // Account is inactive
                    $errors[] = "Your account is inactive. Please contact the administrator.";
                }
            } else {
                // Password is incorrect
                $errors[] = "Incorrect password.";
            }
        }
    } else {
        // Username not found
        $errors[] = "Username not found.";
    }
}

// Function To Filter Data
function filter_data($data){
    $data = trim($data);
    $data = stripslashes($data);   
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
    <!-- Google recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script> <!-- Add reCAPTCHA script -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script defer src="assets/fontawesome/js/all.min.js"></script>
    <link rel="stylesheet" href="assets/css/app.css">
</head>

<body>
    <div id="auth">

        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center mb-5">
                                <h3>Sign In</h3>
                            </div>
                            <!-- Error message -->
                                <?php 
                                    if(isset($errors)){
                                    foreach ($errors as $error) {
                                        echo "<span>".$error."</span>";
                                    }
                                    }
                                ?>
                            <form action="login.php" method="post">
                                <div class="form-group position-relative has-icon-left">
                                    <label for="username">Username</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control" id="username" name="username" required>
                                        <div class="form-control-icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="clearfix">
                                        <label for="password">Password</label>
                                        <!-- <a href="#" class='float-end'>
                                            <small>Forgot password?</small>
                                        </a> -->
                                    </div>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <div class="form-control-icon">
                                            <i class="fa fa-key"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class='form-check clearfix my-4'>
                                    <div class="checkbox float-start">
                                        <a href="Admin/index.php" class='float-end'>
                                            <small>admin</small>
                                        </a>
                                    </div>
                                </div>
                                <!-- reCAPTCHA widget -->
                                <div class='form-group clearfix my-4'>
                                    <div class="g-recaptcha" data-sitekey="6LduhXYpAAAAAL22z6Uv_eTjNyZqwulnEiBshKGz"></div> 
                                </div>
                                <div class="clearfix">
                                    <button class="btn btn-primary float-end" id="login" name="login" >Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>

    <script src="assets/js/main.js"></script>
    <!-- Script To check if recaptcha verified -->
    <script>
        $(document).on('click', '#login', function() {
        var response = grecaptcha.getResponse();
        if (response.length == 0) {
            alert("Please verify you are not a robot.");
            return false;
        }
        });
    </script>

</body>

</html>

