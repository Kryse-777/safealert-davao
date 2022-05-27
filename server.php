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
			    die("Database Connection failed: " . $conn->connect_error);
			}
			else
			    echo '<script>'. 'console.log("Database Connection Success");' .'</script>';



			//login
			if (isset($_POST['login'])){
				$name = $_POST['username'];
				$pass = $_POST['password'];

				$query = mysqli_query($safealertdb, "SELECT user_id FROM user WHERE username = '$name' AND password = '$pass'");
				

				//offlinelogin
				$_SESSION['username'] = $name;
				header('location:admin.php');

				//reallogin
				/*
				if (mysqli_num_rows($query) == 1) {
					$_SESSION['username'] = $name;
					echo "<div class='notify'>Login Success</div>";
					header('location:admin.php');
				}
				*/
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
            */

            /*
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