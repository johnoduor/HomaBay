<?php 

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $pharmacistdata = get_pharmacist_data($_SESSION['id']);

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
    <title>Patient Ddashboard|HomaBay Hospital</title>
    
    <?php include('includes/pharmacistoverall-header.php'); ?>
    
    <link rel="stylesheet" href="css/style/pharmacist/dashboard.css">

</head>
    <style>
    </style>

<body>

    <header>
        <?php include('includes/header/pharmacist-header.php'); ?>
    </header>
<br>
    <div id="container" class="container">
        <div class="sidebar">
            <ul id="nav" class="nav sidebar-nav">
                <li class="myBlogsiteDashboard_profile">
                    <?php
                        if ($pharmacistdata['profile'] == "") {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/patientDefault.png' alt='Default Profile'></span>";
                        } else {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/".$pharmacistdata['profile']."' alt='Upload Profile'></span>";
                        }
                        echo "<span>".$pharmacistdata['name']."</span>";
                    ?>
                </li>
                <li class="active">
                    <a href="pharmacist_home.php">
                       <i class="fa fa-desktop fa-2x"></i> 
                       <span> Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="pharmacist_medicineCategory.php">
                       <i class="fa fa-edit fa-2x"></i> 
                       <span> Medicine Category</span>
                    </a>
                </li>
                <li>
                    <a href="pharmacist_manageMedicine.php">
                       <i class="fa fa-medkit fa-2x"></i> 
                       <span> Manage Medicine</span>
                    </a>
                </li>
                <li>
                    <a href="pharmacist_provideMedication.php">
                       <i class="fa fa-stethoscope fa-2x"></i> 
                       <span> Provide Medication</span>
                    </a>
                </li>
                <li>
                    <a href="pharmacist_profile.php">
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
                            <h3> <i class="fa fa-info-circle"></i> Pharmacist Dashboard</h3>
                        </div>
                    </form><!-- end form -->
                </div>
            </div><!-- end row -->
        </div>
    </div><!-- end second-navbar -->
<br>
    <div class="container" id="PageContainer">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-2">
                <form class="form-inline">
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-desktop fa-2x"></span>
                               <h5 class="page-login-linkHeader">Dashboard</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-edit fa-2x"></span>
                               <h5 class="page-login-linkHeader">Medicine Category</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-medkit fa-2x"></span>
                               <h5 class="page-login-linkHeader">Manage Medicine</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-stethoscope fa-2x"></span>
                               <h5 class="page-login-linkHeader">Provide Medication</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-globe fa-2x"></span>
                               <h5 class="page-login-linkHeader">Profile</h5>
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
                                echo "<i>Dear <strong>".$pharmacistdata['name']."</strong>, We've notice that attackers are attacking hospitals software. so make sure yuu keep
                                your password well. By Engineers</i>";
                    
                            ?>
                        </div>
                    </div>
                </div><!-- end form-group -->

                <div class="form-group" id="noticeAndNewsTop">
                    <div class="calenderNoticHeader">
                       <h4 class="noticBoard"><i class="fa fa-table"></i> Noticboard</h4>
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
    <footer>
        <form class="AdminFooter">
            <div class="form-group">
                <span>&copy; 2017 Hospital Management System.</span><br>
                <span>Developed and Design by<br> <a href="">Blogsite.com</a></span>
            </div>
        </form>
    </footer>
    
    <div class="contaienr"></div>

    <script>
    </script>
	
	<!-- script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

