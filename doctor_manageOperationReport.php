<?php

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $doctordata = get_doctor_data($_SESSION['id']);

    $_SESSION['updateSuccess'] = "";
    $_SESSION['updateError'] = "";

    if (isset($_POST['addOperation'])) {// add operation
        $description = $conn->real_escape_string($_POST['description']);
        $date = $conn->real_escape_string($_POST['date']);
        $patient_name = $conn->real_escape_string($_POST['patient_name']);
        $doctor_name = $conn->real_escape_string($_POST['doctor_name']);

        if (empty($description) || empty($date) || empty($patient_name) || empty($doctor_name)) {
            $_SESSION['updateError'] = "<div class='updateError'>All field are mendatory</div>";
        }

        if ($description && $date && $patient_name && $doctor_name) {
            if (if_patientName_date_exist($patient_name, $date) === TRUE) {
                $_SESSION['updateError'] = "<div class='updateError'>$patient_name already exist on $date</div>";
            } else {
                if (addNewOperation() === TRUE) {
                    $_SESSION['updateSuccess'] = "<div class='profileSuccess'><strong>New Operation is added</strong> Is Added Successful.</div>";
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'><strong>Error While adding new operation.</div>";
                }
            }
        }
    }

    if (isset($_GET['delete'])) {// delete operaion data
        $id = $_GET['delete'];

        if (deleteOperationAccount($id) === TRUE) { 
            echo "<script>window.location.href='doctor_manageOperationReport.php'</script>";
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
    <title>Manage Operation Report|HomaBay Hospital</title>
    
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
                <li>
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
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu1">
                       <i class="fa fa-gear fa-2x"></i> 
                       <span> Manage Report <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation" class="dropActive"><a role="menuitem" tabindex="-1" href="doctor_manageOperationReport.php">
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
                            <h3> <i class="fa fa-info-circle"></i> Manage Operation Report</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> Operation Report</a></li>
               <li class="departmentTab" data-toggle="tab" data-target="#departmentAdd"><a href="#"><i class="fa fa-plus"></i> Add Operation Report</a></li>
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
                                <th>Description</th>
                                <th>Date</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Patient</th>
                                <th>Doctor</th>
                                <th>Action</th>
                            </tr>
                       </tfoot>
                    </table>

                </div><!-- end tab pane for Department List  -->

                <div class="tab-pane fade" id="departmentAdd">
                    <div class="departmentForm">
                        <form action="doctor_manageOperationReport.php" method="post" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="operation-description" class="control-label col-lg-4">Description</label>
                                <div class="col-lg-6">
                                    <textarea name="description" id="" cols="72" rows="5"></textarea>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="operation-date" class="control-label col-lg-4">Date</label>
                                <div class="col-lg-6">
                                    <input type="date" class="form-control" name="date" id="">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="operation-patient" class="control-label col-lg-4">Patient</label>
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
                                <label for="operation-doctor" class="control-label col-lg-4">Doctor</label>
                                <div class="col-lg-6">
                                    <input name="doctor_name" class="form-control" value="<?php echo $doctordata['name'];?>">
                                </div>
                            </div><!-- end form-group -->
                            <br>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                    <button type="submit" name="addOperation" class="btn btn-info">Add Operation Report</button>
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
            <div class="form-group">
                <span>&copy; 2017 Hospital Management System.</span><br>
                <span>Developed and Design by<br> <a href="">Blogsite.com</a></span>
            </div>
        </form>
    </footer>

    <script>
        $(document).ready(function() {
            var dataTable = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url:"core/doctor_data/operationFetch.php",
                    type:"post"
                }
            });
        });
    </script>
	<!-- script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

