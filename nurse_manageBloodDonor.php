<?php

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $nursedata = get_nurse_data($_SESSION['id']);

    $_SESSION['updateSuccess'] = "";
    $_SESSION['updateError'] = "";

    if (isset($_POST['addBloodDonor'])) {// add blood donor
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $address = $conn->real_escape_string($_POST['address']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $age = $conn->real_escape_string($_POST['age']);
        $sex = $conn->real_escape_string($_POST['sex']);
        $blood_group = $conn->real_escape_string($_POST['blood_group']);
        $donationDate = $conn->real_escape_string($_POST['donationDate']);

        if (empty($name) || empty($email) || empty($address) || empty($phone) || empty($age) || empty($sex) || empty($blood_group) || empty($donationDate)) {
            $_SESSION['updateError'] = "<div class='updateError'>All field are mendatory</div>";
        }

        if ($name && $email && $address && $phone && $age && $sex && $blood_group && $donationDate) {
            if (if_NameDate_type_Exist($name, $donationDate) === TRUE) {
                $_SESSION['updateError'] = "<div class='updateError'>We found that this name <strong>$name</strong> has already donor on <strong>$donationDate</strong>.!!</div>";
            } else {
                if (addNewBloodDonor() === TRUE) {
                    $_SESSION['updateSuccess'] = "<div class='profileSuccess'><strong>New Blood Donor</strong> Is Added Successful.</div>";
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'><strong>Error While adding new bed.</div>";
                }
            }
        }
    }

    if (isset($_POST['editBloodDonorData'])) {// update blood donor
        $id = $conn->real_escape_string($_POST['txtid']);
        $name = $conn->real_escape_string($_POST['txtname']);
        $age = $conn->real_escape_string($_POST['txtage']);
        $phone = $conn->real_escape_string($_POST['txtphone']);
        $bloodGroup = $conn->real_escape_string($_POST['txtbloodGroup']);
        $donationDate = $conn->real_escape_string($_POST['txtdonationDate']);

        if (empty($name) || empty($age) || empty($phone) || empty($bloodGroup) || empty($donationDate)) {
            $_SESSION['updateError'] = "<div class='updateError'>updating form field required</div>";
        }

        if ($name && $age && $phone && $bloodGroup && $donationDate) {
            $update_name_andDate_exist = check_if_name_andDate_exist($id, $name, $donationDate);
            if ($update_name_andDate_exist) {
                $_SESSION['updateError'] = "<div class='updateError'>This name <strong>$name</strong> has already donor on $donationDate.!!</div>";
            } else {
                if (updatebloodDonorData($id) === TRUE) {
                    $_SESSION['updateSuccess'] = "<div class='profileSuccess'>Successfull updated blood donor date</div>";
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'>Error while updating blood donor data</div>";
                }
            }
        }
    }

    if (isset($_GET['delete'])) {// delete blood donor data
        $id = $_GET['delete'];

        if (deletebloodDonorAccount($id) === TRUE) { 
            echo "<script>window.location.href='nurse_manageBloodDonor.php'</script>";
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
    <title>Manage Blood Donor | HomaBay Hospital</title>
    
    <?php include('includes/nurseoverall-header.php'); ?>

    <link rel="stylesheet" href="css/style/nurse/patient_more.css">


</head>
    <style>
    </style>

<body>

    <header>
        <?php include('includes/header/nurse-header.php'); ?>
    </header>
<br>
    <div id="container" class="container">
        <div class="sidebar">
            <ul id="nav" class="nav sidebar-nav">
                <li class="myBlogsiteDashboard_profile">
                    <?php
                        if ($nursedata['profile'] == "") {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/NurseDefault.jpg' alt='Default Profile'></span>";
                        } else {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/".$nursedata['profile']."' alt='Upload Profile'></span>";
                        }
                        echo "<span>".$nursedata['name']."</span>";
                    ?>
                </li>
                <li>
                    <a href="nurse_home.php">
                       <i class="fa fa-desktop fa-2x"></i> 
                       <span> Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="nurse_patient.php">
                       <i class="fa fa-user fa-2x"></i> 
                       <span> Patient</span>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu1">
                       <i class="fa fa-hdd-o fa-2x"></i> 
                       <span> Bed Ward <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="nurse_manageBed.php">
                           <i class="fa fa-hdd-o"></i> Manage Bed
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="nurse_manageBedAllotment.php">
                           <i class="fa fa-gear"></i> Manage Bed Allotment
                        </a></li>
                    </ul>
                </li>
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu1">
                       <i class="fa fa-tint fa-2x"></i> 
                       <span> Blood Bank <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="nurse_manageBloodBank.php">
                           <i class="fa fa-fire"></i> Manage Blood Bank
                        </a></li>
                        <li role="presentation" class="dropActive"><a role="menuitem" tabindex="-1" href="nurse_manageBloodDonor.php">
                           <i class="fa fa-user"></i> Manage Blood Donor
                        </a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu1">
                       <i class="fa fa-bookmark fa-2x"></i> 
                       <span> Manage Report <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="nurse_manageOperationReport.php">
                           <i class="fa fa-heartbeat"></i> Manage Operation
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="nurse_manageBirthReport.php">
                           <i class="fa fa-hospital-o"></i> Manage Birth
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="nurse_manageDeathReport.php">
                           <i class="fa fa-bed"></i> Manage Death
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="nurse_manageOtherReport.php">
                            <i class="fa fa-h-square"></i> Manage Other
                        </a></li>
                    </ul>
                </li>
                <li>
                    <a href="nurse_profile.php">
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
                            <h3> <i class="fa fa-info-circle"></i> Manage Blood Donor</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> Blood Donor List</a></li>
               <li class="departmentTab" data-toggle="tab" data-target="#departmentAdd"><a href="#"><i class="fa fa-plus"></i> Add Blood Donor</a></li>
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
                                <th>Name</th>
                                <th>Age</th>
                                <th>Phone</th>
                                <th>Sex</th>
                                <th>Blood Group</th>
                                <th>Donation Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Phone</th>
                                <th>Sex</th>
                                <th>Blood Group</th>
                                <th>Donation Date</th>
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
                                <label for="bloodDonor-name" class="control-label col-lg-4">Name</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="name">
                                </div>
                            </div><!-- end form-group -->
                            
                            <div class="form-group">
                                <label for="bloodDonor-emil" class="control-label col-lg-4">Email</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="email">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="bloodDonor-address" class="control-label col-lg-4">Address</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" name="address">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="bloodDonor-address" class="control-label col-lg-4">Phone</label>
                                <div class="col-lg-6">
                                    <input type="text" class="form-control" name="phone" size=20 maxlength=10 onkeypress='return isNumberKey(event)'>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="bloodDonor-age" class="control-label col-lg-4">Age</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="age" size=20 maxlength=3 onkeypress='return isNumberKey(event)'>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="bloodDonor-sex" class="control-label col-lg-4">Sex</label>
                                <div class="col-lg-6">
                                   <select name="sex" class="form-control">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="bloodDonor-bloodGroup" class="control-label col-lg-4">Blood Group</label>
                                <div class="col-lg-6">
                                   <select name="blood_group" class="form-control">
                                        <option value="Male">A+</option>
                                        <option value="Female">A-</option>
                                        <option value="Male">B+</option>
                                        <option value="Female">B-</option>
                                        <option value="Male">AB+</option>
                                        <option value="Female">AB-</option>
                                        <option value="Male">O+</option>
                                        <option value="Female">O-</option>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="bloodDonor-donationDate" class="control-label col-lg-4">Donation Date</label>
                                <div class="col-lg-6">
                                   <input type="date" class="form-control" name="donationDate">
                                </div>
                            </div><!-- end form-group -->
                            <br>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                    <button type="submit" name="addBloodDonor" class="btn btn-info">Add Blood Donor</button>
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
                    url:"core/nurse_data/bloodDonorFetch.php",
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
        $(document).on('click', '#getEdit', function(e) {
            e.preventDefault();
            var per_id = $(this).data('id');
            $('#content-data').html('');
            $.ajax({
                url: 'core/nurse_data/editbloodDonor.php',
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

