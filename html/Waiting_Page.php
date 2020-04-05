<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'headFormat.php'; ?>
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,target-densitydpi=device-dpi, user-scalable=no"/>
    <link rel="stylesheet" href="../css/Waiting.css">
</head>
<?php
$phone = "";
If (isset($_POST['NewCustomer'])) {
    $con = mysqli_connect('localhost', 'root', '', 'FeedUs');
    mysqli_query($con, "SET NAMES utf8");
    $phone = $_POST['phone'];
    $userName = $_POST['userName'];
    $_SESSION['phone'] = $_POST['phone'];
    $id = $_SESSION['orderID'];
    $signtime = date("Y-m-d H:i:s");
    $query = "insert into members (num,phone,name,stime) values ('$id','$phone','$userName','$signtime')";
    mysqli_query($con, $query);
}
$time = "";
$q2 = "select * from orders where (num='$id')";
$sq2 = mysqli_query($con, $q2);
if ($sq2) {
    while ($rec2 = mysqli_fetch_assoc($sq2)) {
        $time = date_create($rec2['start_time']);
        $min = $rec2['time_start'];
        $minimum = $rec2['minimum_people'];
    }

}
$ntime = date_create(date("Y-m-d h:i:sa"));
//date_modify($time, "+1 days");
date_modify($time, "+$min minutes");
$time2 = $time;
$time2 = $time2->format('F j, Y H:i:s');
?>
<script>
    // Set the date we're counting down to
    var countDownDate = new Date("<?php echo $time2;?>").getTime();

    // Update the count down every 1 second
    var x = setInterval(function ()
    {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="demo"

        if (hours) {
            document.getElementById("clock").innerHTML = hours + " שעות " + minutes + " דקות " + seconds + " שניות ";
        } else if (minutes) {
            document.getElementById("clock").innerHTML = minutes + " דקות " + seconds + " שניות ";
        } else {
            document.getElementById("clock").innerHTML = seconds + " שניות ";
        }

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("clock").innerHTML = "נגמר הזמן";
        }
    }, 1000);
</script>


<body>
<?php require_once 'format.php'; ?>
<h1>ההזמנה בתהליך</h1>


<div class="CountDownClock">
    <div id="clock"></div>
</div>
<div class="JoinedAmount">

    <?php echo "$minimum"; ?>
    /
    <?php

    $countq = "select count(*) from members where ((num='$id'))";
    $count = mysqli_query($con, $countq);
    if ($count) {
        while ($rec = mysqli_fetch_assoc($count)) {
            $signed = $rec['count(*)'];
            echo "$signed";
        }
    }
    ?>
</div>
<?php
if ($signed >= $minimum) {
    header("location:menu.php");
} elseif ($ntime > $time) {
    header("location:failed.php");
}
//and((CONVERT (date ,stime))<'$time')
?>
<?php
$nowTime = date("H:i:s");
$endTime = $_SESSION['endTime'];
if ($nowTime > $endTime) {
    header("location:timeup.php");
}
?>
<div class="loading-dots">
    <div class="bounce"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
</div>
</body>
</html>
