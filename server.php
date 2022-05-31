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

			//add risk area
            if (isset($_POST['addriskarea'])){
                $area= $_POST['inputarea'];
                $risk= $_POST['inputarisk'];
                $lat= $_POST['inputlat'];
                $long= $_POST['inputlong'];
                $rad= $_POST['inputrad'];
                $uniqid = md5(uniqid());
                if (empty($rad)){
                    $rad= 500;
                }
                    $coord ="$lat, $long";
                //echo "<script>". "console.log('coords:". $coord."');" ."</script>";
                if($risk=="None"){
                    $risk= null;
                }
                //echo "coords:" $coord;

                $result = mysqli_query($safealertdb,"SELECT * FROM riskarea WHERE area='$area'");
                $num_rows = mysqli_num_rows($result);

                if ($num_rows) {
                    echo "<div class='notify'>Error: Area ".$area." Already in Database</div>";
                }
                else{
                    //insert data into table/database
                    $query= "INSERT INTO riskarea (area, risk, coordinates, radius, uniqid, areatype)
				    VALUES('$area','$risk','$coord',$rad,'$uniqid','risk')";
                    //mysqli_query($safealertdb, $query);
                    $result = mysqli_query($safealertdb, $query);
                    if($result)
                    {
                        echo "<div class='notify'>Risk Area ".$area." Added</div>";
                    }
                    else
                    {
                        echo "<div class='notify' style='background-color: #FFB9A1'>Risk Area ".$area
                            ." Adding Failed</div>";

                    }
                }
            }

            //add misc area
            if (isset($_POST['addmiscarea'])){
                $area= $_POST['inputarea'];
                $type= $_POST['inputtype'];
                $lat= $_POST['inputlat'];
                $long= $_POST['inputlong'];
                $uniqid = md5(uniqid());
                $coord ="$lat, $long";

                //echo "<script>". "console.log('coords:". $coord."');" ."</script>";

                $result = mysqli_query($safealertdb,"SELECT * FROM miscarea WHERE area='$area'");
                $num_rows = mysqli_num_rows($result);

                if ($num_rows) {
                    echo "<div class='notify'>Error: Area ".$area." Already in Database</div>";
                }
                else{
                    //insert data into table/database
                    $query= "INSERT INTO miscarea (area, type, coordinates, uniqid, areatype)
                        VALUES('$area','$type','$coord','$uniqid', 'misc')";
                    //mysqli_query($safealertdb, $query);
                    //echo "query: ". $query;
                    $result = mysqli_query($safealertdb, $query);
                    if($result)
                    {
                        echo "<div class='notify'>Miscellaneous Area ".$area." Added</div>";
                    }
                    else
                    {
                        echo "<div class='notify' style='background-color: '#FFB9A1'>Miscellaneous Area ".$area
                            ." Adding Failed</div>";

                    }
                }
            }


            //edit area button
            if (isset($_POST['editarea'])){
                $uniqid = $_POST['inputareaid'];
                $type = $_POST['inputareatype'];
                if($type=='risk'){
                    $runiqid=$uniqid;
                    $_SESSION['runiqid'] = $runiqid;
                    header('location:editriskarea.php');
                }
                elseif ($type=='misc'){
                    $muniqid=$uniqid;
                    $_SESSION['muniqid'] = $muniqid;
                    header('location:editmiscarea.php');
                }

            }



            //edit miscarea page
            if (isset($_POST['editmiscarea'])){
                $area = $_POST['editmarea'];
                $type =$_POST['editmtype'];
                $lat =$_POST['editmlat'];
                $long =$_POST['editmlong'];
                $uniqid =$_POST['inputmuniqid'];

                $coord ="$lat, $long";

                $query= "UPDATE `miscarea` SET `area` = '$area', `type`= '$type', `coordinates`= '$coord'
                WHERE `uniqid`='$uniqid'";
                //$_SESSION['query'] = $query;
                //$query= "INSERT INTO `status`(`class`, `alert`, `cases`, `casetwowk`, `mask`)
                //        VALUES ('$ovclass',$alert,$case,$biweek,'$mask')";

                $result = mysqli_query($safealertdb, $query);
                if($result)
                {
                    header('location:admin.php');
                    $_SESSION['notify'] = "<div class='notify'>Changes to $area Saved</div>";
                }
                else
                {
                    header('location:admin.php');
                    $_SESSION['notify'] = "<div class='notify' style='background-color: #FFB9A1'>
                    Changes to $area Not Saved</div>";

                }
            }

            //edit riskarea page
            if (isset($_POST['editriskarea'])){
                $area = $_POST['editrarea'];
                $risk =$_POST['editrisk'];
                $lat =$_POST['editrlat'];
                $long =$_POST['editrlong'];
                $radius =$_POST['editradius'];
                $uniqid =$_POST['inputruniqid'];

                $coord ="$lat, $long";

                $query= "UPDATE `riskarea` SET `area` = '$area', `risk`= '$risk', `coordinates`= '$coord',
                        `radius`='$radius' WHERE `uniqid`='$uniqid'";
                $_SESSION['query'] = $query;
                //$query= "INSERT INTO `status`(`class`, `alert`, `cases`, `casetwowk`, `mask`)
                //        VALUES ('$ovclass',$alert,$case,$biweek,'$mask')";



                $result = mysqli_query($safealertdb, $query);
                if($result)
                {
                    header('location:admin.php');
                    $_SESSION['notify'] = "<div class='notify'>Changes to $area Saved</div>";
                }
                else
                {
                    header('location:admin.php');
                    $_SESSION['notify'] = "<div class='notify' style='background-color: #FFB9A1'>Changes to $area 
                    Not Saved</div>";

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
                    echo "<div class='notify' style='background-color: #FFB9A1'>Info Table Update Failed</div>";

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
                    echo "<div class='notify' style='background-color: #FFB9A1'>Status Update Failed</div>";

                }
            }

            //generate unique id button
            /*
            if (isset($_POST['genuniqid'])){
                $id=null;
                $i=0;
                $result = mysqli_query($safealertdb, "SELECT uniqid, id, areatype FROM riskarea
                UNION SELECT uniqid, id, areatype FROM miscarea");

                while($row = mysqli_fetch_array($result)){
                    $i++;
                    $uniqid = md5(uniqid());
                    echo $i . " id: " . $uniqid ."</br>";
                    if($row['areatype']=='risk'){
                        $id= $row['id'];
                        $query= "UPDATE `riskarea` SET `uniqid` = '$uniqid' WHERE `id`= $id";
                    }
                    elseif($row['areatype']=='misc'){
                        $id= $row['id'];
                        $query= "UPDATE `miscarea` SET `uniqid` = '$uniqid' WHERE `id`= $id";
                    }

                    $result1 = mysqli_query($safealertdb, $query);
                    if($result1)
                    {
                        echo "<div class='notify'>Unique ID Generated</div>";
                    }
                    else
                    {
                        echo "<div class='notify'>Unique ID Generation Failed</div>";

                    }
                }
            }
            */


            //update account
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


                //reallogin
                if (mysqli_num_rows($check) == 1) {
                    if($newmdpass!=$curmdpass){
                        if(empty($newmdpass)){
                            $newmdpass = $curmdpass;
                        }

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
                            echo "<div class='notify' style='background-color: #FFB9A1'>Account Update Failed</div>";

                        }
                    }
                    else{
                        echo "<div class='notify' style='background-color: #FFB9A1'>
                        New Password Cannot Be The Same As Current Password</div>";
                    }
                }
                else{
                    echo "<div class='notify' style='background-color: #FFB9A1'>Wrong Password</div>";
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