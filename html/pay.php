<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'headFormat.php'; ?>
    <link rel="stylesheet" href="../css/pay.css">
</head>
<body>
<?php
$con = mysqli_connect('localhost', 'root', '', 'FeedUs');
mysqli_query($con, "SET NAMES utf8");
If (isset($_POST['submitScore'])) {
    If (isset($_POST['userScore'])) {
        $score = $_POST['userScore'];
    }
    else{
        $score = 0;
    }
    $phone = $_SESSION['phone'];
    $orderID = $_SESSION['orderID'];

    $UpdateScore = 'update members set score="' . $score . '" where phone = "' . $phone . '" and num = "' . $orderID . '" ';
    mysqli_query($con, $UpdateScore);
}
?>
<?php require_once 'format.php'; ?>
<button id="p2" class="payButton" onclick="pay2()">לתשלום</button>
<?php
$nowTime = date("H:i:s");
$endTime = $_SESSION['endTime'];
if ($nowTime > $endTime) {
    header("location:timeup.php");
}
?>
</body>
</html>
<script src="../js/pay.js"></script>