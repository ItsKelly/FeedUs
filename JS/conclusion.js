var modal = document.getElementById("myModal");

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function openModel() {
    modal.style.display = "block";
}

function closeModel() {
    modal.style.display = "none";
}