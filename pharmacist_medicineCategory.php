<?php

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $pharmacistdata = get_pharmacist_data($_SESSION['id']);

    $_SESSION['updateSuccess'] = "";
    $_SESSION['updateError'] = "";

    if (isset($_POST['addMedicineCategoory'])) {// add meddicine category
        $name = $conn->real_escape_string($_POST['name']);
        $description = $conn->real_escape_string($_POST['description']);

        if (empty($name) || empty($description)) {
            $_SESSION['updateError'] = "<div class='updateError'>All field are mendatory</div>";
        }

        if ($name && $description) {
            if (addNewMedicineCategory() === TRUE) {
                $_SESSION['updateSuccess'] = "<div class='profileSuccess'><strong>New medicine category</strong> Is Added Successful.</div>";
            } else {
                $_SESSION['updateError'] = "<div class='updateError'><strong>Error While adding new medicine category.</div>";
            }
        }
    }

    if (isset($_POST['editMedicineCategoryData'])) {// update medicine category
        $id = $conn->real_escape_string($_POST['txtid']);
        $name = $conn->real_escape_string($_POST['txtname']);
        $description = $conn->real_escape_string($_POST['txtdescription']);

        if (empty($name) || empty($description)) {
            $_SESSION['updateError'] = "<div class='updateError'>updating form field required</div>";
        }

        if ($name && $description) {
            if (updateMedicineCategoryData($id) === TRUE) {
                $_SESSION['updateSuccess'] = "<div class='profileSuccess'>Successfull updated medicine category date</div>";
            } else {
                $_SESSION['updateError'] = "<div class='updateError'>Error while updating medicine category data</div>";
            }
        }
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        if (deleteMedicineCategory($id) === TRUE) { // delete medicine category
            echo "<script>window.location.href='pharmacist_medicineCategory.php'</script>";
        } else {
            echo "<script>alert('deleteing data fail. try again')</script>";
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
    <title>Manage Medicine Category | HomaBay Hospital</title>
    
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
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/".$pharnacistdata['profile']."' alt='Upload Profile'></span>";
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
                <li class="active">
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
                            <h3> <i class="fa fa-info-circle"></i> Manage Medicine Category</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> Medicine Category List</a></li>
               <li class="departmentTab" data-toggle="tab" data-target="#departmentAdd"><a href="#"><i class="fa fa-plus"></i> Add Medicine Category</a></li>
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
                                <th>Medicine Category Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Medicine Category Name</th>
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
                                <label for="parmacist-name" class="control-label col-lg-4">Medicine Category Name</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="name">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="parmacist-description" class="control-label col-lg-4">Description</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="description">
                                </div>
                            </div><!-- end form-group -->
                            <br>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                   <button type="submit" name="addMedicineCategoory" class="btn btn-info">Add Medicine Category</button>
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
                    url:"core/pharmacist_data/medicineCategoryFetch.php",
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
                url: 'core/pharmacist_data/editMedicineCategory.php',
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
   
	<!--script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

