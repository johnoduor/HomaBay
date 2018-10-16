
<?php 

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $admindata = get_admin_data($_SESSION['id']);

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
    <title>Admin Dashboard | HomaBay Hospital</title>
    
    <?php include('includes/adminoverall-header.php'); ?>

    <link rel="stylesheet" href="css/main/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/main/bootstrap.min.css">
    <script src="js/main/jquery-3.1.0.js"></script>
    <script src="js/main/bootstrap-datepicker.js"></script>

    <link rel="stylesheet" href="css/style/administrator/dashboard.css">

</head>

<body>

    <header>
        <?php include('includes/header/admin-header.php'); ?>
    </header>
<br>
    <div id="container" class="container">
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
                <li class="active">
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
                <li>
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
                    <a href="administrator_laboratory.php">
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
                       <i class="fa fa-gear fa-3x"></i> 
                       <span> Settings <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="administrator_manageNoticBoard.php">
                           <i class="fa fa-columns"></i> Manage Noticboard
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="administrator_systemSetting.php">
                           <i class="fa fa-h-square"></i> System Setting
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
                           <h3> <i class="fa fa-info-circle"></i> Admin Dashboard</h3>
                        </div>
                    </form><!-- end form -->
                </div>
            </div><!-- end row -->
        </div>
    </div><!-- end second-navbar -->
<br>
    <div class="containers" id="PageContainer">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <form class="form-inline"">
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-user-md fa-4x"></span>
                               <h5 class="page-login-linkHeader">Doctor</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-plus-square fa-4x"></span>
                               <h5 class="page-login-linkHeader">Nurse</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-user fa-4x"></span>
                               <h5 class="page-login-linkHeader">Patient</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-medkit fa-4x"></span>
                               <h5 class="page-login-linkHeader">Pharmacist</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-flask fa-4x"></span>
                               <h5 class="page-login-linkHeader">Laboratorist</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-money fa-4x"></span>
                               <h5 class="page-login-linkHeader">Accountant</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                </form>
                <br>
                <!--  NEXT NEXT -->
                <form class="form-inline" id="Nextpage-login-link">
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-exchange fa-4x"></span>
                               <h5 class="page-login-linkHeader">Appoinment</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-fire fa-4x"></span>
                               <h5 class="page-login-linkHeader">Blood Bank</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-medkit fa-4x"></span>
                               <h5 class="page-login-linkHeader">Medicine</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-credit-card fa-4x"></span>
                               <h5 class="page-login-linkHeader">Payment</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-reddit fa-4x"></span>
                               <h5 class="page-login-linkHeader">Birth Report</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-bars fa-4x"></span>
                               <h5 class="page-login-linkHeader">Operation Report</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                </form>
                <br>
                <!--  NEXT NEXT -->
                <form class="form-inline" id="Nextpage-login-link">
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-minus-circle fa-4x"></span>
                               <h5 class="page-login-linkHeader">Death Report</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-hdd-o fa-4x"></span>
                               <h5 class="page-login-linkHeader">Bed Allotment</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-columns fa-4x"></span>
                               <h5 class="page-login-linkHeader">Noticeboard</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-h-square fa-4x"></span>
                               <h5 class="page-login-linkHeader">Settings</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->

                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-google-wallet fa-4x"></span>
                               <h5 class="page-login-linkHeader">CareTaker</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                </form>
            </div><!--  end col-lg-10 col-lg-offset-2  -->
        </div><!-- end row -->
<br><br>
        <!-- Calender and Noticboard record -->
        <div class="row" id="calenderNotic">
            <form class="form-inline">
                <div class="form-group" id="noticeAndNewsTopFirst">
                    <div class="calenderNoticHeader">
                        <h4 class="calenderShedule"> <i class="fa fa-warning"></i> Security News</h4>
                    </div>
                    <div class="form-group">
                        <div class="InfoContent">
                            <?php
                             
                                echo "<i>Dear <strong>".$admindata['name']."</strong>, We've notice that hackers are attacking online software. Make sure to keep
                                your password Secret.</i>";
                                
                            ?>
                        </div>
                    </div>
                </div><!-- end form-group -->

                <div class="form-group" id="noticeAndNewsTop">
                    <div class="calenderNoticHeader">
                       <h4 class="noticBoard"><i class="fa fa-table"></i> Noticeboard</h4>
                    </div>
                    <div class="form-group">
                        <div class="noticebaordContent">
                            <?php
                            
                                $sql = "SELECT * FROM noticeboard";
                                $result = mysqli_query($conn, $sql);

                                while ($row = mysqli_fetch_array($result)) {
                    
                            ?>
                            <?php echo "<div class='noticeContentDate'>".$row['day']."<span class='noticeContentYear'>(".$row['year'].")</span></div>" ;?>
                            <?php echo "<div class='noticeContentMonth'>".$row['month']."</div>" ;?>
                            <?php echo "<div class='noticeContent'>".$row['title']."</div>" ;?>
                            <?php echo "<div class='noticeContentNext'>".$row['notice']."</div>" ;?>
                            <?php } ?>
                        </div>
                    </div>
                </div><!-- end form-group -->
            </form>
        </div>
    </div><!-- end container -->
    
    <!-- Footer -->
    <div>
    <footer>
        <form class="AdminFooter">
            <?php include('includes/footer/footer.php'); ?>
        </form>
    </footer>
</div>
    
    <div class="contaienr"></div>

    <script>
        $(function() {
            $("#datepicker").datepicker({
                autoclose: true,
                todayHighlight: true
            }).datepicker('update', new Date());
        });
    </script>
	
	<!-- script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

