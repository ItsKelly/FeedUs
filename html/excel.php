<?php
session_start();
$con = mysqli_connect('localhost', 'root', '', 'FeedUs');
mysqli_query($con, "SET NAMES utf8");
$orderID = $_SESSION['orderID'];
$orderRow = mysqli_query($con, "SELECT * FROM orders join restaurants on rest=restaurantsName WHERE num = '$orderID'");
if ($orderRow) {
    while ($thisOrder = mysqli_fetch_assoc($orderRow)) {
        $rest = $thisOrder["DBname"];
    }
}
$conRestaurant = mysqli_connect("localhost", "root", "", $rest);
mysqli_query($conRestaurant, "SET NAMES utf8");

$output = '';
If (isset($_POST['exportExcel'])) {
    $cartRow = mysqli_query($con, 'SELECT * FROM feedUs.Cart join ' . $rest . '.items on CItemName=ItemName where COrderNum = "' . $orderID . '" order by CItemID DESC');
    if ($cartRow) {
        $output .= '
        <table class="table" bordered="1">
            <tr>
                <th>מוצר</th>
                <th>הערה</th>
                <th>מחיר</th>
            </tr>
        ';
        while ($thisMemberCart = mysqli_fetch_assoc($cartRow)) {
            $output .= '
            <tr>
                <td>' . $thisMemberCart["CItemName"] . '</td>
                <td>' . $thisMemberCart["CItemComment"] . '</td>
                <td>' . $thisMemberCart["ItemCost"] . '₪</td>
            </tr>
        ';
        }

        $output .= '
        <tr>
                <th>סה"כ</th>
                <th>'.$_POST["totalPayment"].'₪</th>
            </tr>
        </table>
        ';
        header('Content-Encoding: UTF-8');
        header("Content-Type: application/xls;charset=UTF-8");
        header("Content-Disposition:attachment; filename=order" . $orderID . ".xls");
        print chr(255) . chr(254) . mb_convert_encoding($output, 'UTF-16LE', 'UTF-8');
    }
}
?>