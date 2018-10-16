<?php

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $laboratorydata = get_laboratory_data($_SESSION['id']);

    $_SESSION['updateSuccess'] = "";
    $_SESSION['updateError'] = "";

    if (isset($_POST['addDiagnosis'])) {// add diagnosis
        $patient_name = $conn->real_escape_string($_POST['patient_name']);
        $report_type = $conn->real_escape_string($_POST['report_type']);
        $document_type = $conn->real_escape_string($_POST['document_type']);
        $file = $conn->real_escape_string("diagnosis/".$_FILES['file']['name']);
        $description = $conn->real_escape_string($_POST['description']);
        $laboratory_date = $conn->real_escape_string($_POST['laboratory_date']);
        $laboratorist_name = $conn->real_escape_string($_POST['laboratorist_name']);

        if (empty($patient_name) || empty($report_type) || empty($document_type) || empty($file) || empty($description) || empty($laboratory_date) || empty($laboratorist_name)) {
            $_SESSION['updateError'] = "<div class='updateError'>All field are mendatory</div>";
        }

        if ($patient_name && $report_type && $document_type && $file && $description && $laboratory_date && $laboratorist_name) {
            if (preg_match("!document!", $_FILES['file']['type'])) {
                if (copy($_FILES['file']['tmp_name'], $file)) {
                    if (if_diagnosis_patientFile_exist($patient_name, $file) === TRUE) {
                        $_SESSION['updateError'] = "<div class='updateError'>$patient_name diagnosis report is already recorded on $laboratory_date</div>";
                    } else {
                        if (addNewDiagnosis() === TRUE) {
                            $_SESSION['updateSuccess'] = "<div class='profileSuccess'><strong>Patient diagnosis</strong> Is Uploaded Successful.</div>";
                        } else {
                            $_SESSION['updateError'] = "<div class='updateError'>Error while uploading patient document!</div>";
                        }
                    }
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'>Oops! please upload patient diagnosis document!</div>";
                }
            } else {
                $_SESSION['updateError'] = "<div class='updateError'>All Form field are mendatory</div>";
            }
        }
    }

    if (isset($_POST['editDiagnosisData'])) {// update diagnosis
        $id = $conn->real_escape_string($_POST['txtid']);
        $patient_name = $conn->real_escape_string($_POST['txtpatient']);
        $report_type = $conn->real_escape_string($_POST['txtreportType']);
        $document_type = $conn->real_escape_string($_POST['txtdocumentType']);
        $file = $conn->real_escape_string("diagnosis/".$_FILES['file']['name']);
        $description = $conn->real_escape_string($_POST['txtdescription']);
        $laboratorist_name = $conn->real_escape_string($_POST['txtlaboratorist']);

        if (empty($patient_name) || empty($report_type) || empty($document_type) || empty($file) || empty($description) || empty($laboratorist_name)) {
            $_SESSION['updateError'] = "<div class='updateError'>All field are mendatory</div>";
        }

        if ($patient_name && $report_type && $document_type && $file && $description && $laboratorist_name) {
            if (preg_match("!image!", $_FILES['file']['type'])) {
                if (copy($_FILES['file']['tmp_name'], $file)) {
                    $update_diagnosis_patientFile_exist = check_if_diagnosis_patientFile_exist($id, $patient_name, $file);
                    if ($update_diagnosis_patientFile_exist) {
                        $_SESSION['updateError'] = "<div class='updateError'>$patient_name diagnosis report is already recorded on $laboratory_date</div>";
                    } else {
                        if (updateDiagnosisData($id) === TRUE) {
                            $_SESSION['updateSuccess'] = "<div class='profileSuccess'>Successfull updated $patient_name diagnosis data</div>";
                        } else {
                            $_SESSION['updateError'] = "<div class='updateError'>Error while updating diagnosis data</div>";
                        }
                    }
                } else {
                    $_SESSION['updateError'] = "<div class='updateError'>Oops! please upload patient diagnosis document!</div>";
                }
            } else {
                $_SESSION['updateError'] = "<div class='updateError'>make sure u upload</div>";
            }
            
        }
    }

    if (isset($_GET['delete'])) {// delete diagnosis data
        $id = $_GET['delete'];

        if (deleteDiagnosisReport($id) === TRUE) { 
            echo "<script>window.location.href='laboratory_addDiagnosis.php'</script>";
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
    <title>Manage Diagnosis|HomaBay Hospital</title>
    
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
                        if ($laboratorydata['profile'] == "") {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/patientDefault.png' alt='Default Profile'></span>";
                        } else {
                            echo "<span class='dashboardProfileDefault'><img width='53' height='53' id='defaultProfile' src='uploads/".$laboratorydata['profile']."' alt='Upload Profile'></span>";
                        }
                        echo "<span>".$laboratorydata['name']."</span>";
                    ?>
                </li>
                <li>
                    <a href="laboratory_home.php">
                       <i class="fa fa-desktop fa-2x"></i> 
                       <span> Dashboard</span>
                    </a>
                </li>
                <li class="active">
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
                            <h3> <i class="fa fa-info-circle"></i> Diagnosis Report</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> Diagnosis Report List</a></li>
               <li class="departmentTab" data-toggle="tab" data-target="#departmentAdd"><a href="#"><i class="fa fa-plus"></i> Add Diagnosis Report</a></li>
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
                                <th>Patient</th>
                                <th>Report Type</th>
                                <th>Document Type</th>
                                <th>Download</th>
                                <th>Laboratorist</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Patient</th>
                                <th>Report Type</th>
                                <th>Document Type</th>
                                <th>Download</th>
                                <th>Laboratorist</th>
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
                        <form action="laboratory_addDiagnosis.php" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="laboratory-patient" class="control-label col-lg-4">Patient</label>
                                <div class="col-lg-6">
                                   <?php
                                        $sql = "SELECT * FROM patients";
                                        $query = $conn->query($sql);
                                        
                                    ?>
                                    <select name="patient_name" class="form-control" id="">
                                        <?php while ($row = $query->fetch_array()): ?>
                                            <option name="patient_name"><?php echo $row[1];?></option>
                                        <?php endwhile?>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="laboratory-reportType" class="control-label col-lg-4">Report Type</label>
                                <div class="col-lg-6">
                                   <input name="report_type" type="text" class="form-control">
                                </div>
                            </div><!-- end form-group -->
                            <div class="form-group">
                                <label for="laboratory-documentType" class="control-label col-lg-4">Document Type</label>
                                <div class="col-lg-6">
                                    <select name="document_type" class="form-control" id="">
                                        <option value="pdf">pdf</option>
                                        <option value="excel">excel</option>
                                        <option value="doc">doc</option>
                                        <option value="other">other</option>
                                    </select>
                                </div>
                            </div><!-- end form-group -->
                            <div class="form-group">
                                <label for="laboratory-download" class="control-label col-lg-4">Download</label>
                                <div class="col-lg-6">
                                    <div class="profileUploadFile">
                                        <button type="button" class="btn btn-default btn-block" name="file" id="diagnosisButtonD">
                                            click to chose document image
                                        </button>
                                        <input type="file" name="file" id="diagnosisButtonFile" accept="image/">
                                    </div>
                                </div>
                            </div><!-- end form-group -->
                            <div class="form-group">
                                <label for="laboratory-description" class="control-label col-lg-4">Description</label>
                                <div class="col-lg-6">
                                   <textarea name="description" type="text" id="" cols="73" rows="5"></textarea>
                                </div>
                            </div><!-- end form-group -->
                            <div class="form-group">
                                <label for="laboratory-date" class="control-label col-lg-4">Date</label>
                                <div class="col-lg-6">
                                   <input type="date" class="form-control" name="laboratory_date">
                                </div>
                            </div><!-- end form-group -->
                            

                            <div class="form-group">
                                <label for="laboratory-laboratory" class="control-label col-lg-4"></label>
                                <div class="col-lg-6">
                                    <input type="hidden" name="laboratorist_name" class="form-control" value="<?php echo $laboratorydata['name'];?>">
                                </div>
                            </div><!-- end form-group -->

                            <br>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                   <button type="submit" name="addDiagnosis" class="btn btn-info">Add Diagnosis Report</button>
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
                    url:"core/laboratory_data/addDiagnosisFetch.php",
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
                url: 'core/laboratory_data/editDiagnosisReport.php',
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
        $sqldelete = "DELETE FROM diagnosis WHERE id='$id'";
        $result_delete = mysqli_query($conn, $sqldelete);
        if ($result_delete) {
            echo "<script>window.location.href='laboratory_addDiagnosis.php'</script>";
        } else {
            echo "<script>alert('deleteing data fail. try again')</script>";
        }
    }
    
    ?>
	<!--script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

