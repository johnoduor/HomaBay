<?php

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $patientdata = get_patient_data($_SESSION['id']);

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
    <title>View Doctor | HomaBay Hospital</title>
    
    <?php include('includes/patientoverall-header.php'); ?>

    <link rel="stylesheet" href="css/style/patient/patient_more.css">


</head>
    <style>
    </style>

<body>

    <header>
        <?php include('includes/header/patient-header.php'); ?>
    </header>
<br>
    <div id="container" class="container">
        <div class="sidebar">
            <ul id="nav" class="nav sidebar-nav">
                <li class="myBlogsiteDashboard_profile">
                    <?php
                        if ($patientdata['profile'] == "") {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/patientDefault.png' alt='Default Profile'></span>";
                        } else {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/".$patientdata['profile']."' alt='Upload Profile'></span>";
                        }
                        echo "<span>".$patientdata['name']."</span>";
                    ?>
                </li>
                <li>
                    <a href="patient_home.php">
                       <i class="fa fa-desktop fa-2x"></i> 
                       <span> Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="patient_viewAppointment.php">
                       <i class="fa fa-edit fa-2x"></i> 
                       <span> View Appointment</span>
                    </a>
                </li>
                <li>
                    <a href="patient_viewPrescription.php">
                       <i class="fa fa-stethoscope fa-2x"></i> 
                       <span> View Prescription</span>
                    </a>
                </li>
                <li class="active">
                    <a href="patient_viewDoctor.php">
                       <i class="fa fa-user-md fa-2x"></i> 
                       <span> View Doctor</span>
                    </a>
                </li>
                <li>
                    <a href="patient_ViewBloodBank.php">
                       <i class="fa fa-tint fa-2x"></i> 
                       <span> View Blood Bank</span>
                    </a>
                </li>
                <li>
                    <a href="patient_viewAdmitHistory.php">
                       <i class="fa fa-hdd-o fa-2x"></i> 
                       <span> Admit History</span>
                    </a>
                </li>
                <li>
                    <a href="patient_operationHistory.php">
                       <i class="fa fa-heartbeat fa-2x"></i> 
                       <span> Operation History</span>
                    </a>
                </li>
                <li>
                    <a href="patient_viewInvoice.php">
                       <i class="fa fa-user fa-2x"></i> 
                       <span> View Invoice</span>
                    </a>
                </li>
                <li>
                    <a href="patient_paymentHistory.php">
                       <i class="fa fa-money fa-2x"></i> 
                       <span> Payment History</span>
                    </a>
                </li>
                <li>
                    <a href="patient_profile.php">
                       <i class="fa fa-globe fa-2x"></i> 
                       <span> Profile</span>
                    </a>
                </li>
            </ul><!-- end ul -->
        </div>
    </div>

    <!-- second navbar -->
    <div id="second-navbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                    <form>
                        <div class="form-group page-header">
                            <h3> <i class="fa fa-info-circle"></i> View Doctor</h3>
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
            </ul>

            <div class="tab-content">
                <div class="tab-pane active fade in" id="departmentList">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Profile</th>
                                <th>Doctor Name</th>
                                <th>Department Name</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Profile</th>
                                <th>Doctor Name</th>
                                <th>Department Name</th>
                            </tr>
                       </tfoot>
                    </table>
                </div><!-- end tab pane for Department List  -->
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
                    url:"core/patient_data/doctorFetch.php",
                    type:"post"
                }
            });
        });
    </script>
	
	<!-- script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

