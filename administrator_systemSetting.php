<?php
    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $admindata = get_admin_data($_SESSION['id']);

    $_SESSION['updateSuccess'] = "";
    $_SESSION['updateError'] = "";

    if (isset($_POST['updateSystemSetting'])) {
        $systemName = $conn->real_escape_string($_POST['systemName']);
        $systemTitle = $conn->real_escape_string($_POST['systemTitle']);
        $systemEmail = $conn->real_escape_string($_POST['systemEmail']);
        $systemAddress = $conn->real_escape_string($_POST['systemAddress']);
        $systemPhone = $conn->real_escape_string($_POST['systemPhone']);
        $systemPaypal = $conn->real_escape_string($_POST['systemPaypal']);
        $systemCurrency = $conn->real_escape_string($_POST['systemCurrency']);

        if (empty($systemName) || empty($systemTitle)) {
            $_SESSION['updateError'] = "<div class='updateError'>Oops! System Name and Title required</div>";
        }

        if ($systemName && $systemTitle) {
            if (updateSystemSetting() === TRUE) {
                $_SESSION['updateSuccess'] = "<div class='profileSuccess'>System Data Is Update Successful</div>";
            } else {
                $_SESSION['updateError'] = "<div class='updateError'>Oops! System Data Could be Updateed</div>";
            }
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
    <title>System Settings | HomaBay Hospital</title>
    
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
                <li class="dropdown active">
                   <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu1">
                       <i class="fa fa-gear fa-2x"></i> 
                       <span> Settings <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="administrator_manageNoticBoard.php">
                           <i class="fa fa-columns"></i> Manage Noticboard
                        </a></li>
                        <li role="presentation" class="dropActive"><a role="menuitem" tabindex="-1" href="administrator_systemSetting.php">
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
                            <h3> <i class="fa fa-info-circle"></i> System Settings</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> System Settings</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active fade in" id="departmentAdd">
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
                    <div class="departmentForm">
                        <?php
                            $sql = "SELECT * FROM systemsettings";
                            $query = $conn->query($sql);

                            while ($row = $query->fetch_array()) {
                                echo "<form action='$_SERVER[PHP_SELF]' method='post' enctype='multipart/form-data' class='form-horizontal'>";
                                    echo "<div class='form-group'>
                                        <label for='systemSetting-name' class='control-label col-lg-3'>System Name</label>
                                        <div class='col-lg-6'>
                                            <input type='text' class='form-control' name='systemName' value='".$row['systemName']."'>
                                            <span class='SystemOR'>OR</span>
                                        </div>
                                    </div>"; 
                                    echo "<div class='form-group'>
                                        <label for='systemSetting-logo' class='control-label col-lg-3'>System Logo</label>
                                        <div class='col-lg-6 profileUploadFile'>
                                            <button type='button' class='btn btn-default btn-block' name='file' id='profileUploadButton'>
                                                Click to chose System Logo
                                            </button>
                                            <input type='file' name='file' id='profileUploadInput' accept='image/'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <label for='systemSetting-title' class='control-label col-lg-3'>System Title</label>
                                        <div class='col-lg-6'>
                                            <input type='text' class='form-control' name='systemTitle' value='".$row['systemTitle']."'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <label for='systemSetting-email' class='control-label col-lg-3'>System Email</label>
                                        <div class='col-lg-6'>
                                            <input type='text' class='form-control' name='systemEmail' value='".$row['systemEmail']."'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <label for='systemSetting-address' class='control-label col-lg-3'>Address</label>
                                        <div class='col-lg-6'>
                                            <input type='text' class='form-control' name='systemAddress' value='".$row['systemAddress']."'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <label for='systemSetting-address' class='control-label col-lg-3'>Phone</label>
                                        <div class='col-lg-6'>
                                            <input type='text' class='form-control' name='systemPhone' value='".$row['systemPhone']."' size=20 maxlength=10 onkeypress='return isNumberKey(event)'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <label for='systemSetting-paypal' class='control-label col-lg-3'>Paypal</label>
                                        <div class='col-lg-6'>
                                            <input type='text' class='form-control' name='systemPaypal' value='".$row['systemPaypal']."'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <label for='systemSetting-paypal' class='control-label col-lg-3'>Currency</label>
                                        <div class='col-lg-6'>
                                            <input type='text' class='form-control' name='systemCurrency' value='".$row['systemCurrency']."'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <div class='col-lg-6'>
                                            <input type='hidden' class='form-control' name='id' value='".$row['id']."'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <div class='col-lg-6 col-lg-offset-3'>
                                            <button type='submit' class='btn btn-primary' name='updateSystemSetting'>Update System</button>
                                        </div>
                                    </div>";
                                echo "</form>";
                            }
                        ?>
                    </div>
                </div><!-- end tab pane for Operation  -->
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
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>
	
	<!-- script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

