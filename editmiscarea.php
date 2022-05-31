<?php

    include 'server.php';
    if (session_status()==PHP_SESSION_NONE)
    {
        session_start();
    }
    if(empty($_SESSION['muniqid'])){
        header('location:admin.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SafeAlert Davao</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">

    <!-- JavaScript -->
    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="head" id="title" style="background-color: white;">
        SafeAlert Davao Administration Control Panel
    </div>

    <div class="main">
        <!-- Add Bills Payment Form -->
        <?php
            $uniqid = $_SESSION['muniqid'];
            $result = mysqli_query($safealertdb, "SELECT * FROM miscarea WHERE uniqid = '$uniqid'");
            while($row = mysqli_fetch_array($result)){
                $area = $row['area'];
                $type = $row['type'];
                $coord = $row['coordinates'];
            }
        ?>
        <h4 class="mt-2">Update Miscellaneous/Medical Area: <?php echo $area; ?></h4>
        <div class="adminform">
            <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
                <div class="form-group">
                    <label><b>Area Name:</b></label>
                    <input type="text" class="form-control"  name="editmarea" placeholder="Input Name of Location"
                    value="<?php echo $area; ?>" required>
                </div>

                <div class="form-group">
                    <?php
                        $test = null;
                        $vacc = null;
                        $empty = null;
                        if($type=='Test'){
                            $test='selected';
                        }
                        elseif($type=='Vaccine'){
                            $vacc='selected';
                        }
                        elseif(empty($type)){
                            $empty='selected';
                        }
                    ?>

                    <label for="risk"><b>Type:</b></label>
                    <select class="form-control saselect" name="editmtype" id="sarisk" required>
                        <option value="" <?php echo $empty; ?>>None</option>
                        <option value="Test" <?php echo $test; ?>>COVID-19 Testing Facility</option>
                        <option value="Vaccine" <?php echo $vacc; ?>>COVID-19 Vaccination Facility</option>
                    </select>
                    <br>
                </div>

                <div class="form-group">
                    <?php
                        $pieces = explode(", ", $coord);
                    ?>
                    <label><b>Coordinates</b></label><br/>
                    <label>Latitude (maximum of 4 decimals):</label>
                    <input type="text" pattern="^[0-9]*.[0-9]{0,4}$" class="form-control" title="You must input a
		                 numeric value of up to 4 decimals" name="editmlat"
                           placeholder="Input Area Latitude Coordinate"
                           value="<?php echo $pieces[0]; ?>"
                           required>
                    <label>Longitude (maximum of 4 decimals):</label>
                    <input type="text" pattern="^[0-9]*.[0-9]{0,4}$" class="form-control" title="You must input a
		                 numeric value of up to 4 decimals" name="editmlong"
                           placeholder="Input Area Longitude Coordinate"
                           value="<?php echo $pieces[1]; ?>"
                           required>

                </div>
                <input type="hidden" name="inputmuniqid" value="<?php echo $uniqid; ?>"/>

                <!--div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="chckboxowneradd">
                    <label class="form-check-label" for="chckboxuseradd">User Admin</label>
                </div-->
                <button type="submit" name="editmiscarea" class="adminbtn btn btn-primary">Save Changes</button>
                <br/><a href="admin.php" class="btn btn-primary" style="background-color:red; color: white" id="returnbtn">
                Return</a>
            </form>
        </div>
    </div>
        <?php

        ?>
    </div>
    </div>
</body>
</html>