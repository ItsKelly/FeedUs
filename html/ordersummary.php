<?php
session_start();
?>
<!DOCTYPE html>
<head>
    <?php require_once 'headFormat.php'; ?>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,target-densitydpi=device-dpi, user-scalable=no" />
    <link rel="stylesheet" href="../css/conclusion.css">
    <link rel="stylesheet" href="../css/ordersummary.css">

</head>
<body>
<?php require_once 'format.php'; ?>
<div class="summary"> <h1>זה הכל!</h1>

    <div class="order">ההזמנה שלך:</div>
    <ol>
        <?php
        $con = mysqli_connect('localhost', 'root', '', 'FeedUs');
        mysqli_query($con, "SET NAMES utf8");
        $orderID = $_SESSION['orderID'];
        $phone = $_SESSION['phone'];
        $CartRow = mysqli_query($con, "SELECT * FROM cart WHERE COrderNum = $orderID and CUserPhone = $phone");
        if ($CartRow) {
            while ($thisMember = mysqli_fetch_assoc($CartRow)) {
                echo '<li>'.$thisMember["CItemName"];
                if($thisMember["CItemComment"]){
                    echo ' - '.$thisMember["CItemComment"];
                }
                echo'</li>';

            }
        }


        ?>
    </ol>
   <div id="end">יש טעות? לא נורא! בקרוב יוחלט על אחראי ותקבל את מספר הטלפון שלו בהודעת SMS</div>
    <div class="thank">תודה שהזמנת FeedUs !</div>
    <a id="p1" class="payButton" href="conclusion.php">אחראי הזמנה</a>
</div>
</body>
</html>
