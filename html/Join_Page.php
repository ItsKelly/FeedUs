<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'headFormat.php'; ?>

    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
 <link rel="stylesheet" href="../css/Join.css">
</head>
<body>
<?php require_once 'format.php'; ?>
<div class="content">

    <h2>פרטי ההזמנה</h2>
    <?php
    $con = mysqli_connect('localhost', 'root', '', 'FeedUs');
    mysqli_query($con, "SET NAMES utf8");
    if (isset($_GET['orderID'])) {
        $orderID = $_GET['orderID'];
        $_SESSION['orderID']=$_GET['orderID'];
    }
    
    $getTime = mysqli_query($con, "SELECT  time_send  FROM orders WHERE num LIKE '$orderID'");
    if ($getTime){
        while ($thisTime = mysqli_fetch_assoc($getTime)){
            $_SESSION['endTime']=$thisTime['time_send'];
        }
    }
    $orderRow = mysqli_query($con, "SELECT * FROM orders join restaurants on rest=restaurantsName WHERE num LIKE '$orderID'");
    if ($orderRow) {
        while ($thisOrder = mysqli_fetch_assoc($orderRow)) {
            echo '<ul>';
            echo '<li>כתובת - ' . $thisOrder["place"] . '</li>';
            echo '<li>מסעדה - ' . $thisOrder["rest"] . '</li>';
            echo '<li>מינימום משתתפים - ' . $thisOrder["minimum_people"] . '</li>';
            echo '<li>זמן סגירת ההזמנה - ' . substr($thisOrder["time_send"], 0, -3) . '</li>';

            echo '<li>זמן הגעת המשלוח - ' . substr($thisOrder["time_arrive"], 0, -3) . '</li><br>';
            $imgFolder=$thisOrder["DBname"];
            echo '</ul>';
        }
    }
    ?>
    <form action="Waiting_Page.php" method="post">
        <h3><label for="phone">הכנס את מספר הטלפון שלך:</label></h3>
        <input type="tel" id="phone" name="phone" placeholder="0542445822" required>

        <h3><label for="userName">הכנס שם:</label></h3>
        <input type="text" id="userName" name="userName" placeholder="ישראל ישראלי" required><br><br>

        <input type="submit" name="NewCustomer" id="NewCustomer" value="הצטרף להזמנה!">
    </form>
    <br>
</div>
    <img id="restphoto" src="../images/<?php echo $imgFolder; ?>/logo.png">
<?php
    $nowTime=  date("H:i:s");
    $endTime = $_SESSION['endTime'];
    if($nowTime>$endTime){
        header("location:timeup.php");
    }
?>
</body>
</html>

<!--pattern="[0-9]{3}[0-9]{3}[0-9]{4}"-->