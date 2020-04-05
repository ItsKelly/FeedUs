<!DOCTYPE html>
<html>
<head>
    <?php require_once 'headFormat.php'; ?>
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>
    <link rel="stylesheet" href="../css/Game.css">

</head>
<body>
<?php require_once 'Format.php'; ?>
<h1 id="htitle">חורץ הגורלות</h1>
<div id="forGame"></div>
<div class="game">
    <button class="gamebuttons" id="startbut" onclick="startGame(); showMore();">שחק</button>
    <button class="gamebuttons" id="gamebut" onmousedown="accelerate(-1)" onmouseup="accelerate(0.2)">קפוץ!</button>

    <form class="score" method="post" action="pay.php">
        <input type="hidden" id="userscore" name="userScore" value="0">
        <input type="submit" id="submitscore" name="submitScore">
    </form>
</div>
</body>
</html>
<script src="../JS/Game.js"></script>
