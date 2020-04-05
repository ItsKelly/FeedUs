<?php
session_start();
?>
<!DOCTYPE html>
<head>
    <?php require_once 'headFormat.php'; ?>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>FeedUs</title>
    <link rel="stylesheet" href="../css/menu.css"/>
</head>
<body>
<?php require_once 'format.php'; ?>
<?php
$conFeedUs = mysqli_connect("localhost", "root", "", "FeedUs");
mysqli_query($conFeedUs, "SET NAMES utf8");

if (isset($_SESSION['phone'])) {
    $phone = $_SESSION['phone'];
}
if (isset($_SESSION['orderID'])) {
    $orderID = $_SESSION['orderID'];
} else {
    $max = mysqli_query($conFeedUs, "select max(num) from orders");
    if ($max) {
        while ($re1 = mysqli_fetch_assoc($max)) {
            $orderID = $re1['max(num)'];
        }
    }
}
$orderRow = mysqli_query($conFeedUs, "SELECT * FROM orders join restaurants on rest=restaurantsName WHERE num = '$orderID'");
if ($orderRow) {
    while ($thisOrder = mysqli_fetch_assoc($orderRow)) {
        $rest = $thisOrder["DBname"];
    }
}
$conRestaurant = mysqli_connect("localhost", "root", "", $rest);
mysqli_query($conRestaurant, "SET NAMES utf8");


if (isset($_POST['deleteOrderdItem'])) {
    $id = $_POST['deleteID'];
    $dataDelete = 'DELETE FROM Cart WHERE CItemID =' . $id;
    mysqli_query($conFeedUs, $dataDelete);
}
if (isset($_POST['addOrderdItem'])) {
    $dataAdd = 'insert into Cart(CItemName,CUserPhone,COrderNum) values ("' . $_POST['addName'] . '","' . $phone . '","' . $orderID . '")';
    mysqli_query($conFeedUs, $dataAdd);
}
if (isset($_POST['addItem'])) {

    $dataAdd = 'insert into Cart(CItemName,CItemComment,CUserPhone,COrderNum) values ("' . $_POST['addName'] . '","' . $_POST['itemComment'] . '","' . $phone . '","' . $orderID . '")';
    mysqli_query($conFeedUs, $dataAdd);
}
?>

<div id="menuContainer">


    <!-----------------------צד ימין ----------------------->
    <div id="rightSideBar">
        <div id="foodCategoriesHeadline">קטגוריות אוכל</div>
        <div id="foodCategoriesContainer">
            <?php
            $dataSet1 = mysqli_query($conRestaurant, 'SELECT * FROM categories ');
            if ($dataSet1) {
                while ($record1 = mysqli_fetch_assoc($dataSet1)) {
                    echo '<a class="foodCategory" href="#' . $record1["CategoryName"] . '">' . $record1["CategoryName"] . '</a>';
                }
            }
            ?>
        </div>
    </div>

    <!-----------------------אמצע ----------------------->

    <div id="foodMenuContainer">
        <?php
        $dataRest = mysqli_query($conFeedUs, "SELECT * FROM restaurants WHERE DBname = '$rest'");
        if ($dataRest) {
            $restName = mysqli_fetch_assoc($dataRest);
            echo '<div id="foodMenuHeadline">' . $restName["restaurantsName"] . ' - תפריט משלוחים</div>';
        }
        ?>
        <div id="foodMenu">
            <?php
            $dataSet1 = mysqli_query($conRestaurant, 'SELECT * FROM Categories ');
            if ($dataSet1) {
                while ($record1 = mysqli_fetch_assoc($dataSet1)) {
                    echo '<div id="' . $record1['CategoryName'] . '" class="menuCategory">';
                    echo '<div class="menuCategoryHeadline">' . $record1['CategoryName'] . '</div>';
                    if ($record1['CategoryComment']) echo '<div class="menuCategoryComment">' . $record1['CategoryComment'] . '</div>';
                    echo '<div class="menuCategoryItems">';
                    $dataSet2 = mysqli_query($conRestaurant, "SELECT * FROM items WHERE ItemCategory = '$record1[CategoryName]'");
                    if ($dataSet2) {
                        while ($record2 = mysqli_fetch_assoc($dataSet2)) {
                            echo '<button class="menuItem" onclick="openModel(`' . $record2["ItemName"] . '`,`' . $record2["ItemComment"] . '`,`' . $record2["ItemCost"] . '`,`' . $rest . '`,`' . $record2["ItemIngredient"] . '`)">';
                            echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
                            echo '<input type="hidden" name="addName" value="' . $record2["ItemName"] . '">';
                            echo '<div class="menuItemName">' . $record2['ItemName'] . '</div>';
                            echo '<div class="menuItemPrice">' . $record2['ItemCost'] . '₪</div>';
                            echo '</button>';
                            echo '<button type="submit" name="addOrderdItem" class="buttonAddItem"> <img src="../images/Plus.png"></button>';
                            echo '</form>';
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>

    <!-----------------------מודל מוצר ----------------------->
    <div id="myModal" class="menuItemModel">

        <div class="flip-card">
            <div class="flip-card-inner">
                <div class="flip-card-front">
                    <img id="menuItemModelImage2" src="../images/greenplus.png"></img>
                </div>
                <div class="flip-card-back">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                        <div id="menuItemModelHeadlineContainer">
                            <div id="menuItemModelHeadline">שם מוצר</div>
                            <input type="hidden" id="menuItemModelID" name="addName" value="מוצר 1">
                            <div id="menuItemModelClose" onclick="closeModel()">&times;</div>
                        </div>
                        <div id="menuItemModelSubContainer">הערה</div>
                        <div id="menuItemModelImageContainer">
                            <div id="menuItemModelImageContent">רכיבים</div>
                            <img id="menuItemModelImage" src="תמונה"></img>
                        </div>
                        <div id="menuItemModelCommentContainer">
                            <label for="itemComment"><b>הערה למנה (לא חובה):</b></label>
                            <input type="text" placeholder="הכנס הערה" id="itemComment" name="itemComment">
                        </div>
                        <div id="menuItemModelSummeryContainer">
                            <div id="SummeryAmount">מחיר</div>
                            <button id="addItem" type="submit" name="addItem">הוסף</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-----------------------צד שמאל ----------------------->

    <div id="leftSideBar">
        <div id="shoppingCartHeadline">עגלת קניות</div>
        <div id="shoppingCart">
            <?php
            $CostSummery = 0;
            $dataSet3 = mysqli_query($conFeedUs, 'SELECT * FROM feedUs.Cart join ' . $rest . '.items on CItemName=ItemName where CUserPhone = "' . $phone . '" and COrderNum = "' . $orderID . '" order by CItemID DESC');
            if ($dataSet3) {
                while ($record3 = mysqli_fetch_assoc($dataSet3)) {

                    echo '<div class="orderdItem" >';
                    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
                    echo '<div class="orderdItemName">' . $record3['CItemName'] . '</div >';
                    echo '<input type="hidden" name="deleteID" value="' . $record3["CItemID"] . '">';
                    echo '<button type="submit" name="deleteOrderdItem" class="orderdItemCancel">&times;</button >';
                    echo '<div class="orderdItemPrice" >' . $record3['ItemCost'] . ' ₪ </div >';
                    echo '<div class="orderdItemComment" >' . $record3['CItemComment'] . '</div >';
                    echo '</form>';
                    echo '</div >';
                    $CostSummery = $CostSummery + $record3['ItemCost'];
                }
            }
            $dataCost = 'update members set pay="' . $CostSummery . '" where phone = "' . $phone . '" and num = "' . $orderID . '" ';
            mysqli_query($conFeedUs, $dataCost);
            ?>
        </div>
        <div id="costSummeryContainer">
            <div id="cost">סה"כ:</div>
            <?php echo '<div id="costSummery">' . $CostSummery . ' ₪</div>'; ?>
        </div>
        <button id="orderButton" onclick="order()">המשך</button>
    </div>
</div>
<?php mysqli_close($conFeedUs); ?>
<?php mysqli_close($conRestaurant); ?>
<?php
$nowTime = date("H:i:s");
$endTime = $_SESSION['endTime'];
if ($nowTime > $endTime) {
    header("location:timeup.php");
}
?>
</body>
</html>
<script src="../js/menu.js"></script>
