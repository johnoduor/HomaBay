<?php

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $doctordata = get_doctor_data($_SESSION['id']);

    $_SESSION['updateSuccess'] = "";
    $_SESSION['updateError'] = "";

    if (isset($_POST['addAppointment'])) {// add Appointment
        $doctor_name = $conn->real_escape_string($_POST['doctor_name']);
        $doctor_department = $conn->real_escape_string($_POST['doctor_department']);
        $patient_name = $conn->real_escape_string($_POST['patient_name']);
        $appointment_date = $conn->real_escape_string($_POST['appointment_date']);

        if (empty($doctor_name) || empty($doctor_department) || empty($patient_name) || empty($appointment_date)) {
            $_SESSION['updateError'] = "<div class='updateError'>All field are mendatory</div>";
        }

        if ($doctor_name && $doctor_department && $patient_name && $appointment_date) {
            if (if_appointmentDateExist($appointment_date) === TRUE) {
                $_SESSION['updateError'] = "<div class='updateError'>$appointment_date!! name already exist</div>";
            } else {
                if (addNewAppointment() === TRUE) {
                    $_SESSION['updateSuccess'] = "<div class='profileSuccess'><strong>New Appointment</strong> Is Added Successful.</div>";
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'><strong>Error While adding new appointment.</div>";
                }
            }
        }
    }

    if (isset($_POST['editAppointmentData'])) {// update appointmeent
        $id = mysqli_real_escape_string($conn, $_POST['txtid']);
        $date = mysqli_real_escape_string($conn, $_POST['txtdate']);

        if (empty($date)) {
            $_SESSION['updateError'] = "<div class='updateError'>updating field required</div>";
        }

        if ($date) {
            $updateAppointmentDate_exist = check_if_appointmentUpdateDate_exist($id, $date);
            if ($updateAppointmentDate_exist) {
                $_SESSION['updateError'] = "<div class='updateError'>Nurse! $date already exist</div>";
            } else {
                if (updateAppoinmentData($id) === TRUE) {
                    $_SESSION['updateSuccess'] = "<div class='profileSuccess'>Successfull updated appointment date</div>";
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'>Error while updating appointment data</div>";
                }
            }
        }
    }

    if (isset($_GET['delete'])) {// delete appointment data
        $id = $_GET['delete'];

        if (deleteAppointmentAccount($id) === TRUE) { // delete Patient account
            echo "<script>window.location.href='doctor_manageAppointment.php'</script>";
        } else {
            echo "<script>alert('deleting data fail. try again')</script>";
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
    <title>Manage Appointment | HomaBay Hospital</title>
    
    <?php include('includes/doctoroverall-header.php'); ?>

    <link rel="stylesheet" href="css/style/doctor/patient_more.css">


</head>
    <style>
    </style>

<body>

    <header>
        <?php include('includes/header/doctor-header.php'); ?>
    </header>
<br>
    <div id="container" class="container">
        <div class="sidebar">
            <ul id="nav" class="nav sidebar-nav">
                <li class="myBlogsiteDashboard_profile">
                    <?php
                        if ($doctordata['profile'] == "") {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/doctorDefault.jpg' alt='Default Profile'></span>";
                        } else {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/".$doctordata['profile']."' alt='Upload Profile'></span>";
                        }
                        
                        echo "<span>".$doctordata['name']."</span>";
                    ?>
                </li>
                <li>
                    <a href="doctor_home.php">
                       <i class="fa fa-desktop fa-2x"></i> 
                       <span> Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="doctor_patient.php">
                       <i class="fa fa-user fa-2x"></i> 
                       <span> Patient</span>
                    </a>
                </li>
                <li class="active">
                    <a href="doctor_manageAppointment.php">
                       <i class="fa fa-pencil-square-o fa-2x"></i> 
                       <span> Manage Appointments</span>
                    </a>
                </li>
                <li>
                    <a href="doctor_managePrescription.php">
                       <i class="fa fa-stethoscope fa-2x"></i> 
                       <span> Manage Prescription</span>
                    </a>
                </li>
                <li>
                    <a href="doctor_bedAllotment.php">
                       <i class="fa fa-hdd-o fa-2x"></i> 
                       <span> Bed Allotment</span>
                    </a>
                </li>
                <li>
                    <a href="doctor_ViewBloodBank.php">
                       <i class="fa fa-tint fa-2x"></i> 
                       <span> View Blood Bank</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu1">
                       <i class="fa fa-gear fa-2x"></i> 
                       <span> Manage Report <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="doctor_manageOperationReport.php">
                           <i class="fa fa-heartbeat"></i> Manage Operation
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="doctor_manageBirthReport.php">
                           <i class="fa fa-hospital-o"></i> Manage Birth
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="doctor_manageDeathReport.php">
                           <i class="fa fa-bed"></i> Manage Death
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="doctor_manageOtherReport.php">
                            <i class="fa fa-h-square"></i> Manage Other
                        </a></li>
                    </ul>
                </li>
                <li>
                    <a href="doctor_profile.php">
                       <i class="fa fa-globe fa-2x"></i> 
                       <span> Profile</span>
                    </a>
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
                            <h3> <i class="fa fa-info-circle"></i> Manage Appointment</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> Appointment List</a></li>
               <li class="departmentTab" data-toggle="tab" data-target="#departmentAdd"><a href="#"><i class="fa fa-plus"></i> Add Appointment</a></li>
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
                                <th>Date</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Date</th>
                                <th>Patient</th>
                                <th>Doctor</th>
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
                                <label for="appointment-doctor" class="control-label col-lg-4">Doctor</label>
                                <div class="col-lg-6">
                                    <input name="doctor_name" class="form-control" value="<?php echo $doctordata['name'];?>" readonly>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <!-- label for="appointment-doctor" class="control-label col-lg-4">Doctor Department</label -->
                                <div class="col-lg-6">
                                    <input type="hidden" name="doctor_department" class="form-control" value="<?php echo $doctordata['doctor_department'];?>">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="appointment-patient" class="control-label col-lg-4">Patient</label>
                                <div class="col-lg-6">
                                   <?php
                                        $sql = "SELECT * FROM patients";
                                        $query = $conn->query($sql);
                                        
                                    ?>
                                    <select name="patient_name" class="form-control" id="">
                                        <?php while ($row = $query->fetch_array()): ?>
                                            <option name="patient_name"><?php echo $row[1];?></option>
                                        <?php endwhile?>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="appointment-date" class="control-label col-lg-4">Date</label>
                                <div class="col-lg-6">
                                   <input type="date" class="form-control" name="appointment_date">
                                </div>
                            </div><!-- end form-group -->

                            <br>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                   <button type="submit" name="addAppointment" class="btn btn-info">Add Appointment</button>
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
            <?php include('includes/footer/footer.php'); ?>
        </form>
    </footer>

    <script>
        $(document).ready(function() {
            var dataTable = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url:"core/doctor_data/appointmentFetch.php",
                    type:"post"
                }
            });
        });
    </script>

    <!--  Script for getEdit data  -->
    <script> 
        $(document).on('click', '#getEdit', function(e) {
            e.preventDefault();
            var per_id = $(this).data('id');
            $('#content-data').html('');
            $.ajax({
                url: 'core/doctor_data/editAppointment.php',
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

