<?php
session_start();
?>
<!DOCTYPE html>
<head>
    <?php require_once 'headFormat.php'; ?>
    <meta name="viewport"
          content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0,target-densitydpi=device-dpi, user-scalable=no"/>
    <link rel="stylesheet" href="../css/conclusion.css">

</head>
<body>
<?php require_once 'format.php'; ?>

<?php
$con = mysqli_connect('localhost', 'root', '', 'FeedUs');
mysqli_query($con, "SET NAMES utf8");
$orderID = $_SESSION['orderID'];
$phone = $_SESSION['phone'];


$memberRow = mysqli_query($con, "SELECT * FROM members  WHERE num = $orderID  order by score asc limit 1");
if ($memberRow) {
    while ($thisMember = mysqli_fetch_assoc($memberRow)) {
        $luckyMember = $thisMember["name"];
        echo '<div class="incharge">מזל טוב ' . $luckyMember . ' ! אתה אחראי על ההזמנה, התפקידים שלך הם:</div>';
    }
}
?>
<ol id="orderInfo">
    <?php
    $totalPayment = 0;
    $payRow = mysqli_query($con, "SELECT * FROM members WHERE num = $orderID");
    if ($payRow) {
        while ($thisPay = mysqli_fetch_assoc($payRow)) {
            $totalPayment = $totalPayment + $thisPay["pay"];
        }
    }
    $orderRow = mysqli_query($con, "SELECT * FROM orders join restaurants on rest=restaurantsName WHERE num = $orderID");

    if ($orderRow) {
        while ($thisOrder = mysqli_fetch_assoc($orderRow)) {
            echo '<li>להתקשר ל' . $thisOrder["rest"] . ' לטלפון: ' . $thisOrder["restPhone"] . '</li>';
            echo '<li>לשלם ' . $totalPayment . ' ₪</li>';
            echo '<li>לאסוף את ההזמנה מ' . $thisOrder["place"] . '';
            if ($thisOrder["time_arrive"]) {
                echo ' בשעה ' . $thisOrder["time_arrive"] . '';
            }
            echo '</li>';
            echo '<li>לדבר עם המסעדה במידה ויש שינויים</li>';
        }
    }
    ?>
</ol>


<div id="myModal" class="menuItemModel">
    <div id="menuItemModelContent">
        <div id="menuItemModelHeadlineContainer">
            <div id="menuItemModelHeadline">סיכום הזמנה</div>
            <div id="menuItemModelClose" onclick="closeModel()">&times;</div>
        </div>
        <div id="menuItemModelCustomerContainer">
            <?php
            $memberRow = mysqli_query($con, "SELECT * FROM members WHERE num = $orderID");
            if ($memberRow) {
                while ($thisMember = mysqli_fetch_assoc($memberRow)) {
                    echo '<div class="menuItemModelCustomerInfo">';
                    echo '<div class="menuItemModelCustomerName">' . $thisMember["name"] . ' - טלפון: ' . $thisMember["phone"] . '</div>';
                    $mPhone = $thisMember["phone"];
                    echo '<div class="menuItemModelCustomerCartContainer">';
                    $cartRow = mysqli_query($con, "SELECT * FROM cart WHERE 	COrderNum = $orderID and CUserPhone=$mPhone");
                    if ($cartRow) {
                        while ($thisMemberCart = mysqli_fetch_assoc($cartRow)) {
                            echo '<div class="menuItemModelCustomerCart">' . $thisMemberCart["CItemName"];
                            if ($thisMemberCart["CItemComment"]) {
                                echo ' - ' . $thisMemberCart["CItemComment"];
                            }
                            echo '</div>';
                        }
                    }
                    echo '</div>';
                    echo '<div class="menuItemModelCustomerPay">סהכ - ' . $thisMember["pay"] . '₪</div>';
                    echo '</div>';
                }
            }
            echo '<br>';
            echo '<div class="menuItemModelCustomerTotalPay">סהכ בהזמנה - ' . $totalPayment . '₪</div>';
            ?>
        </div>
    </div>
</div>

<form action="excel.php" method="post">
    <input type="hidden" name="totalPayment" value="<?php echo $totalPayment; ?>">
    <input type="submit" name="exportExcel" id="exportExcel" value="הורד קובץ הזמנה">
</form>

<form action="mail.php" method="post">
    <input type="submit" name="mail" id="mail" value="שלח מייל למסעדה">
</form>

<button id="viewOrder" onclick="openModel()"><h1>סיכום ההזמנה</h1></button>

</body>
</html>
<script src="../js/conclusion.js"></script>