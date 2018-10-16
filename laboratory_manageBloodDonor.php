<?php

    session_start(); 
    
    include('core/laboratory_data/laboratorySignIn.php');
    include('core/laboratory_data/registerbloodDonor.php');
    include('core/laboratory_data/UpdateNewBloodDonor.php');

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
    <title>Manage Blood Donor|HomaBay Hospital</title>
    
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
                <li class="active">
                    <a href="laboratory_manageBloodDonor.php">
                       <i class="fa fa-user fa-2x"></i> 
                       <span> Manage Blood Donor</span>
                    </a>
                </li>
                <li>
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
                                <?php
                                   echo $_SESSION['updateDataSuccess'];
                                   unset($_SESSION['updateDataSuccess']);
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
                        <form action="laboratory_manageBloodDonor.php" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
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
                                <div class="form-group">
                                <label for="bloodDonor-bloodGroup" class="control-label col-lg-4">Blood Group</label>
                                <div class="col-lg-6">
                                    <select name="blood_group" class="form-control">
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
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
                    url:"core/laboratory_data/bloodDonorFetch.php",
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
                url: 'core/laboratory_data/editbloodDonor.php',
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
    <?php
    
    // Deleting data 
    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $sqldelete = "DELETE FROM blood_donor WHERE id='$id'";
        $result_delete = mysqli_query($conn, $sqldelete);
        if ($result_delete) {
            echo "<script>window.location.href='laboratory_manageBloodDonor.php'</script>";
        } else {
            echo "<script>alert('deleteing data fail. try again')</script>";
        }
    }
    
    ?>
	
	<!-- script src="js/main/bootstrap.js"></script -->
     
</body>
</Html>

