
<?php

    session_start(); 
    
    include('core/laboratory_data/laboratorySignIn.php');
    include('core/laboratory_data/updateInfo.php');

    // if Administrator do not login in theu can not access login page
    if (empty($_SESSION['email'])) {
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
		<meta name="description" content="Online Advance Management Software. This Software is Expert and manage all Clinic and more..?">
		<meta name="author" content="Schneider Michael">
    <title>Edit Profile|HomaBay Hospital</title>
    
    <?php include('includes/laboratoryoverall-header.php'); ?>
    
    <link rel="stylesheet" href="css/style/laboratory/allstyle.css">


</head>
    <style>
    </style>

<body>

    <header>
        <?php include('includes/header/laboratory-header.php'); ?>
    </header>
<br>
    <div id="container" class="container">
        <div class="sidebar">
            <ul id="nav" class="nav sidebar-nav">
                <li class="myBlogsiteDashboard_profile">
                    <?php
                        $query = "SELECT * FROM laboratory WHERE email = '".$_SESSION['email']."' ";
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
                <li>
                    <a href="laboratory_home.php">
                       <i class="fa fa-desktop fa-2x"></i> 
                       <span> Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="laboratory_addDiagnosis.php">
                       <i class="fa fa-stethoscope fa-2x"></i> 
                       <span> Add Diagnosis Report</span>
                    </a>
                </li>
                <li>
                    <a href="laboratory_manageBloodBank.php">
                       <i class="fa fa-tint fa-2x"></i> 
                       <span> Manage Blood Bank</span>
                    </a>
                </li>
                <li>
                    <a href="laboratory_manageBloodDonor.php">
                       <i class="fa fa-user fa-2x"></i> 
                       <span> Manage Blood Donor</span>
                    </a>
                </li>
                <li class="active">
                    <a href="laboratory_profile.php">
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
                            <h3> <i class="fa fa-info-circle"></i> Edit Profile</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> Edit Profile</a></li>
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
                    <div class="row editProfile">
                        <form>
                            <div class="form-group">
                                <?php
                                    $query = "SELECT * FROM laboratory WHERE email = '".$_SESSION['email']."' ";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($row['profile'] == "") {
                                            echo "<span><img class='editProfilePhoto' data-toggle='modal' data-target='#modal-1' width='230' height='230' src='uploads/patientDefault.png' alt='Default Profile'></span>";
                                        } else {
                                            echo "<span><img class='editProfilePhoto' data-toggle='modal' data-target='#modal-1' width='230' height='230' src='uploads/".$row['profile']."' alt='Profile Photo'></span>";
                                        }
                                    }
                                ?>
                            </div>
                        </form>
                    </div><!-- end editProfile -->
                    <div class="row editProfileInfo">
                        <?php
                            $query = "SELECT * FROM laboratory WHERE email = '".$_SESSION['email']."' ";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_array($result)) {
                                echo "<form action='laboratory_profile.php' method='post' class='form-horizontal editProfileInfoForm'>";
                                    echo "<div class='form-group'>
                                        <div class='col-lg-6'>
                                            <input type='text' class='form-control' name='name' value='".$row['name']."'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <div class='col-lg-6'>
                                            <input type='text' class='form-control' name='email' value='".$row['email']."'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <div class='col-lg-6'>
                                            <input type='text' class='form-control' name='address' value='".$row['address']."'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <div class='col-lg-6'>
                                            <input type='text' class='form-control' name='phone' value='".$row['phone']."' size=20 maxlength=10 onkeypress='return isNumberKey(event)'>
                                        </div>
                                    </div><br><br>";
                                    echo "<h3 style='margin-top: -20px;margin-left: 10px'><i class='fa fa-lock'></i> Enter/Change Password</h3>
                                    <div class='form-group'>
                                        <div class='col-lg-6'>
                                            <small class='warning' color='red'><strong>Note!</strong> Before you update your data! enter your current password or new password before you update your data
                                            if you don't. <strong>your current password will changed automatic</strong>.
                                            </small>
                                            <input type='password' class='form-control' name='password'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <div class='col-lg-6'>
                                            <input type='hidden' class='form-control' name='id' value='".$row['id']."'>
                                        </div>
                                    </div>";
                                    echo "<div class='form-group'>
                                        <div class='col-lg-6'>
                                            <button type='submit' class='btn btn-info' name='updateProfileInfo'>Update</button>
                                        </div>
                                    </div>";
                                echo "</form>";
                            }
                        ?>
                    </div><!-- end editProfileInfo -->
                    <!-- div class="row changPassword">
                        <h3 class="changepassword-header"><i class="fa fa-lock"></i> Change Password</h3>
                        <form action="laboratory_profile.php" method="post" class="form-horizontal">
                            <div class="form-group">
                                <label for="changepassword" class="control-label col-lg-3">New Password</label>
                                <div class="col-lg-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-lg-6">
                                    <input type="hidden" class="form-control" name="id">
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                    <button type="submit" class="btn btn-info" name="changePassword">Change Password</button>
                                </div>
                            </div> 
                        </form>
                    </div end Change Password -->
                </div><!-- end tab pane for Department List  -->
            </div>
        </div>
    </div><!-- end container -->
    
    
    <!--  Modal Window for Change Profile When on Profile photo display dialog -->
    <div class="container">
        <div class="modal fade" tabindex="-1" id="modal-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- modal-header -->
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Modal-body -->
                    <div class="modal-body">
                        <form action="laboratory_profile.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="profileUploadFile">
                                    <button type="button" class="btn btn-default btn-block" name="file" id="profileUploadButton">
                                        Click to chose new profile image
                                    </button>
                                    <input type="file" name="file" id="profileUploadInput" accept="image/">
                                </div>
                            </div><!--  end form-group -->
                            <div class="form-group">
                                <div class="col-lg-offset-5">
                                    <button type="submit" class="btn btn-info" name="uploadProfile">Upload</button>
                                </div>
                            </div>
                        </form><!-- end form -->
                    </div>
                </div><!-- end modal-content -->
            </div>
        </div><!-- end modal -->
    </div>


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
        function isNumberKey(evt){
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>
	
	<!-- script src="js/main/bootstrap.js"></script-->
    
</body>
</Html>

