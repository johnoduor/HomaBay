<?php

    session_start(); 
    
    include('core/careTaker_data/careTakerSignIn.php');
    include('core/careTaker_data/registerOnDuties.php');
    include('core/careTaker_data/UpdateNewOnDuties.php');

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
    <title>Manage onDuties | HomaBay Hospital</title>
    
    <?php include('includes/careTakeroverall-header.php'); ?>
    
    <link rel="stylesheet" href="css/style/careTaker/patient_more.css">


</head>
    <style>
    </style>

<body>

    <header>
        <?php include('includes/header/careTaker-header.php'); ?>
    </header>
<br>
    <div id="container" class="container">
        <div class="sidebar">
            <ul id="nav" class="nav sidebar-nav">
                <li class="myBlogsiteDashboard_profile">
                    <?php
                        $query = "SELECT * FROM careTaker WHERE email = '".$_SESSION['email']."' ";
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
                    <a href="careTaker_home.php">
                       <i class="fa fa-desktop fa-2x"></i> 
                       <span> Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="careTaker_weeklyDuties.php">
                       <i class="fa fa-adjust fa-2x"></i> 
                       <span> Manage onDuties</span>
                    </a>
                </li>
                <li>
                <li>
                    <a href="careTaker_profile.php">
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
                            <h3> <i class="fa fa-info-circle"></i> Manage onDuties</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> onDuties List</a></li>
               <li class="departmentTab" data-toggle="tab" data-target="#departmentAdd"><a href="#"><i class="fa fa-plus"></i> Add onDuties</a></li>
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
                                <th>Guard Name</th>
                                <th>Time</th>
                                <th>Day Start</th>
                                <th>Day End</th>
                                <th>Date Start</th>
                                <th>Date End</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Guard Name</th>
                                <th>Time</th>
                                <th>Day Start</th>
                                <th>Day End</th>
                                <th>Date Start</th>
                                <th>Date End</th>
                                <th>Status</th>
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
                        <form action="careTaker_weeklyDuties.php" method="post" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="careTaker-onDuties" class="control-label col-lg-4">careTaker Name</label>
                                <div class="col-lg-6">
                                    <?php
                                        $query = "SELECT * FROM careTaker";
                                        $result3 = mysqli_query($conn, $query);
                                        
                                    ?>
                                    <select name="name" class="form-control" id="">
                                        <?php while ($row = mysqli_fetch_array($result3)): ?>
                                            <option name="name"><?php echo $row[1];?></option>
                                        <?php endwhile?>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="careTaker-time" class="control-label col-lg-4">Time</label>
                                <div class="col-lg-6">
                                    <select name="time" class="form-control" id="">
                                        <option value="">           --------------</option>
                                        <option value="Day">Day</option>
                                        <option value="Night">Night</option>
                                        <option value="Both">Both</option>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="careTaker-startweek" class="control-label col-lg-4">Day Start</label>
                                <div class="col-lg-6">
                                    <select name="dayStart" class="form-control" id="">
                                        <option value="">           --------------</option>
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="careTaker-endweek" class="control-label col-lg-4">Day End</label>
                                <div class="col-lg-6">
                                    <select name="dayEnd" class="form-control" id="">
                                        <option value="">           --------------</option>
                                        <option value="Sunday">Sunday</option>
                                        <option value="Monday">Monday</option>
                                        <option value="Tuesday">Tuesday</option>
                                        <option value="Wednesday">Wednesday</option>
                                        <option value="Thursday">Thursday</option>
                                        <option value="Friday">Friday</option>
                                        <option value="Saturday">Saturday</option>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="careTaker-dateStart" class="control-label col-lg-4">Date Start</label>
                                <div class="col-lg-6">
                                   <input type="date" class="form-control" name="dateStart">
                                </div>
                            </div><!-- end form-group -->
                            
                            <div class="form-group">
                                <label for="careTaker-dateEnd" class="control-label col-lg-4">Date End</label>
                                <div class="col-lg-6">
                                   <input type="date" class="form-control" name="dateEnd">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="careTaker-dateEnd" class="control-label col-lg-4">Status</label>
                                <div class="col-lg-6">
                                    <select name="status" class="form-control" id="">
                                        <option value="">   --------------   </option>
                                        <option value="Confirm">Confirm</option>
                                    </select>
                                </div>
                            </div><!-- end form-group -->
                            <br>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                   <button type="submit" name="addcareTakerweeklyDuties" class="btn btn-info">Add onDuties</button>
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
                    url:"core/careTaker_data/manageOnDutiesFetch.php",
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
                url: 'core/careTaker_data/editOnDuties.php',
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
        $sqldelete = "DELETE FROM careTaker_duties WHERE id='$id'";
        $result_delete = mysqli_query($conn, $sqldelete);
        if ($result_delete) {
            echo "<script>window.location.href='careTaker_weeklyDuties.php'</script>";
        } else {
            echo "<script>alert('deleteing data fail. try again')</script>";
        }
    }
    
    ?>

	<!--script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

