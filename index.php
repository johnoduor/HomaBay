<?php 

require_once 'core/init.php';

if (logged_in()) {
    header("location: logout.php?Logout/Auto-Logout/you're-auto-logout...!!!");
}

?>

<!DOCTYPE Html>
<Html>
<head>    
     <!-- Include meta tag to ensure proper rendering and touch zooming -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    		<meta name="author" content="Johnney">
    <title>
        <?php
            include('core/administrator_data/administratorSignIn.php');
            $query = "SELECT * FROM systemsettings";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_array($result)) {
                echo $row['systemTitle'];
            }
        
        ?>
    </title>
    
    <?php include('includes/overall_header.php'); ?>

</head>
   <style>
        body {
            background: url(images/Healthcare.jpg);
            background-attachment: fixed;
            background-repeat: no-repeat;
            width: 100%;
            height: 100%;
            background-position: center;
            background-size: cover;
        }
        div.goog-te-gadget-simple{
            border-radius: 5px;
            background: #3498DB;
        }
        a.goog-te-menu-value {
            text-decoration: none;
        }
        a.goog-te-menu-value > span {
            color: #fff;
        }
        a.goog-te-menu-value > span > img {
            color: #fff;
        }
        .goog-te-gadget-icon {
            display: none
        }
   </style>
<body>

    <header>
        <nav class="navbar navbar-default navbar-fixed-top" id="main-navbar" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>  
                    <a href="" class="navbar-brand" style="color:#fff">
                        <?php
                            include('core/administrator_data/administratorSignIn.php');
                            $query = "SELECT * FROM systemsettings";
                            $result = mysqli_query($conn, $query);

                            while ($row = mysqli_fetch_array($result)) {
                                echo $row['systemName'];
                                // or Select show System Logo
                                //if ($row['systemLogo'] == "") {
                                //    echo "<div class='SystemLogo'><img src='uploads/".$row['systemLogo']." width='20' height='20'></div>";
                                //}
                            }

                        ?>
                    </a>
                </div>
                
            </div><!-- end container -->
        </nav><!-- end nav -->
    </header>
<br>
    <div class="container" id="myblogsite-loginPage">
        <form class="form-inline">
            <div class="form-group">
                <a href="Adminlogin.php">
                    <div class="administratorLogin">
                        <span class="fa fa-universal-access fa-4x"></span>
                        <h4 class="loginheader">Administrator</h4>
                    </div>
                </a>
            </div><!-- end form-group -->
            <div class="form-group">
                <a href="Doctorlogin.php">
                    <div class="doctorLogin">
                        <span class="fa fa-user-md fa-4x"></span>
                        <h4 class="loginheader">Doctor</h4>
                    </div>
                </a>
            </div><!-- end form-group -->
            <div class="form-group">
                <a href="Nurselogin.php">
                    <div class="nurseLogin">
                        <span class="fa fa-stethoscope fa-4x"></span>
                        <h4 class="loginheader">Nurse</h4>
                    </div>
                </a>
            </div><!-- end form-group -->
        </form>
        
        <!-- /Next Login Form\ -->
        <form class="form-inline" id="nextForm2">
            <div class="form-group">
                <a href="Patientlogin.php">
                    <div class="patientLogin">
                        <span class="fa fa-user fa-4x"></span>
                        <h4 class="loginheader">Patient</h4>
                    </div>
                </a>
            </div><!-- end form-group -->
            <div class="form-group">
                <a href="Pharmacistlogin.php">
                    <div class="pharmacistLogin">
                        <span class="fa fa-medkit fa-4x"></span>
                        <h4 class="loginheader">Pharmacist</h4>
                    </div>
                </a>
            </div><!-- end form-group -->
            <div class="form-group">
                <a href="Laboratorylogin.php">
                    <div class="nurseLogin">
                        <span class="fa fa-flask fa-4x"></span>
                        <h4 class="loginheader">Laboratory</h4>
                    </div>
                </a>
            </div><!-- end form-group -->
        </form>

        <!-- /Last Login Form\ -->
        <form class="form-inline" id="nextForm2">
            <div class="form-group">
                <a href="Accountantlogin.php">
                    <div class="administratorLogin">
                        <span class="fa fa-money fa-4x"></span>
                        <h4 class="loginheader">Accountant</h4>
                    </div>
                </a>
            </div><!-- end form-group -->
            <!--div class="form-group">
                <a href="Guardlogin.php">
                    <div class="doctorLogin">
                        <span class="fa fa-reddit-alien fa-4x"></span>
                        <h4 class="loginheader">Guard</h4>
                    </div>
                </a>
            </div--><!-- end form-group -->
            <div class="form-group">
                <a href="CareTakerlogin.php">
                    <div class="nurseLogin">
                        <span class="fa fa-google-wallet fa-4x"></span>
                        <h4 class="loginheader">Caretaker</h4>
                    </div>
                </a>
            </div><!-- end form-group -->
        </form>
        <form class="indexFooterLogin">
            <div class="form-group">
                <span>&copy; 2018 HomaBay Hospital System. All Right Reserved</span><br>
                <span>Developed and Design by Johnney :-)</span>
            </div>
        </form>
    </div>

	
	<script src="js/bootstrap.js"></script>
    
</body>
</Html>
