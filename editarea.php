<?php

    include 'server.php';
    if (session_status()==PHP_SESSION_NONE)
    {
        session_start();
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
    <div id="title" style="background-color: white;">
        <span style="color: #00C8FF;">Safe</span><span style="color: red;">Alert</span>
        <span style="color: black;"> Davao</span>
    </div>

    <div class="main">
        <!-- Add Bills Payment Form -->
        <h4 class="mt-2">Edit Area Form</h4>
        <div class ="editform">
            <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
                <div class="form-group">
                <?php
                    $ownid = $_SESSION['ownid'];
                    echo "<b>Owner ID: </b>" . $ownid . "</br>";
                    $result = mysqli_query($safealertdb, "SELECT * FROM riskarea WHERE id = '$ownid'");
                    while($row = mysqli_fetch_array($result)){
                        $ownername = $row['area'];
                        $address = $row['type'];
                        $contact = $row['risk'];
                    }
                    echo "<b>Edit Area Name: </b>" . $area;
                ?>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" name="ownid" value="<?php echo $ownid; ?>">
                    <label>Type:</label>
                    <input type="text" class="form-control"  name="inputname" value="<?php echo $ownername; ?>" placeholder=""required>
                </div>

                <div class="form-group">
                    <label>Risk:</label>
                    <input type="text" class="form-control" name="inputadd" value="<?php echo $address; ?>">
                </div>
                <!--div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="chckboxowneradd">
                    <label class="form-check-label" for="chckboxuseradd">User Admin</label>
                </div-->
                <button type="submit" name="editown" class="btn btn-primary">Update Area</button>
                </br></br><a href="admin.php" id="returnbtn" class="btn btn-primary">Return</a>
            </form>
            <?php
                
            ?>
        </div>
    </div>
</body>
</html>