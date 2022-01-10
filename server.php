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

			//test display
            $query = mysqli_query($safealertdb, "SELECT * FROM test");
            while($row = mysqli_fetch_array($query))
            {
                echo "Name:" . $row['name'] . "</br>";
                echo "Age:" . $row['age'] . "</br>";
                echo "Date:" . $row['date'] . "</br>";
                echo "Number:" . $row['number'] . "</br>";
            }
	</div>
</body>
</html>