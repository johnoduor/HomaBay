<?php

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $nursedata = get_nurse_data($_SESSION['id']);

    $_SESSION['updateSuccess'] = "";
    $_SESSION['updateError'] = "";

    if (isset($_POST['addBed'])) {// add bed
        $bed_number = $conn->real_escape_string($_POST['bed_number']);
        $bed_type = $conn->real_escape_string($_POST['bed_type']);
        $description = $conn->real_escape_string($_POST['description']);

        if (empty($bed_number) || empty($bed_type) || empty($description)) {
            $_SESSION['updateError'] = "<div class='updateError'>All field are mendatory</div>";
        }

        if ($bed_number && $bed_type && $description) {
            if (if_bedNumber_type_Exist($bed_number, $bed_type) === TRUE) {
                $_SESSION['updateError'] = "<div class='updateError'>Bed Number $bed_number already exist in $bed_type</div>";
            } else {
                if (addNewBed() === TRUE) {
                    $_SESSION['updateSuccess'] = "<div class='profileSuccess'><strong>New Bed</strong> Is Added Successful.</div>";
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'><strong>Error While adding new bed.</div>";
                }
            }
        }
    }

    if (isset($_POST['editBedData'])) {// update bed
        $id = mysqli_real_escape_string($conn, $_POST['txtid']);
        $bed_number = mysqli_real_escape_string($conn, $_POST['txtnumber']);
        $bed_type = mysqli_real_escape_string($conn, $_POST['txtType']);
        $description = mysqli_real_escape_string($conn, $_POST['txtdescription']);

        if (empty($bed_number) || empty($bed_type)) {
            $_SESSION['updateError'] = "<div class='updateError'>updating form field required</div>";
        }

        if ($bed_number && $bed_type) {
            $update_BedNumber_andBedType_exist = check_if_bednumber_andBedType_exist($id, $bed_number, $bed_type);
            if ($update_BedNumber_exist) {
                $_SESSION['updateError'] = "<div class='updateError'>Bed Number $bed_number already exist in $bed_type</div>";
            } else {
                if (updatebedData($id) === TRUE) {
                    $_SESSION['updateSuccess'] = "<div class='profileSuccess'>Successfull updated bed date</div>";
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'>Error while updating bed data</div>";
                }
            }
        }
    }

    if (isset($_GET['delete'])) {// delete bed data
        $id = $_GET['delete'];

        if (deleteBedAccount($id) === TRUE) { 
            echo "<script>window.location.href='nurse_manageBed.php'</script>";
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
    <title>Manage Bed | HomaBay Hospital</title>
    
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
                <li class="dropdown active">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu1">
                       <i class="fa fa-hdd-o fa-2x"></i> 
                       <span> Bed Ward <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation" class="dropActive"><a role="menuitem" tabindex="-1" href="nurse_manageBed.php">
                           <i class="fa fa-hdd-o"></i> Manage Bed
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="nurse_manageBedAllotment.php">
                           <i class="fa fa-gear"></i> Manage Bed Allotment
                        </a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="menu1">
                       <i class="fa fa-tint fa-2x"></i> 
                       <span> Blood Bank <i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="nurse_manageBloodBank.php">
                           <i class="fa fa-fire"></i> Manage Blood Bank
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="nurse_manageBloodDonor.php">
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
                            <h3> <i class="fa fa-info-circle"></i> Manage Bed</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> Bed List</a></li>
               <li class="departmentTab" data-toggle="tab" data-target="#departmentAdd"><a href="#"><i class="fa fa-plus"></i> Add Bed</a></li>
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
                                <th>Bed Number</th>
                                <th>Bed Type</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Bed Number</th>
                                <th>Bed Type</th>
                                <th>Description</th>
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
                                <label for="nurse-bedNumber" class="control-label col-lg-4">Bed Number</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="bed_number" size=20 maxlength=6 onkeypress='return isNumberKey(event)'>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="nurse-name" class="control-label col-lg-4">Bed Type</label>
                                <div class="col-lg-6">
                                   <select name="bed_type" class="form-control">
                                        <option value="Ward">Ward</option>
                                        <option value="Cabin">Cabin</option>
                                        <option value="lcu">ICU</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="nurse-email" class="control-label col-lg-4">Description</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="description">
                                </div>
                            </div><!-- end form-group -->
                            <br>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                   <button type="submit" name="addBed" class="btn btn-info">Add Bed</button>
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
                    url:"core/nurse_data/bedFetch.php",
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
                url: 'core/nurse_data/editbed.php',
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

