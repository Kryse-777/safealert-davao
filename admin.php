<?php
	include 'server.php';
    if (session_status()==PHP_SESSION_NONE){
        session_start();
    }

    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }
    //echo "query: " . $_SESSION['query'] . "</br>";
    $_SESSION['notify']=null;
    echo $_SESSION['notify'];
?>

<!DOCTYPE html>
<html>
<head>
	<title>SafeAlert Davao</title>

	<!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"/>

    <!-- JavaScript -->
    <script type="text/javascript" src="js/areasearch.js"></script>
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <!--script src="js/ajax.js"></script-->
    <script src="assests/plugins/moment/moment.min.js"></script>
    <script type="text/javascript" src="js/sorttable.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>

    <!-- Server Notify Hide -->
    <script type="text/javascript">
        $(document).ready( function() {
            $('.notify').delay(5000).fadeOut();
        });
    </script>

    <script>
        $.post('server.php', $('#updstatform').serialize())
    </script>

    <!--Admin Table Search-->
    <script>
        function searchAdminarea() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("tblsearchadmin");
            filter = input.value.toUpperCase();
            table = document.getElementById("admintable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    }
                    else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>

    <!-- Submit no Page Reload -->
    <script>
        $("#updstatbtn").click(function() {
            var url = "server.php"; // the script where you handle the form input.
            $.ajax({
                type: "POST",
                url: url,
                data: $("#updstatform").serialize(), // serializes the form's elements.
                success: function(data)
                {
                    alert(data); // show response from the php script.
                }
            });
            return false; // avoid to execute the actual submit of the form.
        });
    </script>

    <!-- Nav Dash -->
    <script type="text/javascript">
    	$(document).ready(function(){
            $("#dashboard a").click(function(e){
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>

    <!-- Datepicker -->
    <!--script type="text/javascript">
        $(document).ready(function () {
            $('#datepicker').datepicker();
        ...
        });
    </script-->

    <!-- Radio Add Area -->
    <!--script type="text/javascript">
        $(document).ready(function() {
            $("input[name$='cars']").click(function() {
            var test = $(this).val();

            $("div.desc").hide();
            $("#Cars" + test).show();
            });
        });
    </script-->

</head>
<body>
    <div class="adminheader" id="usertype">
        Welcome <div id="usertypename"><?php echo $_SESSION['username']?></div>
    
        <a href="logout.php" id="logoutbtn" style="background-color: red;" class="btn btn-primary">Logout</a></br>
    </div>

    <div class="head">
    	Safealert Davao Administration Control Panel
    </div>

        <!-- Dashboard -->
        <ul id="dashboard" class="nav nav-pills">
        	<li class="nav-item">
                <a href="#maindash" id="maintab" class="nav-attend nav-link regbtn active">Dashboard</a>
           	<li>
            <li class="nav-item">
                <a href="#mapform" id="addownbtn" class="nav-attend nav-link regbtn ">Modify Map</a>
           	<li>
            <!--li class="nav-item">
                <a href="#infoform" class="nav-attend nav-link regbtn ">Change Info</a>
            <li-->
            <li class="nav-item">
                <a href="#statform" class="nav-attend nav-link regbtn ">Change Status</a>
            </li>
            <li class="nav-item">
                <a href="#accform" class="nav-attend nav-link regbtn ">Account</a>
            </li>
        </ul>
    <div class="tab-content">

        <!--Main Page-->
    	<div class="tab-pane fade show active" id="maindash"><br/>
            <div id="dashname" <b>SafeAlert Davao Admin Access</b></div>
    		<div id="admindash" class="adminform">

    			<div id="dashgroup">
                    <?php
                        $query= "USE S1UWGxS9EP;
                        SHOW TABLES";
                        $result = mysqli_query($safealertdb,'SHOW TABLES');
                        $markerquery = "SELECT `area`,`type` FROM `miscarea` WHERE `type` <>''
                        UNION
                        SELECT `area`,`risk` FROM `riskarea` WHERE `risk` <>''";
                        $areaquery = "SELECT `area` FROM `miscarea`
                            UNION
                            SELECT `area` FROM `riskarea`";
                        $emptyquery = "SELECT `area`,`type` FROM `miscarea` WHERE `type` =''
                        UNION
                        SELECT `area`,`risk` FROM `riskarea` WHERE `risk` =''";
                        $markerresult = mysqli_query($safealertdb,$markerquery);
                        $arearesult = mysqli_query($safealertdb,$areaquery);
                        $emptyresult = mysqli_query($safealertdb,$emptyquery);



    			    ?>
                    <div class="dashbox">
                        <span class='boxhead'>Server Status:</span><br/>
                    <?php
                        echo "<span class='boxcontent'>".$dbconn."</span>";
                    ?>
                    </div>
                    <div class="dashbox">
                        <span class='boxhead'>Database Tables:</span><br/>
                    <?php
                        $i=0;
                        while($row = mysqli_fetch_array($result)){
                            $i++;
                        //echo "&emsp;".$row['Tables_in_S1UWGxS9EP'] . "<br/>";
                        //$uniqid = md5(uniqid());
                        //echo $uniqid;
                        }
                        echo "<span class='boxcontent'>". $i."</span></div>";



                        echo "<div class='dashbox'>
                            <span class='boxhead'>Areas in Database:</span><br/>";
                        $i=0;
                        while ($row = mysqli_fetch_array($arearesult)){
                            $i++;
                        }
                        echo "<span class='boxcontent'>".$i."</span></div>";

                        $i=0;
                        while ($row = mysqli_fetch_array($markerresult)){
                            $i++;
                        }

                        echo "<div class='dashbox'><span class='boxhead'>Areas in Map: 
                        </span><br/><span class='boxcontent'>".$i."</span></div>";



                        echo "<div class='dashbox'>
                            <span class='boxhead'>Areas Not Used in Map:</span><br/>";
                        $i=0;
                        while ($row = mysqli_fetch_array($emptyresult)){
                            $i++;
                        }
                        echo "<span class='boxcontent'>".$i."</span></div>";
                    ?>

                    <!--Generate Unique ID Button-->
                    <!--form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
                        <button type="submit" name="genuniqid" class="adminbtn btn btn-primary">Gen UniqID</button>
                    </form-->

    			</div>
    		</div>
    	</div>

		<!--Map Form-->
	    <div class="tab-pane fade" id="mapform"><br/>

            <!--Area Database Table Form-->
            <div class="tablename">
                <a style="color: gray;margin-left: 10px;">MAP AREAS</a></br>

                <div class="adminsearchdiv">Area Search:
                    <input type="text" id="tblsearchadmin" onkeyup="searchAdminarea()" placeholder="" title="">
                </div>
            </div>
            <div class="adminsearchdiv table-wrapper">
                <div class="adminsearchdiv table-scroll">
                    <table id="admintable" class="adminsearchdiv assesstable infotable sortable table table-striped">
                        <thead>
                        <tr>
                            <th>Area</th>
                            <th>Type</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $result = mysqli_query($safealertdb, "SELECT area, id, areatype, type, uniqid 
                        FROM miscarea UNION SELECT area, id, areatype, risk, uniqid FROM riskarea");

                        while($row = mysqli_fetch_array($result)){
                            if($row['areatype']=='risk') {
                                if(empty($row['type'])){
                                    $color = 'white';
                                    $name = '(none)';
                                }
                                else{
                                    $color = '#FF9E9E';
                                    $name = 'Risk Area';
                                }
                            }
                            elseif ($row['areatype']=='misc')
                            {
                                if(empty($row['type'])){
                                    $color = 'white';
                                    $name = '(none)';
                                }
                                else{
                                    $color = '#83FF00';
                                    $name = 'Miscellaneous/Medical Area';
                                }
                            }
                            else{

                            }

                            echo "<tr>";
                            echo "<td style='background-color: whitesmoke;border-color:#A7A7A7'>" . $row['area'] .
                            "</td>";
                            echo "<td style='background-color: " . $color . ";'>" . $name . "</td>";
                            ?>
                                <form  method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
                                    <input type="hidden" name="inputareaid" value="<?php echo $row['uniqid']; ?>"/>
                                    <input type="hidden" name="inputareatype" value="<?php echo $row['areatype']; ?>"/>
                                    <td style='background: none;'>
                                        <input type='submit' class="editbtn" name='editarea'value='Edit'/></td>
                                </form>

                        <?php
                        }
                        echo "</tr>";
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
            <br/><br/>

            <div class="adminform">
                <div class="form-group">
                    <div id="addarealabel">Area Add</div></br>
                    <label for="select"> Type: </label>
                    <select class="form-control saselect" name="selectform" id="selectaddarea">
                        <option value="none">None</option>
                        <option value="srisk">Risk Area</option>
                        <option value="smisc">Miscellaneous Area</option>
                    </select>
                </div>
            </div>

            <!--Risk Area Add Form-->
	    	<div id="addriskdiv" class="adminform">
                <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
		            <div class="form-group">
		                <label><b>Area Name:</b></label>
		                <input type="text" class="form-control"  name="inputarea" placeholder="Input Name of Location"
                        required>
		            </div>

		            <div class="form-group">
		                <label for="risk"><b>Risk:</b></label>
                            <select class="form-control saselect" name="inputarisk" id="sarisk">
                                <option value="">None</option>
                                <option value="Low">Low</option>
                                <option value="Moderate">Moderate</option>
                                <option value="High">High</option>
                                <option value="Critical">Critical</option>
                            </select>
                            <br>
		            </div>

                    <div class="form-group">
                        <label><b>Cases in the past two weeks:</b></label>
                        <input type="text" pattern="^[0-9]*$" class="form-control" title="Only numeric
		                characters are allowed" name="inputtwkcase"
                        placeholder="Input Amount of COVID-19 Cases in the past two weeks">
                    </div>

                    <div class="form-group">
                        <label><b>Total cases:</b></label>
                        <input type="text" pattern="^[0-9]*$" class="form-control" title="Only numeric
		                characters are allowed" name="inputtotal" placeholder="Input Total Amount of COVID-19 Cases">
                    </div>

		            <div class="form-group">
		                <label><b>Coordinates</b></label><br/>
		                <label>Latitude (maximum of 4 decimals):</label>
		                <input type="text" pattern="^[0-9]*.[0-9]{0,4}$" class="form-control" title="You must input a
		                 numeric value of up to 4 decimals" name="inputlat"
                        placeholder="Input Area Latitude Coordinate" required>
		                <label>Longitude (maximum of 4 decimals):</label>
		                <input type="text" pattern="^[0-9]*.[0-9]{0,4}$" class="form-control" title="You must input a
		                 numeric value of up to 4 decimals" name="inputlong"
                        placeholder="Input Area Longitude Coordinate" required>
		            </div>

		            <div class="form-group">
                        <label><b>Radius:</b> (default value is 500 if left empty)</label>
                        <input type="text" pattern="^[0-9]*$" value="500" class="form-control" title="Only numeric
		                characters are allowed" name="inputrad" placeholder="Input Area Warning Circle Radius">
                    </div>

		            <!--div class="form-group form-check">
		                <input type="checkbox" class="form-check-input" id="chckboxowneradd">
		                <label class="form-check-label" for="chckboxuseradd">User Admin</label>
		            </div-->
		            <button type="submit" name="addriskarea" class="adminbtn btn btn-primary">Add Area</button>
		        </form>
	    	</div>

            <!--Misc Area Add Form-->
            <div id="addmiscdiv" class="adminform">
                <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
                    <div class="form-group">
                        <label><b>Area Name:</b></label>
                        <input type="text" class="form-control"  name="inputarea" placeholder="Input Name of Location"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="type"><b>Type:</b></label>
                        <select class="form-control saselect" name="inputtype" id="sarisk">
                            <option value="">None</option>
                            <option value="Test">COVID-19 Testing Facility</option>
                            <option value="Vaccine">COVID-19 Vaccination Facility</option>
                        </select>
                        <br>
                    </div>

                    <div class="form-group">
                        <label><b>Coordinates</b></label><br/>
                        <label>Latitude (maximum of 4 decimals):</label>
                        <input type="text" pattern="^[0-9]*.[0-9]{0,4}$" class="form-control" title="You must input a
                             numeric value of up to 4 decimals" name="inputlat"
                               placeholder="Input Area Latitude Coordinate" required>
                        <label>Longitude (maximum of 4 decimals):</label>
                        <input type="text" pattern="^[0-9]*.[0-9]{0,4}$" class="form-control" title="You must input a
                             numeric value of up to 4 decimals" name="inputlong"
                               placeholder="Input Area Longitude Coordinate" required>
                    </div>

                    <!--div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="chckboxowneradd">
                        <label class="form-check-label" for="chckboxuseradd">User Admin</label>
                    </div-->
                    <button type="submit" name="addmiscarea" class="adminbtn btn btn-primary">Add Area</button>
                </form>
            </div>

        </div>

	    <!--Info Form-->
	    <div class="tab-pane fade" id="infoform"><br/>
    	<div class="adminform">
	        <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
	            <div class="form-group">
	                <label><b>Risk Table Sorting:</b></label>
	                <div class="radiobtn">
	                    <input type="radio" class="radioprov" name="inputrisksort" value="rnameas" required> Area Name Descending</br>
	                    <input type="radio" class="radioprov" name="inputrisksort" value="rnamedes" required> Area Name Ascending</br>
	                    <input type="radio" class="radioprov" name="inputrisksort" value="riskas" required> Risk Level Descending</br>
	                    <input type="radio" class="radioprov" name="inputrisksort" value="riskdes" required> Risk Level Ascending</br>
	                </div>
	            </div>
	       	</form>
	        <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">    
	            <div class="form-group">
	                <label><b>Miscellaneous Table Sorting:</b></label>
	                <div class="radiobtn">
	                    <input type="radio" class="radioprov" name="inputmiscsort" value="mnameas" required> Area Name Descending</br>
	                    <input type="radio" class="radioprov" name="inputmiscsort" value="mnamedes" required> Area Name Ascending</br>
	                    <input type="radio" class="radioprov" name="inputmiscsort" value="typeas" required> Facility Type Descending</br>
	                    <input type="radio" class="radioprov" name="inputmiscsort" value="typedes" required> Facility Type Ascending</br>
	                </div>
	            </div>
	            <button type="submit" name="sortinfo" class="adminbtn btn btn-primary">Save Changes</button>
	        </form>
	    </div>
	    </div>

	    <!--Status Form-->
	    <div class="tab-pane fade" id="statform"><br/>
	        <form method="post" id="updstatform" action="<?php echo ($_SERVER['PHP_SELF']);?>">
	        	<div class="adminform">
                    <?php
                    $result = mysqli_query($safealertdb, "SELECT * FROM status");

                    while($row = mysqli_fetch_array($result)){
                        $datestart = $row['datestart'];
                        $dateend = $row['dateend'];

                    }
                    $createstart=date_create($datestart);
                    $createend=date_create($dateend);

                    //"F d Y" ex. March 15 2013
                    $formatstart =  date_format($createstart,"F d Y");
                    $startpieces = explode(" ", $formatstart);
                    $formatend =  date_format($createend,"F d Y");
                    $endpieces = explode(" ", $formatend);
                    ?>
                    <div class="form-group">
                        <label for="birthday"><b>Information Validity Date Range</b> (Weekly)</label><br/>
                        <?php echo "<span>Current Week Range: ".$startpieces[0]." ".$startpieces[1].
                        "-".$endpieces[1].", " .$startpieces[2]."</span>";
                        ?><br/><br/>
                        <label for="birthday">Week Start:</label>
                        <input type="date" class="form-control" id="startdate" name="inputstartdate"
                        value="<?php echo $datestart ?>">
                        <label for="birthday">Week End:</label>
                        <input type="date" class="form-control" id="startend" name="inputenddate"
                        value="<?php echo $dateend ?>">
                    </div><br/>



		            <div class="form-group">
                        <?php

                        //insert status table values
                        $result = mysqli_query($safealertdb,"SELECT * FROM status");
                        $min=null;
                        $low=null;
                        $mod=null;
                        $high=null;
                        $crit=null;

                        $zero=null;
                        $one=null;
                        $two=null;
                        $thr=null;
                        $four=null;
                        $five=null;

                        $qreq=null;
                        $qnreq=null;
                        $mreq=null;
                        $mnreq=null;
                        $sreq=null;
                        $snreq=null;

                        while($row = mysqli_fetch_array($result)){
                            if($row['class']=='Minimal'){
                                $min='selected';
                            }
                            if($row['class']=='Low'){
                                $low='selected';
                            }
                            if($row['class']=='Moderate'){
                                $mod='selected';
                            }
                            if($row['class']=='High'){
                                $high='selected';
                            }
                            if($row['class']=='Critical'){
                                $crit='selected';
                            }

                            if($row['alert']==0){
                                $zero='selected';
                            }
                            if($row['alert']==1){
                                $one='selected';
                            }
                            if($row['alert']==2){
                                $two='selected';
                            }
                            if($row['alert']==3){
                                $thr='selected';
                            }
                            if($row['alert']==4){
                                $four='selected';
                            }
                            if($row['alert']==5){
                                $five='selected';
                            }

                            if($row['mask']=='true'){
                                $mreq= 'checked';
                            }
                            if($row['mask']=='false'){
                                $mnreq= 'checked';
                            }

                            if($row['shield']=='true'){
                                $sreq= 'checked';
                            }
                            if($row['shield']=='false'){
                                $snreq= 'checked';
                            }

                            if($row['qrid']=='true'){
                                $qreq= 'checked';
                            }
                            if($row['qrid']=='false'){
                                $qnreq= 'checked';
                            }
                        ?>
			                <label for="riskclass"><b>Overall Risk Classification:</b></label>
                                <select class="form-control saselect" name="inputovclass">
                                    <option value="Minimal"<?php echo"$min"?>>Minimal</option>
                                    <option value="Low"<?php echo"$low"?>>Low</option>
                                    <option value="Moderate"<?php echo"$mod"?>>Moderate</option>
                                    <option value="High"<?php echo"$high"?>>High</option>
                                    <option value="Critical"<?php echo"$crit"?>>Critical</option>
                                </select>
                                <br>
			        </div>
		            <div class="form-group">
                        <label for="alert"><b>Alert Level:</b></label>
                        <select class="form-control saselect" name="inputalert">
                            <option value="0"<?php echo"$zero"?>>0</option>
                            <option value="1"<?php echo"$one"?>>1</option>
                            <option value="2"<?php echo"$two"?>>2</option>
                            <option value="3"<?php echo"$thr"?>>3</option>
                            <option value="4"<?php echo"$four"?>>4</option>
                            <option value="5"<?php echo"$five"?>>5</option>
                        </select>
                        <br>
		            </div>

                    <div class="form-group">
                        <div class="radiobtn">
                            <label for="alert"><b>QR ID Requirement:</b></label></br>
                            <input type="radio" class="radioprov" name="inputqrid" value="true"
                                   required <?php echo"$qreq"?>>Required</br>
                            <input type="radio" class="radioprov" name="inputqrid" value="false"
                                   required <?php echo"$qnreq"?>>Not Required</br>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="radiobtn">
                            <label for="alert"><b>Face Shield Requirement:</b></label></br>
                            <input type="radio" class="radioprov" name="inputshield" value="true"
                                   required <?php echo"$sreq"?>>Required</br>
                            <input type="radio" class="radioprov" name="inputshield" value="false"
                                   required <?php echo"$snreq"?>>Not Required</br>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="radiobtn">
                            <label for="alert"><b>Mask Requirement:</b></label></br>
                            <input type="radio" class="radioprov" name="inputmask" value="true"
                            required <?php echo"$mreq"?>>Required</br>
                            <input type="radio" class="radioprov" name="inputmask" value="false"
                            required <?php echo"$mnreq"?>>Not Required</br>
                        </div>
                    </div>

		            <div class="form-group">
		                <label><b>Cumulative number of cases:</b></label>
		                <input type="text" class="form-control" pattern="^[0-9]*$" title="Only numeric characters are
		                allowed" name="inputcase" placeholder="Input Number of Cases "
                        value="<?php echo $row['cases']?>">
		            </div>

		            <div class="form-group">
		                <label><b>Number of cases in the past 2 weeks:</b></label>
		                <input type="text" class="form-control" pattern="^[0-9]*$" title="Only numeric characters are
		                allowed" name="inputbiweek" placeholder="Input Number of cases within the past 2 weeks"
                        value="<?php echo $row['casetwowk']?>">
                        <?php
                            }
                        ?>
		            </div>
		            <br/>
	            <!--div class="form-group form-check">
	                <input type="checkbox" class="form-check-input" id="chckboxowneradd">
	                <label class="form-check-label" for="chckboxuseradd">User Admin</label>
	            </div-->
	            <button type="submit" name="updstat" id="updstatbtn" class="adminbtn btn btn-primary">Save Changes
                </button>
	            </div>
	        </form>
	    </div>

        <!--Account Form-->
        <div class="tab-pane fade" id="accform"><br/>
            <div class="adminform">
                <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
                    <div class="form-group">
                        <?php
                        $name = $_SESSION['username'];
                        $result = mysqli_query($safealertdb,"SELECT * FROM `users` WHERE `username` = '$name'");

                        while($row = mysqli_fetch_array($result)){
                        ?>
                        <label><b>Username:</b></label>
                        <input type="text" class="form-control" name="inputnewname" placeholder="Input Username"
                           value="<?php echo $name ?>">
                    </div>

                    <div class="form-group">
                        <label><b>Current Password:</b> (required)</label>
                        <input type="password" class="form-control" title="Only numeric characters are
		                allowed" name="inputcurpass" placeholder="Input Current Password" required>
                    </div>

                    <div class="form-group">
                        <label><b>New Password:</b></label>
                        <input type="password" class="form-control" name="inputnewpass" placeholder="Input New Password">
                    </div>
                    
                    <?php
                    }
                    ?>
                    <button type="submit" name="accupd" class="adminbtn btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
	</div>
</body>
<!-- Select Add Area -->
<script>
    const el = document.getElementById('selectaddarea');
    const rbox = document.getElementById('addriskdiv');
    const mbox = document.getElementById('addmiscdiv');

    el.addEventListener('change', function handleChange(event) {
        if (event.target.value === 'srisk'){
            rbox.style.display = 'block';
            mbox.style.display = 'none';
        }
        else if (event.target.value === 'smisc'){
            mbox.style.display = 'block';
            rbox.style.display = 'none';
        }
        else{
            rbox.style.display = 'none';
            mbox.style.display = 'none';
        }
    });
</script>
</html>