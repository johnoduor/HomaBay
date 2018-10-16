<?php

    require_once 'core/init.php';

    if (not_logged_in() === TRUE) {
        header("location: index.php?Login-to-access-your-account/");
    }

    $admindata = get_admin_data($_SESSION['id']);

    $_SESSION['updateSuccess'] = "";
    $_SESSION['updateError'] = "";

    if (isset($_POST['addNoticeboard'])) {// add Accountant
        $title = $conn->real_escape_string($_POST['title']);
        $notice = $conn->real_escape_string($_POST['notice']);
        $day = $conn->real_escape_string($_POST['day']);
        $month = $conn->real_escape_string($_POST['month']);
        $year = $conn->real_escape_string($_POST['year']);
        $mytime = $conn->real_escape_string($_POST['mytime']);
        $promp = $conn->real_escape_string($_POST['promp']);

        if (empty($title) || empty($notice) || empty($day) || empty($month) || empty($year) || empty($mytime) || empty($promp)) {
            $_SESSION['updateError'] = "<div class='updateError'>All field are mendatory</div>";
        }

        if ($title && $email && $notice && $day && $month && $year && $mytime && $promp) {
            if (addNewNoticeboard() === TRUE) {
                $_SESSION['updateSuccess'] = "<div class='profileSuccess'><strong>$name</strong> Is Added Successful.</div>";
            } else {
                $_SESSION['updateError'] = "<div class='updateError'><strong>Error While adding new nurse.</div>";
            } 
        }
    }

    if (isset($_POST['editNoticeboardData'])) { // update Accountant data
        $title = $conn->real_escape_string($_POST['title']);
        $notice = $conn->real_escape_string($_POST['notice']);
        $day = $conn->real_escape_string($_POST['day']);
        $month = $conn->real_escape_string($_POST['month']);
        $year = $conn->real_escape_string($_POST['year']);
        $mytime = $conn->real_escape_string($_POST['mytime']);
        $promp = $conn->real_escape_string($_POST['promp']);

        if (empty($title) || empty($notice) || empty($day) || empty($month) || empty($year) || empty($mytime) || empty($promp)) {
            $_SESSION['updateError'] = "<div class='updateError'>updating field required</div>";
        }

        if ($title && $email && $notice && $day && $month && $year && $mytime && $promp) {
            if (updateNoticeboardData($id) === TRUE) {
                $_SESSION['updateSuccess'] = "<div class='profileSuccess'>Successfull updated careTaker data</div>";
            } else {
                $_SESSION['updateError'] = "<div class='updateError'>Error while updating data</div>";
            }
        }
    }

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];

        if (deleteNoticeboardAccount($id) === TRUE) { // delete Laboratory account
            echo "<script>window.location.href='administrator_manageNoticeBoard.php'</script>";
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
    <title>Manage Noticeboard | HomaBay Hospital</title>
    
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
                        <li role="presentation" class="dropActive"><a role="menuitem" tabindex="-1" href="administrator_manageNoticBoard.php">
                           <i class="fa fa-columns"></i> Manage Noticboard
                        </a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="administrator_systemSetting.php">
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
                            <h3> <i class="fa fa-info-circle"></i> Manage Noticeboard</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> Noticeboard List</a></li>
               <li class="departmentTab" data-toggle="tab" data-target="#departmentAdd"><a href="#"><i class="fa fa-plus"></i> Add Noticeboard</a></li>
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
                                <th>Title</th>
                                <th>Notice</th>
                                <th>Day</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Time</th>
                                <th>Promp</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Title</th>
                                <th>Notice</th>
                                <th>Day</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Time</th>
                                <th>Promp</th>
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
                                <label for="Noticeboard-title" class="control-label col-lg-4">Title</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="title">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="Noticeboard-notice" class="control-label col-lg-4">Notice</label>
                                <div class="col-lg-6">
                                   <input type="text" class="form-control" name="notice">
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="Noticeboard-date" class="control-label col-lg-4">Date</label>
                                <div class="col-lg-2">
                                    <select name="day" id="" class="form-control">
                                        <option value="">--- select day ---</option>
                                        <option value="01">01</option><option value="02">02</option>
                                        <option value="03">03</option><option value="04">04</option>
                                        <option value="05">05</option><option value="06">06</option> 
                                        <option value="07">07</option><option value="08">08</option>
                                        <option value="09">09</option><option value="10">10</option>
                                        <option value="11">11</option><option value="12">12</option> 
                                        <option value="13">13</option><option value="14">14</option>
                                        <option value="15">15</option><option value="16">16</option> 
                                        <option value="17">17</option><option value="18">18</option>
                                        <option value="19">19</option><option value="20">20</option>
                                        <option value="21">21</option><option value="22">22</option>
                                        <option value="23">23</option><option value="24">24</option><option value="">25</option>
                                        <option value="23">23</option><option value="27">27</option>
                                        <option value="28">28</option><option value="29">29</option> 
                                        <option value="30">30</option><option value="31">31</option>
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <select name="month" id="" class="form-control">
                                        <option value="">--- select month ---</option>
                                        <option value="January">January</option><option value="February">February</option>
                                        <option value="March">March</option><option value="April">April</option>
                                        <option value="May">May</option><option value="June">June</option> 
                                        <option value="July">July</option><option value="August">August</option>
                                        <option value="September">September</option><option value="October">October</option>
                                        <option value="November">November</option><option value="December">December</option> 
                                    </select>
                                </div>
                                <div class="col-lg-2">
                                    <select name="year" id="" class="form-control"> 
                                        <option value="">--- select year ---</option>
                                        <option value="2017">2017</option><option value="2018">2018</option>
                                        <option value="2019">2019</option><option value="2020">2020</option>
                                        <option value="2021">2021</option><option value="2022">2022</option> 
                                        <option value="2023">2023</option><option value="2024">2024</option>
                                        <option value="2025">2025</option><option value="2026">2026</option>
                                        <option value="2027">2027</option><option value="2028">2028</option> 
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="Noticeboard-time" class="control-label col-lg-4">Time</label>
                                <div class="col-lg-4">
                                   <input type="time" class="form-control" name="mytime">
                                </div>

                                <div class="col-lg-2">
                                    <select name="promp" id="" class="form-control"> 
                                        <option value="am">am</option>
                                        <option value="pm">pm</option>
                                        <option value="midnight/noon">midnight/noon</option>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <br>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                   <button type="submit" name="addNoticeboard" class="btn btn-info">Add Noticboard</button>
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
            <?php include('includes/footer/footer.php'); ?>
        </form>
    </footer>

    <script>
        $(document).ready(function() {
            var dataTable = $('#example').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url:"core/administrator_data/noticeboardFetch.php",
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
        $(document).on('click','#getEdit',function(e) {
            e.preventDefault();
            var per_id=$(this).data('id');
            $('#content-data').html('');
            $.ajax({
                url: 'core/administrator_data/editNoticeboard.php',
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

