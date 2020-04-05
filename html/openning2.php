<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'headFormat.php'; ?>
    <link rel="stylesheet" href="../css/openinng2.css">
</head>
<body>
<?php require_once 'format.php'; ?>
<?php
$con = mysqli_connect('localhost', 'root', '', 'FeedUs');
mysqli_query($con, "SET NAMES utf8");
?>

<div class="main">
    <div id="headline">פתיחת הזמנה</div>
    <form id="openForm" method="post" action="Link_Page.php">
        <div class="inputContainer">
            <label for="rest">מסעדה</label>
            <select id="rest" name="rest">
                <?php
                $dataSet1 = mysqli_query($con, 'SELECT * FROM restaurants ');
                if ($dataSet1) {
                    echo '<option value="" disabled selected>בחר מסעדה:</option>';
                    while ($record1 = mysqli_fetch_assoc($dataSet1)) {
                        echo '<option value="' . $record1["restaurantsName"] . '">' . $record1["restaurantsName"] . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="inputContainer">
            <label for="place">כתובת משלוח</label>
            <input type="text" name="place" placeholder="הכנס כתובת" required/>
        </div>
        <div class="inputContainer">
            <label for="minnum">כמות מינימאלית לפתיחת הזמנה</label>
            <input type="number" name="minnum" placeholder="הכנס כמות" required/>
        </div>
        <div class="inputContainer">
            <label for="opentime">זמן לפתיחת הזמנה</label>
            <input type="number" id="opentime" name="opentime" placeholder="הכנס זמן (בדקות)" required>
        </div>
        <div class="inputContainer">
            <label for="sendtime">זמן לשליחת הזמנה</label>
            <input type="text" onfocus="(this.type='time')"  id="sendtime" name="sendtime" placeholder="הכנס זמן" required/>
        </div>
        <div class="inputContainer">
            <label for="arriveltime">זמן הגעה רצוי (אופציונאלי)</label>
            <input type="text" onfocus="(this.type='time')"  id="arriveltime" name="arriveltime" placeholder="הכנס זמן"/>
        </div>
        <div class="inputContainer">
            <label for="paybox">קישור לפייבוקס</label>
            <input type="text" name="paybox" placeholder="הכנס קישור" required/>
        </div>
        <input type="submit" name="SubmitOpenOrder" id="SubmitOpenOrder" value="פתח הזמנה"/>

    </form>
</div>
<?php mysqli_close($con); ?>
</body>
</html>