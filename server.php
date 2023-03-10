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
        $conn = new mysqli('db4free.net', 'kryse777', 'thanksforthefish88');
        $safealertdb = mysqli_connect('db4free.net', 'kryse777', 'thanksforthefish88',
            'safealertdavao');


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
                $_SESSION['notify'] = "<div class='notify' style='background-color: #FFB9A1'>
                Login Failed</div>";
            }
        }

        //add risk area
        if (isset($_POST['addriskarea'])){
            $addarea= $_POST['inputarea'];
            $areaesc = addslashes($addarea);
            $risk= $_POST['inputarisk'];
            $twkcase= $_POST['inputtwkcase'];
            $total= $_POST['inputtotal'];
            $lat= $_POST['inputlat'];
            $long= $_POST['inputlong'];
            $rad= $_POST['inputrad'];
            $uniqid = md5(uniqid());

            if (empty($twkcase)){
                $twkcase= 0;
            }
            if (empty($total)){
                $total= 0;
            }

            if (empty($rad)){
                $rad= 500;
            }
                $coord ="$lat, $long";
            //echo "<script>". "console.log('coords:". $coord."');" ."</script>";
            if($risk=="None"){
                $risk= null;
            }
            //echo "coords:" $coord;

            $result = mysqli_query($safealertdb,"SELECT * FROM riskarea WHERE area='$areaesc'");
            $num_rows = mysqli_num_rows($result);

            if ($num_rows) {
                echo "<div class='notify' style='background-color: #FFB9A1'>Area ".$addarea." Already in Database</div>";
            }
            else{
                //insert data into table/database
                $query= "INSERT INTO riskarea (area, risk, casetwoweeks, casetotal, coordinates, radius, uniqid, areatype)
                VALUES('$areaesc','$risk',$twkcase,$total,'$coord',$rad,'$uniqid','risk')";

                //echo "query: ". $query;

                //mysqli_query($safealertdb, $query);
                $result = mysqli_query($safealertdb, $query);
                if($result)
                {
                    echo "<div class='notify'>Risk Area ".$addarea." Added</div>";
                }
                else
                {
                    echo "<div class='notify' style='background-color: #FFB9A1'>Risk Area ".$addarea
                        ." Adding Failed</div>";

                }
            }
        }

        //add misc area
        if (isset($_POST['addmiscarea'])){
            $addarea = $_POST['inputarea'];
            $areaesc = addslashes($addarea);
            $type= $_POST['inputtype'];
            $lat= $_POST['inputlat'];
            $long= $_POST['inputlong'];
            $uniqid = md5(uniqid());
            $coord ="$lat, $long";

            //echo "<script>". "console.log('coords:". $coord."');" ."</script>";

            $result = mysqli_query($safealertdb,"SELECT * FROM miscarea WHERE area='$areaesc'");
            $num_rows = mysqli_num_rows($result);

            if ($num_rows) {
                echo "<div class='notify' style='background-color: #FFB9A1'>Area ".$addarea." Already in Database</div>";
            }
            else{
                //insert data into table/database

                $query= "INSERT INTO miscarea (area, type, coordinates, uniqid, areatype)
                    VALUES('$areaesc','$type','$coord','$uniqid', 'misc')";
                //mysqli_query($safealertdb, $query);
                //echo "query: ". $query;
                $result = mysqli_query($safealertdb, $query);
                if($result)
                {
                    echo "<div class='notify'>Miscellaneous Area ".$addarea." Added</div>";
                }
                else
                {
                    echo "<div class='notify' style='background-color: #FFB9A1'>Miscellaneous Area ".$addarea
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

        //delete area button
        if (isset($_POST['deletearea'])){
            $uniqid = $_POST['inputareaid'];
            $area = $_POST['inputareaname'];

            $querymisc= "DELETE FROM `miscarea` WHERE uniqid='$uniqid'";
            $queryrisk= "DELETE FROM `riskarea` WHERE uniqid='$uniqid'";
            //echo "query: ". $query;
            $resultmisc = mysqli_query($safealertdb, $querymisc);
            $resultrisk = mysqli_query($safealertdb, $queryrisk);
            if($resultmisc)
            {
                echo "<div class='notify'>".$area." Deleted</div>";
            }
            elseif($resultrisk){
                echo "<div class='notify'>".$area." Deleted</div>";
            }
            else{
                echo "<div class='notify' style='background-color: #FFB9A1'>".$area." Area Delete Failed</div>";
            }
        }

        //edit miscarea page
        if (isset($_POST['editmiscarea'])){
            $area = $_POST['editmarea'];
            $areaesc = addslashes($area);
            $type =$_POST['editmtype'];
            $lat =$_POST['editmlat'];
            $long =$_POST['editmlong'];
            $uniqid =$_POST['inputmuniqid'];

            $coord ="$lat, $long";

            $query= "UPDATE `miscarea` SET `area` = '$areaesc', `type`= '$type', `coordinates`= '$coord'
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
            $areaesc = addslashes($area);
            $risk =$_POST['editrisk'];
            $twkcase= $_POST['edittwkcase'];
            $total= $_POST['edittotal'];
            $lat =$_POST['editrlat'];
            $long =$_POST['editrlong'];
            $radius =$_POST['editradius'];
            $uniqid =$_POST['inputruniqid'];

            $coord ="$lat, $long";

            $query= "UPDATE `riskarea` SET `area` = '$areaesc', `risk`= '$risk', `casetwoweeks`= $twkcase,
                    `casetotal`=$total, `coordinates`= '$coord', `radius`=$radius WHERE `uniqid`='$uniqid'";
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
            $startdate = $_POST['inputstartdate'];
            $enddate = $_POST['inputenddate'];
            $ovclass = $_POST['inputovclass'];
            $alert = $_POST['inputalert'];
            $qrid = $_POST['inputqrid'];
            $shield = $_POST['inputshield'];
            $mask = $_POST['inputmask'];
            $case = $_POST['inputcase'];

            $biweek = $_POST['inputbiweek'];
            $query= "UPDATE `status` SET `class` = '$ovclass', `alert`= $alert , `cases`= $case,
            `casetwowk`=$biweek,`mask` = '$mask',`shield`='$shield', `qrid` = '$qrid'
            , `datestart` = '$startdate', `dateend` = '$enddate'";
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
            //echo "new pass: ". $newpass."<br/>";
            $curmdpass = md5($curpass);
            $newmdpass = null;
            if(!empty($newpass)){
                $newmdpass = md5($newpass);
            }
            //echo "new mdpass: ". $newmdpass."<br/>";
            $curname = $_SESSION['username'];

            $query = "SELECT * FROM users WHERE username = '$curname' 
            AND password = '$curmdpass'";
            $checkpass = mysqli_query($safealertdb, $query);

            //offlinelogin
            //echo "querycheck: ". $query."<br/>";
            //$_SESSION['username'] = $name;
            //header('location:admin.php');

            if (mysqli_num_rows($checkpass) == 1) {
                if($newmdpass!=$curmdpass){
                    if(empty($newmdpass)){
                        $newmdpass = $curmdpass;
                    }

                    $queryupd = "UPDATE `users` SET `password`= '$newmdpass', `username`= '$name' 
                    WHERE `password`= '$curmdpass'";
                    //echo "queryupdate: ". $queryupd."<br/>";;
                    $result = mysqli_query($safealertdb, $queryupd);
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