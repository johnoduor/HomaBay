<?php
    
    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $admindata = get_admin_data($_SESSION['id']);
    
    $_SESSION['updateSuccess'] = "";
    $_SESSION['updateError'] = "";

    if (isset($_POST['addDoctor'])) {// add new doctor
        $name = $conn->real_escape_string($_POST['name']);
        $department = $conn->real_escape_string($_POST['department']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $doctor_address = $conn->real_escape_string($_POST['doctor_address']);
        $phone = $conn->real_escape_string($_POST['phone']);

        if (empty($name) || empty($department) || empty($email) || empty($password) || empty($doctor_address) || empty($phone)) {
            $_SESSION['updateError'] = "<div class='updateError'>All form are mendatory</div>";
        }

        if ($name && $department && $email && $password && $doctor_address && $phone) {
            if (if_doctorNameExist($name) === TRUE) {
                $_SESSION['updateError'] = "<div class='updateError'>Doctor $name name already exist</div>";
            } else {
                if (if_doctorPhoneExist($phone) === TRUE) {
                    $_SESSION['updateError'] = "<div class='updateError'>Doctor $name name already exist</div>";
                } else {
                    if (addNewDoctor() === TRUE) {
                        $_SESSION['updateSuccess'] = "<div class='profileSuccess'><strong>New $name Department</strong> Is Added Successful.</div>";
                    } else {
                        $_SESSION['updateError'] = "<div class='updateError'><strong>Error While adding new department.</div>";
                    }
                }
            }
        }
    }

    if (isset($_POST['editDoctorData'])) { // update doctor data
        $id = $conn->real_escape_String($_POST['txtid']);
        $name = $conn->real_escape_String($_POST['txtname']);
        $department = $conn->real_escape_String($_POST['txtdepartment']);
        $email = $conn->real_escape_String($_POST['txtemail']);

        if (empty($name) || empty($department) || empty($email)) {
            $_SESSION['updateError'] = "<div class='updateError'>updating field required</div>";
        }

        if ($name && $department && $email) {
            $updateDoctorName_exist = checkUpdateDoctorName_exist($id, $name);
            if ($updateDoctorName_exist) {
                $_SESSION['updateError'] = "<div class='updateError'>Doctor $name already exist</div>";
            } else {
                if (updateDoctorData($id) === TRUE) {
                    $_SESSION['updateSuccess'] = "<div class='profileSuccess'>Successfull updated doctor data</div>";
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'>Error while updating data</div>";
                }
            }
        }
    }

    if (isset($_GET['delete'])) {// delete doctor account
        $id = $_GET['delete'];

        if (deleteDoctorAccount($id) === TRUE) {
            echo "<script>window.location.href='administrator_doctor.php'</script>";
        } else {
            echo "<script>alert('deleteing data fail. try again')</script>";
        }
    }

?>

<!DOCTYPE Html>
<Html lang="en">
<head>    
     <!-- Include meta tag to ensure proper rendering and touch zooming -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="Online Advance Management Software. This Software is Expert and manage all Clinic and more..?">
		<meta name="author" content="Schneider Michael">
    <title>Manage Doctor | HomaBay Hospital</title>
    
    <?php include('includes/adminoverall-header.php'); ?>

    <link rel="stylesheet" href="css/style/administrator/allstyle.css">

</head>
    <style>
    </style>

<body>

    <header>
        <?php include('includes/header/admin-header.php'); ?>
    </header>
<br>
    <div id="container" class="">
        <div class="sidebar">
            <ul id="nav" class="nav sidebar-nav">
                <li class="myBlogsiteDashboard_profile">
                    <?php
                        if ($admindata['profile'] == "") {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/default.png' alt='Default Profile'></span>";
                        } else {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/".$row['profile']."' alt='Upload Profile'></span>";
                        }
                        
                        echo "<span>".$admindata['name']."</span>";
                    ?>
                </li>
                <li>
                    <a href="administrator_home.php">
                       <i class="fa fa-desktop fa-2x"></i> 
                       <span> Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="administrator_department.php">
                        <i class="fa fa-sitemap fa-2x"></i> 
                        <span> Department</span>
                    </a>
                </li>
                <li class="active">
                   <a href="administrator_doctor.php">
                       <i class="fa fa-user-md fa-2x"></i> 
                       <span> Doctor</span>
                    </a>
                </li> 
                <li>
                   <a href="administrator_nurse.php">
                       <i class="fa fa-plus-square fa-2x"></i> 
                       <span> Nurse</span>
                    </a>
                </li>
                <li>
                    <a href="administrator_patient.php">
                       <i class="fa fa-user fa-2x"></i> 
                       <span> Patient</span>
                    </a>
                </li>
                <li>
                    <a href="administrator_pharmacist.php">
                       <i class="fa fa-medkit fa-2x"></i> 
                       <span> Pharmacist</span>
                    </a>
                </li>
                <li>
                    <a href="administrator_laboratory.php">
                       <i class="fa fa-flask fa-2x"></i> 
                       <span> Laboratorist</span>
                    </a>
                </li>
                <li>
                    <a href="administrator_accountant.php">
                       <i class="fa fa-money fa-2x"></i> 
                       <span> Accountant</span>
                    </a>
                </li>

                <li>
                    <a href="administrator_careTaker.php">
                       <i class="fa fa-google-wallet fa-2x"></i> 
                       <span> CareTaker</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu1">
                       <i class="fa fa-crosshairs fa-2x"></i> 
                       <span>Manage Hospital <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="administrator_viewAppointment.php">
                                <i class="fa fa-exchange"></i> View Appointments
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="administrator_viewPayment.php">
                               <i class="fa fa-credit-card"></i> View Payment
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="administrator_viewMedicine.php">
                                <i class="fa fa-medkit"></i> View Medicine
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="administrator_viewBedStatus.php">
                                <i class="fa fa-hdd-o"></i> View Bed Status
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="administrator_viewBloodBank.php">
                                <i class="fa fa-fire"></i> View Blood Bank
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="administrator_viewOperation.php">
                                <i class="fa fa-bars"></i> View Operation
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="administrator_viewBirthReport.php">
                                <i class="fa fa-reddit-alien"></i>View Birth Report
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="administrator_viewDeathReport.php">
                                <i class="fa fa-minus-circle"></i>View Death Report
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu1">
                       <i class="fa fa-gear fa-2x"></i> 
                       <span> Settings <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="administrator_manageNoticBoard.php">
                           <i class="fa fa-columns"></i> Manage Noticboard
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="administrator_systemSetting.php">
                           <i class="fa fa-h-square"></i> System Setting
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="administrator_profile.php">
                            <i class="fa fa-globe"></i> Profile
                        </a></li>
                    </ul>
                </li> 
            </ul>
        </div>
    </div>

    <!-- second navbar -->
    <div id="second-navbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <form>
                        <div class="form-group page-header">
                            <h3> <i class="fa fa-info-circle"></i> Manage Doctor</h3>
                        </div>
                    </form><!-- end form -->
                </div>
            </div><!-- end row -->
        </div>
    </div><!-- end second-navbar -->
<br>
    <div class="container" id="PageContainer">
        <div class="departmentlistTable col-lg-8 col-lg-offset-2">
            <ul class="nav nav-tabs">
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> Doctor List</a></li>
               <li class="departmentTab" data-toggle="tab" data-target="#departmentAdd"><a href="#"><i class="fa fa-plus"></i> Add Doctor</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active fade in" id="departmentList">
                    <!-- Displaying Error Here -->
                    <div class="displayError">
                        <?php if (isset($_SESSION['updateSuccess'])):?>
                            <span class='closebtn' onclick='this.parentElement.style.display="none";'>&times;</span>
                            <p>
                                <?php
                                   echo $_SESSION['updateSuccess'];
                                   unset($_SESSION['updateSuccess']);
                                ?>
                                <?php
                                   echo $_SESSION['updateError'];
                                   unset($_SESSION['updateError']);
                                ?>
                            </p>
                        <?php endif ?>
                    </div>
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Doctor Name</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Doctor Name</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                       </tfoot>
                    </table>

                    <!-- create modal dialog detail info for edit on button  cell click -->
                    <div class="modal fade" id="myModalEdit" role="dialog">
                        <div class="modal-dialog">
                            <div id="content-data">
                                
                            </div><!-- end content-data -->
                        </div><!-- end-modal-dialog -->
                    </div>

                </div><!-- end tab pane for Department List  -->

                <div class="tab-pane fade" id="departmentAdd">
                    <div class="departmentForm">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="department-name" class="control-label col-lg-4">Doctor Name</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" name="name">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="doctor-department" class="control-label col-lg-4">Department Name</label>
                                <div class="col-lg-6">
                                    <?php
                                        $sql = "SELECT * FROM departmentfiles";
                                        $query = $conn->query($sql);
                                        
                                    ?>
                                    <select name="department" class="form-control" id="">
                                        <?php while ($row = $query->fetch_array()): ?>
                                            <option name="department"><?php echo $row[1];?></option>
                                        <?php endwhile?>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="doctor-email" class="control-label col-lg-4">Email</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="email">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="doctor-password" class="control-label col-lg-4">Password</label>
                                <div class="col-lg-6">
                                   <input type="password" class="form-control" name="password">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="doctor-address" class="control-label col-lg-4">Address</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="doctor_address">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="doctor-phone" class="control-label col-lg-4">Phone</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" size=20 maxlength=10 onkeypress='return isNumberKey(event)' name="phone">
                                </div>
                            </div><!-- end form-group -->
                            <br>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                   <button type="submit" name="addDoctor" class="btn btn-info">Add Doctor</button>
                                </div>
                            </div><!-- end form-group -->
                        </form>
                    </div>
                </div><!--  end tab pane for Add department  -->
            </div>
        </div>
    </div><!-- end container -->
    
    
    <div class="contaienr"></div>

    <!-- Footer -->
    <footer>
        <form class="AdminFooter">
            <?php include("includes/footer/footer.php") ?>
        </form>
    </footer>

    <script>
        $(document).ready(function() {
            var dataTable = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url:"core/administrator_data/doctorFetch.php",
                    type:"post"
                }
            });
        });

        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>

    <!--  Script for getEdit data  -->
    <script> 
        $(document).on('click','#getEdit',function(e) {
            e.preventDefault();
            var per_id=$(this).data('id');
            $('#content-data').html('');
            $.ajax({
                url: 'core/administrator_data/editDoctor.php',
                type: 'POST',
                data: 'id='+per_id,
                dataType: 'html'
            }).done(function(data) {
                $('#content-data').html('');
                $('#content-data').html(data);
            }).fial(function() {
                $('#content-data').html('<p>Error</p>');
            });
        });
    </script>
	
	<!-- script src="js/main/bootstrap.js"></script -->
   
</body>
</Html>

