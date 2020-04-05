var modal = document.getElementById("myModal");

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function openModel(VarName,VarSub,VarPrice,VarRest,VarIngredient) {
    modal.style.display = "block";
    document.getElementById("menuItemModelHeadline").innerHTML=VarName;
    document.getElementById("menuItemModelID").value=VarName;
    document.getElementById("menuItemModelSubContainer").innerHTML=VarSub;
    document.getElementById("menuItemModelImageContent").innerHTML=VarIngredient;
    document.getElementById("SummeryAmount").innerHTML="מחיר מנה: "+VarPrice+" ₪";
    document.getElementById("menuItemModelImage").src="../images/"+VarRest+"/"+VarName+".png";
    document.getElementById("menuItemModelImage2").src="../images/"+VarRest+"/"+VarName+".png";
}

function closeModel() {
    modal.style.display = "none";
}
function order() {
    location.href="game.php";
}