<nav class="navbar navbar-header navbar-expand navbar-light">
               <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
               <button class="btn navbar-toggler" type="button" data-bs-toggle="collapse"
                  data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                  aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
               </button>
               <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav d-flex align-items-center navbar-light ms-auto">
                    <li class="dropdown nav-icon">
                            <a href="#" data-bs-toggle="dropdown"
                                class="nav-link  dropdown-toggle nav-link-lg nav-link-user">
                                <div class="d-lg-inline-block">

<?php 

include("../config.php");

$isread=0;
$sql_notification = "SELECT tbl_leave_application.leave_id ,tbl_employee.first_name,tbl_employee.last_name,tbl_employee.employee_id,tbl_leave_application.posting_date from tbl_leave_application join tbl_employee on tbl_leave_application.employee_id=tbl_employee.employee_id where tbl_leave_application.IsRead=:isread";
$stmt_notification = $conn -> prepare($sql_notification);
$stmt_notification->bindParam(':isread',$isread,PDO::PARAM_INT);
$stmt_notification->execute();
$resultsN=$stmt_notification->fetchAll(PDO::FETCH_OBJ);
$unreadN = $stmt_notification->rowCount();
?>  
                                    <i data-feather="bell"></i><span class="badge bg-info"><?php echo htmlentities($unreadN) ?></span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-large">
                                <h6 class='py-2 px-4'>Notifications</h6>
                                <ul class="list-group rounded-none">
<?php 
if($stmt_notification->rowCount() > 0)
{
foreach($resultsN as $resultN)
{               ?>  
                                    <li class="list-group-item border-0 align-items-start">
                                        <div class="row mb-2">
                                            <div class="col-md-12 notif">
                                                <a href="leave_details.php?id=<?php echo htmlentities($resultN->leave_id);?>"><h6 class='text-bold'><?php echo htmlentities($resultN->first_name." ".$resultN->last_name);?></h6>
                                                <p class='text-xs'>
                                                    applied for leave at <?php echo htmlentities($resultN->posting_date);?>
                                                </p></a>
                                            </div>
                                        </div>
                                    </li>
<?php }} ?>
                                </ul>
                            </div>
                        </li>
                     <li class="dropdown">
                        <a href="#" data-bs-toggle="dropdown"
                           class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                           <div class="avatar me-1">
                              <img src="../assets/images/admin.png" alt="" srcset="">
                           </div>
                           <div class="d-none d-md-block d-lg-inline-block">Hi, Admin</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                           <a class="dropdown-item" href="#"><i data-feather="user"></i> Account</a>
                           <a class="dropdown-item" href="#"><i data-feather="settings"></i> Settings</a>
                           <div class="dropdown-divider"></div>
                           <a class="dropdown-item" href="../login.php"><i data-feather="log-out"></i> Logout</a>
                        </div>
                     </li>
                  </ul>
               </div>
            </nav>




            
