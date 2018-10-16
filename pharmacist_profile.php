<?php

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $pharmacistdata = get_pharmacist_data($_SESSION['id']);

    $_SESSION['updateSuccess'] = "";
    $_SESSION['updateError'] = "";

    if (isset($_POST['updateProfileInfo'])) {// update doctor
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $address = $conn->real_escape_string($_POST['address']);
        $phone = $conn->real_escape_string($_POST['phone']);

        if (empty($name) || empty($email)) {
            $_SESSION['updateError'] = "<div class='updateError'>Oops! Form Field Required</div>";
        }

        if ($name && $email) {
            $pharmacistExist = if_pharmacist_exist($_SESSION['id'], $email);
            if ($pharmacistExist) {
                $_SESSION['updateError'] = "<div class='updateError'>Oops! Email already exist!</div>";
            } else {
                if (updatePharmacistUserData($_SESSION['id']) === TRUE) {
                    $_SESSION['updateSuccess'] = "<div class='profileSuccess'>Your Date Is Update Successful!!!</div>";
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'>Oops! Error while updating data</div>";
                }
            }
        }
    }

    if (isset($_POST['changepassword'])) { //changePassword
        $oldPasssword = $conn->real_escape_string($_POST['oldPasssword']);
        $newPasssword = $conn->real_escape_string($_POST['newPasssword']);
        $confirmPasssword = $conn->real_escape_string($_POST['confirmPasssword']);

        if (empty($oldPasssword) || empty($newPasssword) || empty($confirmPasssword)) {
            $_SESSION['updateError'] = "<div class='updateError'>Oops! ChangePasswordForm Field Required</div>";
        }

        if ($oldPasssword && $newPasssword && $confirmPasssword) {
            if (pharmacistPasswordMatch($_SESSION['id'], $oldPasssword) === TRUE) {
                if ($newPasssword != $confirmPasssword) {
                    $_SESSION['updateError'] = "<div class='updateError'>Oops! New Password and Confirm Password do not match!!!</div>";
                } else {
                    if (changePharmacistPassword($_SESSION['id'], $newPasssword) === TRUE) {
                        $_SESSION['updateSuccess'] = "<div class='profileSuccess'>Your Password is changed Successful!!!</div>";
                    } else {
                        $_SESSION['updateError'] = "<div class='updateError'>Oops! Error while changing password...!</div>";
                    }
                }
            } else {
                $_SESSION['updateError'] = "<div class='updateError'>Oops! Old Password is incorrect. Try Again!!.</div>";
            }
        }
    }

    if (isset($_POST['uploadProfile'])) {
        $profile = $conn->real_escape_string("uploads/".$_FILES['profile']['name']);

        if ($profile) {
            if (preg_match("!image!", $_FILES['profile']['type'])) {
                if (copy($_FILES['profile']['tmp_name'], $profile)) {
                    if (uploadPharmacisProfile($_SESSION['id']) === TRUE) {
                        header("refresh:1; pharmacist_profile.php");
                        $_SESSION['updateSuccess'] = "<div class='profileSuccess'>Your Profile is upload Successful!!!</div>";
                    } else {
                        $_SESSION['updateError'] = "<div class='updateError'>Oops! Fail to upload profile!</div>";
                    }
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'>Oops! upload only GIF, JPG, 0r PNG!</div>";
                }
            } else {
                $_SESSION['updateError'] = "<div class='updateError'>Oops! chose image to upload!</div>";
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
    <title>Edit Profile | HomaBay Hospital</title>
    
    <?php include('includes/pharmacistoverall-header.php'); ?>
    
    <link rel="stylesheet" href="css/style/pharmacist/allstyle.css">


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
                <li>
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
                <li class="active">
                    <a href="pharmacist_profile.php">
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
                                    if ($pharmacistdata['profile'] == "") {
                                        echo "<span><img class='editProfilePhoto' data-toggle='modal' data-target='#modal-1' width='230' height='230' src='uploads/patientDefault.png' alt='Default Profile'></span>";
                                    } else {
                                        echo "<span><img class='editProfilePhoto' data-toggle='modal' data-target='#modal-1' width='230' height='230' src='uploads/".$pharmacistdata['profile']."' alt='Profile Photo'></span>";
                                    }
                                ?>
                            </div>
                        </form>
                    </div><!-- end editProfile -->
                    <div class="row editProfileInfo">
                        <form action='<?php echo $_SERVER['PHP_SELF']; ?>' method='post' class='form-horizontal editProfileInfoForm'>
                            <div class='form-group'>
                                <div class='col-lg-6'>
                                    <input type='text' class='form-control' name='name' value="<?php if (isset($_POST['updateProfileInfo'])) {
                                       echo $_POST['name'];
                                    } else {
                                       echo $pharmacistdata['name'];
                                    }?>">
                                </div>
                            </div>
                            <div class='form-group'>
                                <div class='col-lg-6'>
                                    <input type='text' class='form-control' name='email' value="<?php if (isset($_POST['updateProfileInfo'])) {
                                       echo $_POST['email'];
                                    } else {
                                       echo $pharmacistdata['email'];
                                    }?>">
                                </div>
                            </div>
                            <div class='form-group'>
                                <div class='col-lg-6'>
                                    <input type='text' class='form-control' name='address' value="<?php if (isset($_POST['updateProfileInfo'])) {
                                       echo $_POST['address'];
                                    } else {
                                       echo $pharmacistdata['address'];
                                    }?>">
                                </div>
                            </div>
                            <div class='form-group'>
                                <div class='col-lg-6'>
                                    <input type='text' class='form-control' name='phone' value="<?php if (isset($_POST['updateProfileInfo'])) {
                                       echo $_POST['phone'];
                                    } else {
                                       echo $pharmacistdata['phone'];
                                    }?>">
                                </div>
                            </div>
                            <div class='form-group'>
                                <div class='col-lg-6'>
                                    <button type='submit' class='btn btn-info' name='updateProfileInfo'>Update Data</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- end editProfileInfo -->
                    <div class="row changPassword">
                        <h3 class="changepassword-header"><i class="fa fa-lock"></i> Change Password</h3>
                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" class="form-horizontal">
                            
                            <div class="form-group">
                                <label for="changepassword" class="control-label col-lg-3">Enter Old Password</label>
                                <div class="col-lg-6">
                                    <input type="password" class="form-control" name="oldPasssword" value="">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="changepassword" class="control-label col-lg-3">Enter New Password</label>
                                <div class="col-lg-6">
                                    <input type="password" class="form-control" name="newPasssword" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="changepassword" class="control-label col-lg-3">Confirm New Password</label>
                                <div class="col-lg-6">
                                    <input type="password" class="form-control" name="confirmPasssword" value="">
                                </div>
                            </div> 
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-3">
                                    <button type="submit" class="btn btn-info" name="changepassword">Change Password</button>
                                </div>
                            </div> 
                            
                        </form>
                    </div >
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
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="profileUploadFile">
                                    <button type="button" class="btn btn-default btn-block" name="file" id="profileUploadButton">
                                        Click to chose new profile image
                                    </button>
                                    <input type="file" name="profile" id="profileUploadInput" accept="image/">
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
	
	<!--script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

