<?php
    include 'server.php';
    if (session_status()==PHP_SESSION_NONE)
    {
        session_start();
    }
    if(isset($_SESSION['username'])){
        header('location:admin.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>SafeAlert Davao Administration Access - Login</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- JavaScript -->
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<div id="title" style="background-color: white;">
        <span style="color: #00C8FF;">Safe</span><span style="color: red;">Alert</span>
        <span style="color: black;"> Davao</span>
    </div>

	<div class="main">
            <div id="loginform">
                <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">


                    <div class="form-group">
                        <label style="font-family: arial;">Username:</label>
                        <input type="text" class="form-control"  name="username" placeholder="Input Username">
                    </div>

                    <div class="form-group">
                        <label style="font-family: arial;">Password:</label>
                        <input type="password" class="form-control" name="password" placeholder="Input Password">
                    </div>
                    <!--div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="chckboxowneradd">
                        <label class="form-check-label" for="chckboxuseradd">User Admin</label>
                    </div-->
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                </form>
            </div>
	</div>
</body>
</html>