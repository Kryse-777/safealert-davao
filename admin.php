<?php
	include 'server.php';
    if (session_status()==PHP_SESSION_NONE)
    {
        session_start();
    }

    if(!isset($_SESSION['username'])){
        header('location:login.php');
    }
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


    <!-- JavaScript -->
    <script type="text/javascript" src="js/areasearch.js"></script>
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <!--script src="js/ajax.js"></script-->
    <script src="assests/plugins/moment/moment.min.js"></script>

    <!-- Nav Dash -->
    <script type="text/javascript">
    	$(document).ready(function(){
            $("#dashboard a").click(function(e){
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
</head>
<body>
    <div id="usertype">
        Welcome <div id="usertypename"><?php echo $_SESSION['username']?></div>
    
        <a href="logout.php" id="logoutbtn" style="background-color: red;" class="btn btn-primary">Logout</a></br>
    </div>

    <div class="head">
    	Safealert Davao Administration Control Panel
    </div>

        <!-- Dashboard -->
        <ul id="dashboard" class="nav nav-pills">
        	<li class="nav-item">
                <a href="#maindash" id="maintab" class="regbtn nav-attend nav-link active">Main</a>
           	<li>
            <li class="nav-item">
                <a href="#mapform" id="addownbtn" class="regbtn nav-attend nav-link">Modify Map</a>
           	<li>
            <li class="nav-item">
                <a href="#infoform" class="regbtn nav-attend nav-link">Change Info</a>
            <li>
            <li class="nav-item">
                <a href="#statform" class="regbtn nav-attend nav-link">Change Status</a>
            </li>
        </ul>
    <div class="tab-content">
    	<div class="tab-pane fade show active" id="maindash"><br/>
    		<div class="adminform">
    			<div class="form-group">
                    <?php
                        $query= "USE S1UWGxS9EP;
                        SHOW TABLES";
                        $result = mysqli_query($safealertdb,'SHOW TABLES');



    			    ?>
	    			SafeAlert Davao Admin Access<br/><br/>
	    			Server Status:
                    <?php
                        echo $dbconn;
                    ?>
                    <br/>
	    			Database Tables:<br/>
                    <?php
                        while($row = mysqli_fetch_array($result)){
                        echo "&emsp;".$row['Tables_in_S1UWGxS9EP'] . "<br/>";
                        }
                    ?>
    			</div>
    		</div>
    	</div>
		<!--Map Form-->
	    <div class="tab-pane fade" id="mapform"><br/>

	    	<!--Area Search Form-->
	    	<div class="adminform">
                <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
                    <!--div class="form-group">
                        <label>Address:</label>
                        <input type="text" class="form-control" name="inputaccadd" placeholder="Input address of property">
                    </div-->
                    <div class="form-group">
                        <label><b>Enter Name of an Area/Barangay:</b></label>

                        <!-- Search box. -->
                        <input type="text" class="form-control" name="inputattnstudid" id="areasearch" placeholder="Search for an Area" required/>
                        </br>
                        <div id="areadisplay"></div>
                        </br>
                    </div>
                    <!--div class="form-group">
                        <label><b>Area:</b></label>
                        <input type="text" class="form-control" name="inputareabackup" placeholder="Input address of area">
                    </div-->

                    <div class="form-group radio-form">
                        <fieldset>
                            <?php
                            /*
                                $now = (date("Y-m-d"));
                                echo "<b>Date Today: </b>" . $now;
                                echo "</br><label><b>Select An Area:</b></label></br>";
                                $result = mysqli_query($safealertdb, "
                                    SELECT * FROM riskarea");
                                
                                
                                while($row = mysqli_fetch_array($result))
                                {
                                    echo "<div id='radiobtn'>";
                                    echo "<input type='radio' id='evntradio' name='inputattnevnt' value='" . $row['id'] . "' required>";
                                    echo "<div id='radiobtntext'>";
                                    echo " <b>" . $row['id'] . "</b>";
                                    echo " | <b>Area:</b> " . $row['area'];
                                    echo " </br>| <b>Risk:</b> " . $row['risk'];
                                    echo "</div>";
                                    echo "</div>";
                                }
                            */
                            ?>
                        </fieldset>
                    </div>
                    <!--div class="form-group form-check">
                        <input type="checkbox" class="form-check-input" id="chckboxowneradd">
                        <label class="form-check-label" for="chckboxuseradd">User Admin</label>
                    </div-->
                    <button type="submit" name="attnlogin" class="adminbtn btn btn-primary">Save Changes</button>
                </form>
            </div><br/><br/>

            <!--Area Search Form Legacy-->
	    	<div class="adminform">
		        <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
		            <div class="form-group">
		                <label><b>Area Name:</b></label>
		                <input type="text" class="form-control"  name="inputarea" placeholder="Input Name of Location"required>
		            </div>

		            <div class="form-group">
		                <label><b>Type:</b></label>
		                <input type="text" class="form-control" name="inputtype" placeholder="Input Area Type">
		            </div>

		            <div class="form-group">
		                <label><b>Coordinates</b></label><br/>
		                <label>Latitude (maximum of 4 decimals):</label>
		                <input type="text" pattern="^[0-9]*$" class="form-control" title="Only numeric characters are allowed" name="inputcord" placeholder="Input Area Latitude Coordinate">
		                <label>Longitude (maximum of 4 decimals):</label>
		                <input type="text" pattern="^[0-9]*$" class="form-control" title="Only numeric characters are allowed" name="inputcord" placeholder="Input Area Longitude Coordinate">
		            </div>

		            <div class="form-group">
		                <label><b>Radius:</b></label>
		                <input type="text" pattern="^[0-9]*$" class="form-control" title="Only numeric characters are allowed" name="inputrad" placeholder="Input Area Warning Circle Radius">
		            </div>

		            <!--div class="form-group form-check">
		                <input type="checkbox" class="form-check-input" id="chckboxowneradd">
		                <label class="form-check-label" for="chckboxuseradd">User Admin</label>
		            </div-->
		            <button type="submit" name="addarea" class="adminbtn btn btn-primary">Add Area</button>
		        </form>
	    	</div>
	    </div>

	    <!--Info Form-->
	    <div class="tab-pane fade" id="infoform"><br/>
    	<div class="adminform">
	        <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
	            <div class="form-group">
	                <label>Risk Table Sorting:</label>
	                <div id="radiobtn">
	                    <input type="radio" class="radioprov" name="inputrisksort" value="nameas" required> Area Name Descending</br>
	                    <input type="radio" class="radioprov" name="inputrisksort" value="namedes" required> Area Name Ascending</br>
	                    <input type="radio" class="radioprov" name="inputrisksort" value="riskas" required> Risk Level Descending</br>
	                    <input type="radio" class="radioprov" name="inputrisksort" value="riskdes" required> Risk Level Ascending</br>
	                </div>
	            </div>
	       	</form>
	        <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">    
	            <div class="form-group">
	                <label>Miscellaneous Table Sorting:</label>
	                <div id="radiobtn">
	                    <input type="radio" class="radioprov" name="inputrisksort" value="nameas" required> Area Name Descending</br>
	                    <input type="radio" class="radioprov" name="inputrisksort" value="namedes" required> Area Name Ascending</br>
	                    <input type="radio" class="radioprov" name="inputrisksort" value="riskas" required> Facility Type Descending</br>
	                    <input type="radio" class="radioprov" name="inputrisksort" value="riskdes" required> Facility Type Ascending</br>
	                </div>
	            </div>
	            <button type="submit" name="addprop" class="adminbtn btn btn-primary">Save Changes</button>
	        </form>
	    </div>
	    </div>

	    <!--Status Form-->
	    <div class="tab-pane fade" id="statform"><br/>
	        <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
	        	<div class="adminform">
		            <div class="form-group">
			                <label>Risk Classification:</label>
			                <input type="text" class="form-control"  name="inputriskclass" placeholder="Input Name Davao City Risk Classification"required>
			        </div>

		            <div class="form-group">
		                <label>Alert Level:</label>
	                    <div id="radiobtn">
	                        <input type="radio" class="radioprov" name="inputalert" value="0" required> 0</br>
	                        <input type="radio" class="radioprov" name="inputalert" value="1" required> 1</br>
	                        <input type="radio" class="radioprov" name="inputalert" value="2" required> 2</br>
	                        <input type="radio" class="radioprov" name="inputalert" value="3" required> 3</br>
	                        <input type="radio" class="radioprov" name="inputalert" value="4" required> 4</br>
	                        <input type="radio" class="radioprov" name="inputalert" value="5" required> 5</br>
	                    </div>
		            </div>

		            <div class="form-group">
		                <label>Cumulative number of cases:</label>
		                <input type="text" class="form-control" pattern="^[0-9]*$" title="Only numeric characters are allowed" name="inputcum" placeholder="Input Area Coordinates">
		            </div>

		            <div class="form-group">
		                <label>Number of cases in the past 2 weeks:</label>
		                <input type="text" class="form-control" pattern="^[0-9]*$" title="Only numeric characters are allowed" name="inputbiweek" placeholder="Input Area Warning Circle Radius">
		            </div>
		        
	            <!--div class="form-group form-check">
	                <input type="checkbox" class="form-check-input" id="chckboxowneradd">
	                <label class="form-check-label" for="chckboxuseradd">User Admin</label>
	            </div-->
	            <button type="submit" name="addutil" class="adminbtn btn btn-primary">Save Changes</button>
	            </div>
	        </form>
	    </div>
	</div>
</body>
</html>