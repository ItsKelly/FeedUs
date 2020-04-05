<!DOCTYPE html>
<head>
    <?php require_once 'headFormat.php';?>
    <link rel="stylesheet" href="../css/index.css"/>
</head>
<body>
<?php require_once 'format.php';?>
<div id="main">
    <p id="title">תהנו מהאוכל שלכם בעזרת FeedUs</p>
    <p id="subtitle">מחברים אנשים מאז 2020</p>
    <div id="buttonContainer"><a id="GetStartedButton" href="openning2.php">בואו ונתחיל במסע</a></div>
    <p id="catchfrase">"השלם גדול מסך כל חלקיו"</p>
    <p id="catchouther">אריסטו, תורת הסינרגיה</p>
    <form action="mail.php" method="post">
        <input type="submit" name="mail" id="mail" value="שלח מייל למסעדה">
    </form>
</div>
</body>
</html>