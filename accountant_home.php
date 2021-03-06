<?php 

    session_start();
    
    include('core/accountant_data/accountantSignIn.php');

    // if administrator do not login..they can't access their page
    if(empty($_SESSION['email'])) {
        header('location: index.php');
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
    <title>Accountant Dashboard|HomaBay Hospital</title>
    
    <?php include('includes/accountantoverall-header.php'); ?>
    
    <link rel="stylesheet" href="css/style/accountant/dashboard.css">

</head>
    <style>
    </style>

<body>

    <header>
        <?php include('includes/header/accountant-header.php'); ?>
    </header>
<br>
    <div id="container" class="container">
        <div class="sidebar">
            <ul id="nav" class="nav sidebar-nav">
                <li class="myBlogsiteDashboard_profile">
                    <?php
                        $query = "SELECT * FROM accountant WHERE email = '".$_SESSION['email']."' ";
                        $result = mysqli_query($conn, $query);

                        while ($row = mysqli_fetch_array($result)) {
                            if ($row['profile'] == "") {
                                echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/patientDefault.png' alt='Default Profile'></span>";
                            } else {
                                echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/".$row['profile']."' alt='Upload Profile'></span>";
                            }
                            echo "<span>".$row['name']."</span>";
                        }
                    ?>
                </li>
                <li class="active">
                    <a href="accountant_home.php">
                       <i class="fa fa-desktop fa-2x"></i> 
                       <span> Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="accountant_takePayment.php">
                       <i class="fa fa-newspaper-o fa-2x"></i> 
                       <span> Invoice / Take Payment</span>
                    </a>
                </li>
                <li>
                    <a href="accountant_viewPayment.php">
                       <i class="fa fa-money fa-2x"></i> 
                       <span> View Payment</span>
                    </a>
                </li>
                 <li>
                    <a href="accountant_report.php">
                       <i class="fa fa-money fa-2x"></i> 
                       <span> Reports</span>
                    </a>
                </li>
                <li>
                    <a href="accountant_profile.php">
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
                            <h3> <i class="fa fa-info-circle"></i> Accountant Dashboard</h3>
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
                               <span class="fa fa-newspaper-o fa-2x"></span>
                               <h5 class="page-login-linkHeader">Take Payment</h5>
                            </div>
                        </a>
                    </div><!-- end form-group -->
                    <div class="form-group">
                        <a href="">
                            <div class="page-login-link">
                               <span class="fa fa-money fa-2x"></span>
                               <h5 class="page-login-linkHeader">View Payment</h5>
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
                            
                                $sql = "SELECT * FROM accountant WHERE email='".$_SESSION['email']."'";
                                $result = mysqli_query($conn, $sql);

                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<i>Dear <strong>".$row['name']."</strong>, We've notice that attackers are attacking hospitals software. so make sure yuu keep
                                    your password well. By Engineers</i>";
                                }
                    
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
            <?php include('includes/footer/footer.php'); ?>
        </form>
    </footer>
    
    <div class="contaienr"></div>

    <script>
    </script>
	
	<!-- script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

