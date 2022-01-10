<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
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

		    if(isset($_SESSION['notifydup'])){
        		echo $_SESSION['notifydup'];
        		$_SESSION['notifydup'] = null;
        		//unset($_SESSION['duplicate']);
    		}

		    if(isset($_SESSION['notify'])){
        		echo $_SESSION['notify'];
        		$_SESSION['notify'] = null;
    		}

    		if(isset($_SESSION['duplicate'])){
        		echo $_SESSION['duplicate'];
        		$_SESSION['duplicate'] = null;
        		//unset($_SESSION['duplicate']);
    		}

			//variables
			$conn = new mysqli('remotemysql.com', 'S1UWGxS9EP', '9JyPxQxyIw');
			$safealertdb = mysqli_connect('remotemysql.com', 'S1UWGxS9EP', '9JyPxQxyIw', 'S1UWGxS9EP');
			

			//check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			}
			else
			    echo 'Connection Success';

			//login
			if (isset($_POST['login'])){
				$name = $_POST['username'];
				$pass = $_POST['password'];

				$query = mysqli_query($safealertdb, "SELECT user_id FROM user WHERE username = '$name' AND password = '$pass'");
				
				if (mysqli_num_rows($query) == 1) {
					$_SESSION['username'] = $name;
					echo "<div class='notify'>Login Success</div>";
					header('location:main.php');
				}
			}


			//add student
			if (isset($_POST['addstud'])){
				$id = $_POST['inputid'];
				$name = $_POST['inputname'];
				$college = $_POST['inputcollege'];
				$contact = $_POST['inputcont'];
				$error = 'none';
				$checkid_query = mysqli_query($safealertdb, "SELECT * FROM student WHERE stud_id = '$id'");
				while($row = mysqli_fetch_array($checkid_query)){
        			echo "<div class='notify'>ERROR: Student ID: " . $row['stud_id'] . " already exists" .  " </div>";
        			$error = 'error';
	        	}
	        	
	        	if ($error === 'none'){
	        		
	        		//insert data into table/database
					$query = "INSERT INTO student (stud_id, studname, college, contact)
					VALUES('$id', '$name', '$college', $contact)";
					mysqli_query($safealertdb, $query);

					$_SESSION['add'] = 1;
					echo "<div class='notify'>Student adding complete</div>";
	        	}

	        	else{
	        		echo "<div class='notify'>Student adding failed</div>";
	        	}
			}

			//add event
			if (isset($_POST['addevnt'])){
				$name = $_POST['inputevntname'];
				$area = $_POST['inputevntarea'];
				$host = $_POST['inputevnthost'];
				$info = $_POST['inputevntinfo'];
				$date = $_POST['inputevntdate'];
				//$start = $_POST['inputevntstart'];
				//$end = $_POST['inputevntend'];
				$start = '';
				$end = '';

				if (empty($info)) {
					$info = '(none)';
				}

				//insert data into table/database
				$query = "INSERT INTO event (evntname ,evntarea, host_id, evntinfo, evntdate, evntstart, evntend)
				VALUES('$name' , '$area', '$host', '$info', '$date', '$start', '$end')";
				mysqli_query($safealertdb, $query);

				$_SESSION['add'] = 1;
				echo "<div class='notify'>Event adding complete</div>";
			}

			//add host
			if (isset($_POST['addhost'])){
				$name = $_POST['inputhostname'];
				$type = $_POST['inputhosttype'];
				$info = $_POST['inputhostinfo'];

				if (empty($info)) {
					$info = '(none)';
				}

				//insert data into table/database
				$query = "INSERT INTO host (hostname, type, hostinfo)
				VALUES('$name','$type','$info')";
				mysqli_query($safealertdb, $query);

				$_SESSION['add'] = 1;
				echo "<div class='notify'>Host adding complete</div>";
			}


			//add login attendance
			if (isset($_POST['attnlogin'])){
				$studid = $_POST['inputattnstudid'];
				$evntid = $_POST['inputattnevnt'];
				$date = date("Y-m-d");
				$time = date("h:i A") . "\n";
				$status = 'Logged In';

				if(empty($evntid)){
					$_SESSION['notify'] = "<div class='notify'>ERROR: Login failed - No event selected</div>";
					header('location:main.php');
				}
				$number = range(10000, 99999);
				shuffle($number);
				$attnid = $number[0];

				$break = 0;
				$studcolquery = mysqli_query($safealertdb, "
					SELECT * FROM student
				 	WHERE stud_id = '$studid'");
				while($row = mysqli_fetch_array($studcolquery)){
	        		$studcol = $row['college'];
		        }

				$hostquery = mysqli_query($safealertdb, "
					SELECT * FROM event
					INNER JOIN host
					ON event.host_id = host.host_id
				 	WHERE evnt_id = '$evntid'");
				while($row = mysqli_fetch_array($hostquery)){
	        		$hosttype = $row['type'];
	        		$hostcol = $row['hostname'];
		        }

		        $attnnumquery = "SELECT * FROM attendance WHERE stud_id = '$studid' LIMIT 1";
				$result = mysqli_query($safealertdb, $attnnumquery);
				$user = mysqli_fetch_assoc($result);

		        if ($hosttype === 'college') {
		        	if($studcol === $hostcol){

		        	}

		        	else{
		        		$break = 'true';
		        	}
		        }

		        if ($break === 'true') {
		        	echo "<div class='notify'>ERROR: Login Failed - Student: " . $studid . " is not enrolled on the college of the chosen event</div>";
		        }
				
				if($user['status'] === 'Logged Out'){
					if ($break === 'true') {

					}
					else{
						$updatequery = "
						UPDATE attendance
						SET status = '$status', attn_date = '$date', attn_time = '$time', evnt_id = '$evntid'
						WHERE stud_id = '$studid'";

						mysqli_query($safealertdb, $updatequery);

						$query = mysqli_query($safealertdb, "
							SELECT * FROM event
		                    INNER JOIN host
		                    ON event.host_id=host.host_id
		                    WHERE event.evnt_id='$evntid'");
						while($row = mysqli_fetch_array($query)){
		        			$hostid = $row['host_id'];
			        	}

						$query = "
							INSERT INTO attendancelog (attn_id, status, stud_id, evnt_id, host_id, attn_date, attn_time)
							VALUES('$attnid','Logged In', '$studid','$evntid','$hostid','$date','$time')";

						mysqli_query($safealertdb, $query);
						echo "<div class='notify'>Student: " . $studid . " is now logged in</div>";
					}
				}

				else if($user['status'] === 'Logged In'){
					echo "<div class='notify'>ERROR: Student: " . $studid . " is already logged in</div>";
				}
				else{
					if ($break === 'true') {

					}
					else{
						do {
							shuffle($number);
							$attnid = $number[0];
						} while ($user['attn_id'] === $attnid);

						$query = mysqli_query($safealertdb, "
							SELECT * FROM event
		                    INNER JOIN host
		                    ON event.host_id=host.host_id
		                    WHERE event.evnt_id='$evntid'");
						while($row = mysqli_fetch_array($query)){
		        			$hostid = $row['host_id'];
			        	}
			        	//echo "ATTEND ID: ".$attnid."</br>";
			        	//echo "STATUS: ".$status."</br>";
			        	//echo "STUDENT ID: ".$studid."</br>";
			        	//echo "HOST ID: ".$hostid."</br>";
			        	//echo "EVENT ID: ".$evntid."</br>";
			        	//echo "DATE: ".$date."</br>";
			        	//echo "TIME: ".$time."</br>";

						$query = "
							INSERT INTO attendance (attn_id, status, stud_id, evnt_id, host_id, attn_date, attn_time)
							VALUES('$attnid','$status', '$studid','$evntid','$hostid','$date','$time')";

						mysqli_query($safealertdb, $query);
						$query = "
							INSERT INTO attendancelog (attn_id, status, stud_id, evnt_id, host_id, attn_date, attn_time)
							VALUES('$attnid','$status', '$studid','$evntid','$hostid','$date','$time')";

						mysqli_query($safealertdb, $query);
						echo "<div class='notify'>Student: " . $studid . " is now logged in</div>";
					}
				}
			}

			//add logout attendance
			if (isset($_POST['attnlogout'])){
				$studid = $_POST['inputattnlogout'];
				$date = date("Y-m-d");
				$time = date("h:i A") . "\n";
				$status = 'Logged Out';

				$number = range(10000, 99999);
				shuffle($number);
				//$attnid = $number[0];

				/*$attnnumquery = "SELECT * FROM attendancelog WHERE attn_id = '$attnid' LIMIT 1";
				$result = mysqli_query($attendb, $attnnumquery);
				$user = mysqli_fetch_assoc($result);

				do {
					shuffle($number);
					$attnid = $number[0];
				} while ($user['attn_id'] === $attnid);
				*/

				$countquery = mysqli_query($safealertdb, "
					SELECT * FROM student"); //WHERE stud_id='$studid'

				$count = 0;
				while($row = mysqli_fetch_array($countquery)){
					$count++;
				}

				$count2 = 0;
				$studexist = 0;
				$logout = 0;
				$lquery = mysqli_query($safealertdb, "SELECT * FROM student");
				while($row = mysqli_fetch_array($lquery)){
					$count2++;
					
					$studidcomp = $row['stud_id'];
					//echo "studidcomp: " . $studidcomp. "</br>";
					//echo "studid: ". $studid. "</br></br>";
					if ($studid === $studidcomp) {
						
						$studexist = 'true';
						$query = mysqli_query($safealertdb, "
						SELECT * FROM attendance WHERE stud_id = '$studid'");

						while($row = mysqli_fetch_array($query)){

							$statuscomp = $row['status'];
							if ($statuscomp === 'Logged In'){
								$studexist = 0;
								$evntid = $row['evnt_id'];
		        				$hostid = $row['host_id'];
		        				$attnid = $row['attn_id'];

								$updatequery = "
								UPDATE attendance
								SET status = '$status', attn_date = '$date', attn_time = '$time'
								WHERE stud_id = '$studid'";
								mysqli_query($safealertdb, $updatequery);

								$outquery = "
								INSERT INTO attendancelog (attn_id, status, stud_id, evnt_id, host_id, attn_date, attn_time)
								VALUES('$attnid','$status', '$studid','$evntid','$hostid','$date','$time')";

								mysqli_query($safealertdb, $outquery);
								echo "<div class='notify'>Student: " . $studid . " is now logged out</div>";
								$logout = 'true';
								break;
							}

							else if ($statuscomp === 'Logged Out') {
								$logout = 'true';
								echo "<div class='notify'>ERROR: Student: " . $studid . " is already logged out</div>";
								break;
							}
						}
					}

					else if($logout ==='true'){
						break;
					}

					else if ($count === $count2){
						//echo "studexist: " . $studexist;
						if ($studexist === 'true'){
							echo "<div class='notify'>ERROR: Student: " . $studid . " never logged in</div>";
							break;
						}
						echo "<div class='notify'>ERROR: Student: " . $studid . " does not exist</div>";
						break;
					}
        			//$studid = $row['stud_id'];
        			//$evntid = $row['evnt_id'];
        			//$hostid = $row['host_id'];
	        	}
	        	//echo "ATTEND ID: ".$attnid."</br>";
	        	//echo "STATUS: ".$status."</br>";
	        	//echo "STUDENT ID: ".$studid."</br>";
	        	//echo "EVENT ID: ".$evntid."</br>";
	        	//echo "HOST ID: ".$hostid."</br>";
	        	//echo "DATE: ".$date."</br>";
	        	//echo "TIME: ".$time."</br>";

				/*$updatequery = "
					UPDATE attendance
					SET status = '$status', attn_date = '$date', attn_time = '$time'
					WHERE attn_id = '$attnid'";

				mysqli_query($attendb, $updatequery);
				$query = "
					INSERT INTO attendancelog (attn_id, status, stud_id, evnt_id, host_id, attn_date, attn_time)
					VALUES('$attnid','$status', '$studid','$evntid','$hostid','$date','$time')";

				mysqli_query($attendb, $query);
				echo "<div class='notify'>Student: " . $studid . " is now logged out</div>";*/
			}


			//delete student
			if (isset($_POST['delstud'])){
				$id = $_POST['inputdeletestud'];

				//insert data into table/database
				$query = "DELETE FROM student
				WHERE stud_id = '$id'";
				mysqli_query($safealertdb, $query);

				$_SESSION['add'] = 1;
				echo "<div class='notify'>Student Delete Complete</div>";
			}

			//delete event
			if (isset($_POST['delevnt'])){
				$id = $_POST['inputdeleteevnt'];

				//insert data into table/database
				$query = "DELETE FROM event
				WHERE evnt_id = '$id'";
				mysqli_query($safealertdb, $query);
				$_SESSION['add'] = 1;
				echo "<div class='notify'>Event Delete Complete</div>";
			}

			//delete event
			if (isset($_POST['delrec'])){
				$id = $_POST['inputdeleterec'];

				//insert data into table/database
				$query = "DELETE FROM attendance
				WHERE attn_id = '$id'";
				mysqli_query($safealertdb, $query);
				$_SESSION['add'] = 1;
				echo "<div class='notify'>Record Delete Complete</div>";
			}

			//delete host
			if (isset($_POST['delhost'])){
				$id = $_POST['inputdeletehost'];

				$query = "DELETE FROM host
				WHERE host_id = '$id'";
				mysqli_query($safealertdb, $query);

				$_SESSION['add'] = 1;
				echo "<div class='notify'>Host Delete Complete</div>";
			}

		?>
	</div>
</body>
</html>