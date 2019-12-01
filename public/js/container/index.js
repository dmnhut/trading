console.clear();
$('.sidenav').sidenav();
let close = document.getElementsByClassName("closebtn");
let i;

for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
        let div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(function() {
            div.style.display = "none";
        }, 600);
    }
}
