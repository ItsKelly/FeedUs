<?php
session_start();
date_default_timezone_set('Asia/Jerusalem');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'headFormat.php';?>
    <link rel="stylesheet" href="../css/link_page.css"/>
</head>
<body>
<?php require_once 'format.php';?>
<?php
$con = mysqli_connect('localhost', 'root', '', 'FeedUs');
mysqli_query($con, "SET NAMES utf8");
    If (isset($_POST['SubmitOpenOrder']))
    {
        $rest= $_POST['rest'];
        $rest=str_replace("'","''",$rest);
        $place=$_POST['place'];
        $minnum= $_POST['minnum'];
        $opentime=$_POST['opentime'];
        $sendtime= $_POST['sendtime'];
        $arriveltime=$_POST['arriveltime'];
        $paybox= $_POST['paybox'];
        $time =  date("Y-m-d H:i:s");
        $query="insert into orders(rest,place,minimum_people,time_start,time_send,time_arrive,link,start_time) values('".$rest."','".$place."','$minnum','$opentime','$sendtime','$arriveltime','$paybox','$time')";
        mysqli_query($con,$query);
    }
?>
<div class="headtitle">
    <h1 class="htitle"><strong>הזמנה נפתחה בהצלחה!</strong></h1>
</div>
<div class="main">
        <form action="/action_page.php">
            <label for="Olink" id="linktitle"><strong>קישור להזמנה:</strong></label><br>
            <input type="text" id="Olink" name="Olink" class="linkbox" value="http://localhost/FeedUs/html/join_page.php<?php
                $maxquery= "select max(num) from orders";
                $max= mysqli_query($con,$maxquery);
                if ($max){
                    while ($re1 = mysqli_fetch_assoc($max)) {
                        echo"?orderID=".$re1['max(num)'];
                    }
                } ?>" ><br><br>
        </form>
    <button id="copylink" class="subutton" onclick="copyFunction()"></button>
    <a href="whatsapp://send?text=http://localhost/FeedUs/html/join_page.php" data-action="share/whatsapp/share" class="subutton" id="whatsapp">
        <img src="../images/icons8-whatsapp-48.png" alt="link through whatsapp" height="48" width="48"/>
    </a>
   </div>
<script src="Link_Page.js"></script>
</body>
</html>
