<?php

    session_start(); 
    
    include('core/accountant_data/accountantSignIn.php');
    include('core/accountant_data/registerTakePayment.php');
    include('core/accountant_data/UpdateNewTakePayment.php');

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
    <title>Manage Inovice|HomaBay Hospital</title>
    
    <?php include('includes/accountantoverall-header.php'); ?>
    
    <link rel="stylesheet" href="css/style/accountant/allstyle.css">


</head>
    <style>
    </style>

<body>

    <header>
        <?php include('includes/header/accountant-header.php'); ?>
    </header>
<br>
    <div id="container" class="container">
        <div class="sidebar">
            <ul id="nav" class="nav sidebar-nav">
                <li class="myBlogsiteDashboard_profile">
                    <?php
                        $query = "SELECT * FROM accountant WHERE email = '".$_SESSION['email']."' ";
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
                    <a href="accountant_home.php">
                       <i class="fa fa-desktop fa-2x"></i> 
                       <span> Dashboard</span>
                    </a>
                </li>
                <li class="active">
                    <a href="accountant_takePayment.php">
                       <i class="fa fa-newspaper-o fa-2x"></i> 
                       <span> Invoice / Take Payment</span>
                    </a>
                </li>
                <li>
                    <a href="accountant_viewPayment.php">
                       <i class="fa fa-money fa-2x"></i> 
                       <span> View Payment</span>
                    </a>
                </li>
                <li>
                    <a href="accountant_profile.php">
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
                            <h3> <i class="fa fa-info-circle"></i> Manage Invoice</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> Invoice List</a></li>
               <li class="departmentTab" data-toggle="tab" data-target="#departmentAdd"><a href="#"><i class="fa fa-plus"></i> Add Invoice</a></li>
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
                                
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                               
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Patient</th>
                                <th>Date</th>
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
                        <form action="accountant_takePayment.php" method="post" class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="accountant-patient" class="control-label col-lg-4">Patient</label>
                                <div class="col-lg-6">
                                   <?php
                                        $query = "SELECT * FROM patients";
                                        $result1 = mysqli_query($conn, $query);
                                        
                                    ?>
                                    <select name="patient_name" class="form-control" id="">
                                        <?php while ($row = mysqli_fetch_array($result1)): ?>
                                            <option name="patient_name"><?php echo $row[1];?></option>
                                        <?php endwhile?>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="accountant-title" class="control-label col-lg-4">Title</label>
                                <div class="col-lg-6">
                                   <input name="title" type="text" class="form-control">
                                </div>
                            </div><!-- end form-group -->
                            <div class="form-group">
                                <label for="accountant-amount" class="control-label col-lg-4">Amount</label>
                                <div class="col-lg-6">
                                    <input name="amount" type="text" class="form-control">
                                </div>
                            </div><!-- end form-group -->
                            <div class="form-group">
                                <label for="accountant-description" class="control-label col-lg-4">Description</label>
                                <div class="col-lg-6">
                                   <textarea name="description" type="text" id="" cols="73" rows="5"></textarea>
                                </div>
                            </div><!-- end form-group -->
                            
                            <div class="form-group">
                                <label for="accountant-status" class="control-label col-lg-4">Method</label>
                                <div class="col-lg-6">
                                    <select name="method" class="form-control" id="">
                                        <option value="Cash">Cash</option>
                                        <option value="M-Pesa">M-Pesa</option>
                                        <option value="NHIF Card">NHIF Card</option>
                                        <option value="Visa Card">Visa Card</option>
                                    </select>
                                </div>
                            </div><!-- end form-group -->

                            <div class="form-group">
                                <label for="accountant-status" class="control-label col-lg-4">Status</label>
                                <div class="col-lg-6">
                                    <select name="status" class="form-control" id="">
                                        <option value="Unpaid">Unpaid</option>
                                        <option value="Paid">Paid</option>
                                    </select>
                                </div>
                            </div><!-- end form-group -->
                            <div class="form-group">
                                <label for="accountant-date" class="control-label col-lg-4">Date</label>
                                <div class="col-lg-6">
                                   <input type="date" class="form-control" name="date">
                                </div>
                            </div><!-- end form-group -->

                            <br>
                            <div class="form-group">
                                <div class="col-lg-6 col-lg-offset-4">
                                   <button type="submit" name="addInvoice" class="btn btn-info">Add Invoice</button>
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
                    url:"core/accountant_data/addInvoiceFetch.php",
                    type:"post"
                }
            });
        });
    </script>
	<!--  Script for getEdit data  -->
    <script> 
        $(document).on('click', '#getEdit', function(e) {
            e.preventDefault();
            var per_id = $(this).data('id');
            $('#content-data').html('');
            $.ajax({
                url: 'core/accountant_data/editInvoice.php',
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
        $sqldelete = "DELETE FROM invoice WHERE id='$id'";
        $result_delete = mysqli_query($conn, $sqldelete);
        if ($result_delete) {
            echo "<script>window.location.href='accountant_takePayment.php'</script>";
        } else {
            echo "<script>alert('deleteing data fail. try again')</script>";
        }
    }
    
    ?>
	<!--script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

