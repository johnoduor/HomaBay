<?php

    session_start(); 
    
    include('core/accountant_data/accountantSignIn.php');

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
    <title>View Payment|HomaBay Hospital</title>
    
    <?php include('includes/accountantoverall-header.php'); ?>
    
    <link rel="stylesheet" href="css/style/accountant/allstyle.css">
    <script type="text/javascript">   
        function printlayer(layer){
            var generator=window.open(",'name");
            var layertext = document.getElementById(layer);
            generator.document.write(layertext.innerHTML.replace("Print Me"));

            generator.document.close();
            generator.print();
            generator.close();
        }
    </script>

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
                <li>
                    <a href="accountant_takePayment.php">
                       <i class="fa fa-newspaper-o fa-2x"></i> 
                       <span> Invoice / Take Payment</span>
                    </a>
                </li>
                <li class="active">
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
                            <h3> <i class="fa fa-info-circle"></i> View Payment</h3>
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
               <li class="active departmentTab" data-toggle="tab" data-target="#departmentList"><a href="#"><i class="fa fa-reorder"></i> View Payment</a></li>
            </ul>

            <div class="tab-content" id="div-id-name">
                <div class="tab-pane active fade in" id="departmentList">
                    <table id="example" class="display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Patient</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Time</th>
                                <th>Method</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th> <i class="fa fa-hashtag"></i> </th>
                                <th>Patient</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Time</th>
                                <th>Method</th>
                                <th>Description</th>
                            </tr>
                       </tfoot>
                    </table>
                </div><!-- end tab pane for Department List  -->
            </div>
        </div>
        <h1>
    <button href="#" id="print" onclick="javascript:printlayer('div-id-name')" style="background-color: lightgreen; border-right: 20px; font-family: proxima nova;">Print Report</button>
</h1>
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
                    url:"core/accountant_data/addViewPaymentFetch.php",
                    type:"post"
                }
            });
        });
    </script>
	<!--script src="js/main/bootstrap.js"></script -->
    
</body>
</Html>

