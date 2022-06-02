<?php

include 'server.php';
if (session_status()==PHP_SESSION_NONE)
{
    session_start();
}
if(empty($_SESSION['runiqid'])){
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
    <div class="adminheader" id="usertype">
        Welcome <div id="usertypename"><?php echo $_SESSION['username']?></div>

        <a href="logout.php" id="logoutbtn" style="background-color: red;" class="btn btn-primary">Logout</a></br>
    </div>
    <div class="head">
        SafeAlert Davao Administration Control Panel
    </div>

    <div class="main">
        <!-- Add Bills Payment Form -->
        <?php
        $uniqid = $_SESSION['runiqid'];
        $result = mysqli_query($safealertdb, "SELECT * FROM riskarea WHERE uniqid = '$uniqid'");
        while($row = mysqli_fetch_array($result)){
            $area = $row['area'];
            $risk = $row['risk'];
            $coord = $row['coordinates'];
            $radius = $row['radius'];
        }
        ?>
        <h4 class="mt-2">Update Risk Area: <a style="color: #783b48"><?php echo $area; ?></a></h4>
        <div class="adminform">
            <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
                <div class="form-group">
                    <label><b>Area Name:</b></label>
                    <input type="text" class="form-control"  name="editrarea" placeholder="Input Name of Location"
                           value="<?php echo $area; ?>" required>
                </div>

                <div class="form-group">
                    <?php
                        $crit = null;
                        $high = null;
                        $mod = null;
                        $low = null;
                        $none = null;
                        if($risk=='Low'){
                            $test='selected';
                        }
                        if($risk=='Critical') {
                            $crit='selected';
                        }
                        elseif($risk=='High') {
                            $high='selected';
                        }
                        elseif ($risk=='Moderate'){
                            $mod='selected';
                        }
                        elseif ($risk=='Low'){
                            $low='selected';
                        }
                        elseif(empty($risk)){
                            $none='selected';
                        }
                    ?>
                    <label for="risk"><b>Risk:</b></label>
                    <select class="form-control saselect" name="editrisk" id="sarisk" required>
                        <option value=""<?php echo $none; ?>>None</option>
                        <option value="Low"<?php echo $low; ?>>Low</option>
                        <option value="Moderate"<?php echo $mod; ?>>Moderate</option>
                        <option value="High"<?php echo $high; ?>>High</option>
                        <option value="Critical"<?php echo $crit; ?>>Critical</option>
                    </select>
                </div>

                <div class="form-group">
                    <?php
                    $pieces = explode(", ", $coord);
                    ?>
                    <label><b>Coordinates</b></label></br>
                    <label>Latitude (maximum of 4 decimals):</label>
                    <input type="text" pattern="^[0-9]*.[0-9]{0,4}$" class="form-control" title="You must input a
                             numeric value of up to 4 decimals" name="editrlat"
                           placeholder="Input Area Latitude Coordinate"
                           value="<?php echo $pieces[0]; ?>"
                           required>
                    <label>Longitude (maximum of 4 decimals):</label>
                    <input type="text" pattern="^[0-9]*.[0-9]{0,4}$" class="form-control" title="You must input a
                             numeric value of up to 4 decimals" name="editrlong"
                           placeholder="Input Area Longitude Coordinate"
                           value="<?php echo $pieces[1]; ?>"
                           required>

                </div>

                <div class="form-group">
                    <label><b>Radius:</b></label>
                    <input type="text" pattern="^[0-9]*$" value="<?php echo $radius; ?>" class="form-control"
                    title="Only numeric characters are allowed" name="editradius"
                    placeholder="Input Area Warning Circle Radius">
                </div>
                <input type="hidden" name="inputruniqid" value="<?php echo $uniqid; ?>"/>

                <!--div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="chckboxowneradd">
                    <label class="form-check-label" for="chckboxuseradd">User Admin</label>
                </div-->
                <button type="submit" name="editriskarea" class="adminbtn btn btn-primary">Save Changes</button>
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