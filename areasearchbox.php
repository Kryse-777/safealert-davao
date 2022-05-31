<!--Area Search Form-->
<div class="adminform">
    <form method="post" action="<?php echo ($_SERVER['PHP_SELF']);?>">
        <div class="form-group">
            <label>Address:</label>
            <input type="text" class="form-control" name="inputaccadd" placeholder="Input address of property">
        </div>
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

        <div class="form-group radio-form areasrcbtn">
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
        <button type="submit" name="srcharea" class="adminbtn btn btn-primary">Save Changes</button>
    </form>
</div><br/><br/>