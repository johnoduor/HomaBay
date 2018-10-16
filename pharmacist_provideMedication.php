<?php

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $pharmacistdata = get_pharmacist_data($_SESSION['id']);

    $_SESSION['updateSuccess'] = "";
    $_SESSION['updateError'] = "";

    if (isset($_POST['addMedication'])) {// add medication 
        $medicine_name = $conn->real_escape_string($_POST['medicine_name']);
        $doctor_name = $conn->real_escape_string($_POST['doctor_name']);
        $total_medicine = $conn->real_escape_string($_POST['total_medicine']);
        $date = $conn->real_escape_string($_POST['date']);
        $status = $conn->real_escape_string($_POST['status']);


        if (empty($medicine_name) || empty($doctor_name) || empty($total_medicine) || empty($date) || empty($status)) {
            $_SESSION['updateError'] = "<div class='updateError'>All field are mendatory</div>";
        }

        if ($medicine_name && $doctor_name && $total_medicine && $date && $status) {
            if (if_medication_alreadyExist($medicine_name, $date) === TRUE) {
                $_SESSION['updateError'] = "<div class='updateError'><strong>$medicine_name ALREADY EXIST</strong>.. medicine were sent on >strong<$date.</strong> you can only sent medicine on the next day!</div>";
            } else {
                if (addNewMedication() === TRUE) {
                    $_SESSION['updateSuccess'] = "<div class='profileSuccess'><strong>New medicine</strong> Is sent Successful.</div>";
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'><strong>Error While sending new medicine.</div>";
                }
            }
        }
    }

    if (isset($_POST['editMedicationData'])) {// update medication 
        $id = $conn->real_escape_string($_POST['txtid']);
        $medicine_name = $conn->real_escape_string($_POST['txtname']);
        $doctor_name = $conn->real_escape_string($_POST['txtdoctorName']);
        $total_medicine = $conn->real_escape_string($_POST['txttotalMedicine']);
        $date = $conn->real_escape_string($_POST['txtdate']);
        $status = $conn->real_escape_string($_POST['txtstatus']);

        if (empty($medicine_name) || empty($doctor_name) || empty($total_medicine) || empty($date) || empty($status)) {
            $_SESSION['updateError'] = "<div class='updateError'>updating form field required</div>";
        }

        if ($medicine_name && $doctor_name && $total_medicine && $date && $status) {
            $checkUpdate_exist = checkMedication_andDateExist($id, $medicine_name, $date);
            if ($checkUpdate_exist) {
                $_SESSION['updateError'] = "<div class='updateError'>updating form field required</div>";
            } else {
                if (updateMedicationData($id) === TRUE) {
                    $_SESSION['updateSuccess'] = "<div class='profileSuccess'>Successfull updated medication date</div>";
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'>Error while updating medication data</div>";
                }
            }
        }
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        if (deleteMedication($id) === TRUE) { // delete medicine category
            echo "<script>window.location.href='pharmacist_provideMedication.php'</script>";
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
    <title>Manage Medicine | HomaBay Hospital</title>
    
    <?php include('includes/pharmacistoverall-header.php'); ?>
    
    <link rel="stylesheet" href="css/style/pharmacist/allstyle.css">


</head>
    <style>
    </style>

<body>

    <header>
        <?php include('includes/header/patient-header.php'); ?>
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
                <li class="active">
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
                            <h3> <i class="fa fa-info-circle"></i> Manage Medication</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> Medication List</a></li>
               <li class="departmentTab" data-toggle="tab" data-target="#departmentAdd"><a href="#"><i class="fa fa-plus"></i> Add Medication</a></li>
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
                                <th>Medicine Name</th>
                                <th>Doctor Name</th>
                                <th>Total Medicine</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Medicine Name</th>
                                <th>Doctor Name</th>
                                <th>Total Medicine</th>
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
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="pharmacist-medicineName" class="control-label col-lg-4">Medicine Name</label>
                                <div class="col-lg-6">
                                   <?php
                                        $sql = "SELECT * FROM medicine";
                                        $query = $conn->query($sql);
                                        
                                    ?>
                                    <select name="medicine_name" class="form-control" id="">
                                        <?php while ($row = $query->fetch_array()): ?>
                                            <option name="medicine_name"><?php echo $row[1];?></option>
                                        <?php endwhile?>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="pharmacist-doctorName" class="control-label col-lg-4">Doctor Name</label>
                                <div class="col-lg-6">
                                    <?php
                                        $sql = "SELECT * FROM doctors";
                                        $query = $conn->query($sql);
                                        
                                    ?>
                                    <select name="doctor_name" class="form-control" id="">
                                        <?php while ($row = $query->fetch_array()): ?>
                                            <option name="doctor_name"><?php echo $row[1];?></option>
                                        <?php endwhile?>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="pharmacist-totalMedicine" class="control-label col-lg-4">Total Medicine</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="total_medicine" size=20 maxlength=5 onkeypress='return isNumberKey(event)'>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="pharmacist-date" class="control-label col-lg-4">Date</label>
                                <div class="col-lg-6">
                                   <input type="date" class="form-control" name="date">
                                </div>
                            </div><!-- end form-group -->

                            
                            <div class="form-group">
                                <label for="pharmacist-status" class="control-label col-lg-4">Status</label>
                                <div class="col-lg-6">
                                   <select name="status" class="form-control" id="">
                                       <option value="Received">Received</option>
                                       <option value="Pending">Pending</option>
                                   </select>
                                </div>
                            </div><!-- end form-group -->
                            <br>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                   <button type="submit" name="addMedication" class="btn btn-info">Add Medication</button>
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
                    url:"core/pharmacist_data/provideMedicationFetch.php",
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
                url: 'core/pharmacist_data/editMedication.php',
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

