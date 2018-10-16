<?php 

session_start();
include('core/careTaker_data/careTakerSignIn.php');

?>

<!DOCTYPE Html>
<Html lang="en">
<head>    
     <!-- Include meta tag to ensure proper rendering and touch zooming -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="Christ Dominion Temple Management System. This management manage church services">
		<meta name="author" content="Schneider Michael">
    <title>careTaker Login!</title>
    
    <?php include('includes/overall_header.php'); ?>


</head>
    <style>
        
        body {
            background-image: url(images/sign-in.jpg);
            background-size: cover;
            text-align: center;
            overflow: hidden;

        }
        .administrator-loginPage{
            background-color: rgba(255,255,255,0.4);
        }

    </style>
<body>

    <!-- header>
        <!-?php include('header/admin-header.php'); ?>
    </header -->
<br>
    <div class="container" id="allAdminLoginPage">
        <!-- Displaying Error Here -->
        <div class="displayError">
            <?php if (isset($_SESSION['LoginError'])):?>
                <span class='closebtn' onclick='this.parentElement.style.display="none";'>&times;</span>
                <p>
                    <?php
                        echo $_SESSION['LoginError'];
                        unset($_SESSION['LoginError']);
                    ?>
                </p>
            <?php endif ?>
        </div>
        <div class="administrator-loginPage">
            <form action="" method="post" class="form-horizontal" role="form">
                <div class="">
                    <h4 class="administrator-loginPageHeader">HomaBay Hospital</h4>
                    <h3>Sign in</h3>
                    <h5>to continue to careTaker</h5>
                </div>
                <div class="form-group">
                    <label>                  
                        <input type="text" name="email" required> 
                        <div class="label-text">Email or phone</div>
                    </label>
                    <label>                  
                        <input type="password" name="password" required> 
                        <div class="label-text">Enter your password</div>
                    </label>
                </div>
                <div class="form-group" id="forgotGoButton">
                    <a href="">Forgot password?</a>
                    <a href="index.php" class="goBackLogin">Go back!</a>
                </div>
                <div class="form-group">
                    <div class="col-lg-12">
                        <button type="submit" name="careTakerLogin" class="btn btn-primary form-control">Sign In</button>
                    </div>
                </div>
                <br>
            </form><!--  end form -->
        </div><!-- end administrator-login  -->
        
        <!-- Login Footer -->
        <div class="loginFooter">
            <?php include('includes/footer/loginFooter.php'); ?>
        </div>
    </div>

	
	<script src="js/bootstrap.js"></script>
    
</body>
</Html>

