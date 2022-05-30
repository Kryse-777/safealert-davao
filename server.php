<!DOCTYPE html>
<html>
<head>
	<title>SafeAlert Davao</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div id="server">
		<?php

		    if (session_status()==PHP_SESSION_NONE)
		    {
		        session_start();
		    }

		    date_default_timezone_set('Asia/Taipei');
		    

		    //server notify
		    if(isset($_SESSION['notify'])){
        		echo $_SESSION['notify'];
        		$_SESSION['notify'] = null;
    		}

			//variables
			
    		//local/offline
			//$conn = new mysqli('localhost', 'root', '');
			//$safealertdb = mysqli_connect('localhost', 'root', '', 'safealertdb');

			//remotemysql server
			$conn = new mysqli('remotemysql.com', 'S1UWGxS9EP', '9JyPxQxyIw');
			$safealertdb = mysqli_connect('remotemysql.com', 'S1UWGxS9EP', '9JyPxQxyIw', 'S1UWGxS9EP');
			

			//check connection
			if ($conn->connect_error) {
                $dbconn = "<a style='color:red;'>Offline</a>";
			    die("Database Connection failed: " . $conn->connect_error);
			}
			else
			    $dbconn = "<a style='color:green;'>Online</a>";
			    echo '<script>'. 'console.log("Database Connection Success");' .'</script>';



			//login
			if (isset($_POST['login'])){
				$name = $_POST['username'];
				$pass = $_POST['password'];
				$mdpass = md5($pass);

				$query = mysqli_query($safealertdb, "SELECT * FROM users WHERE username = '$name' AND password = '$mdpass'");

				//offlinelogin
				//$_SESSION['username'] = $name;
				//header('location:admin.php');

				//reallogin
				if (mysqli_num_rows($query) == 1) {
					$_SESSION['username'] = $name;
					//echo "<div class='notify'>Login Success</div>";
					header('location:admin.php');
				}
				else{
                    header('location:login.php');
                }
			}

			//add area
            if (isset($_POST['addarea'])){
                $area= $_POST['inputarea'];
                $risk= $_POST['inputarisk'];
                $lat= $_POST['inputlat'];
                $long= $_POST['inputlong'];
                $rad= $_POST['inputrad'];
                if (empty($rad)){
                    $rad= 500;
                }
                    $coord ="$lat, $long";
                echo "<script>". "console.log('coords:". $coord."');" ."</script>";
                if($risk=="None"){
                    $risk= null;
                }
                //echo "coords:" $coord;

                $result = mysqli_query($safealertdb,"SELECT * FROM riskarea WHERE area='$area'");
                $num_rows = mysqli_num_rows($result);

                if ($num_rows) {
                    echo "<div class='notify'>Error: Risk Area ".$area." Already in Database</div>";
                }
                else{
                    //insert data into table/database
                    $query= "INSERT INTO riskarea (area, risk, coordinates, radius)
				    VALUES('$area','$risk','$coord',$rad)";
                    //mysqli_query($safealertdb, $query);
                    $result = mysqli_query($safealertdb, $query);
                    if($result)
                    {
                        echo "<div class='notify'>Risk Area Added</div>";
                    }
                    else
                    {
                        echo "<div class='notify'>Risk Area Adding Failed</div>";

                    }
                }
            }

            //sort info
            if (isset($_POST['sortinfo'])){
                $risksort = $_POST['inputrisksort'];
                $miscsort = $_POST['inputmiscsort'];
                if($risksort== "rnameas"){
                    $query1="";
                }
                elseif ($risksort== "rnamedes"){

                }
                if($risksort== "riskas"){

                }
                elseif ($risksort== "riskdes"){

                }



                $result = mysqli_query($safealertdb, $query);
                if($result)
                {
                    echo "<div class='notify'>Info Table Updated</div>";
                }
                else
                {
                    echo "<div class='notify'>Info Table Update Failed</div>";

                }
            }

            //update status
            if (isset($_POST['updstat'])){
                $ovclass = $_POST['inputovclass'];
                $alert = $_POST['inputalert'];
                $qrid = $_POST['inputqrid'];
                $shield = $_POST['inputshield'];
                $mask = $_POST['inputmask'];
                $case = $_POST['inputcase'];
                $biweek = $_POST['inputbiweek'];
                $query= "UPDATE `status` SET `class` = '$ovclass', `alert`= $alert , `cases`= $case,
                `casetwowk`=$biweek,`mask` = '$mask',`shield`='$shield', `qrid` = '$qrid'";
                //$query= "INSERT INTO `status`(`class`, `alert`, `cases`, `casetwowk`, `mask`)
                //        VALUES ('$ovclass',$alert,$case,$biweek,'$mask')";

                $result = mysqli_query($safealertdb, $query);
                if($result)
                {
                    echo "<div class='notify'>Status Data Updated</div>";
                }
                else
                {
                    echo "<div class='notify'>Status Update Failed</div>";

                }
            }

            if (isset($_POST['accupd'])){
                $name = $_POST['inputnewname'];
                $curpass = $_POST['inputcurpass'];
                $newpass = $_POST['inputnewpass'];
                $curmdpass = md5($curpass);
                $newmdpass = md5($newpass);
                $curname = $_SESSION['username'];

                $check = mysqli_query($safealertdb, "SELECT * FROM users WHERE username = '$curname' 
                AND password = '$curmdpass'");

                //offlinelogin
                //$_SESSION['username'] = $name;
                //header('location:admin.php');

                if(empty($newmdpass)){
                    $newmdpass = $curmdpass;
                }

                //reallogin
                if (mysqli_num_rows($check) == 1) {
                    $query = "UPDATE `users` SET `password`= '$newmdpass', `username`= '$name' 
                    WHERE `password`= '$curmdpass'";
                    $result = mysqli_query($safealertdb, $query);
                    if($result)
                    {
                        echo "<div class='notify'>Account Updated</div>";
                        $_SESSION['username']=$name;
                    }
                    else
                    {
                        echo "<div class='notify'>Account Update Failed</div>";

                    }
                }
                else{
                    echo "<div class='notify'>Wrong Password</div>";
                }
            }

			//test database draw data display
            /*
            $query = mysqli_query($safealertdb, "SELECT * FROM test");
            while($row = mysqli_fetch_array($query))
            {
                echo "</br></br>";
                echo "Database Test</br>";
                echo "Name: " . $row['name'] . "</br>";
                echo "Age: " . $row['age'] . "</br>";
                echo "Date: " . $row['date'] . "</br>";
                echo "Number: " . $row['number'] . "</br>";
            }

            $query = mysqli_query($safealertdb, "SELECT * FROM riskarea");
            while($row = mysqli_fetch_array($query))
            {
                echo "<script>";
                echo "Database Test</br>";
                echo "Name: " . $row['name'] . "</br>";
                echo "Age: " . $row['age'] . "</br>";
                echo "Date: " . $row['date'] . "</br>";
                echo "Number: " . $row['number'] . "</br>";
                echo "<script/>";
            }*/
        ?>
	</div>
</body>
</html>