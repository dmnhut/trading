console.clear();
console.log(
    "%cHACK! THE COOKER :]",
    "color:black;font-family:monospace;font-size:4rem;font-weight:bold"
);

$(document).ready(() => {
    $(".sidenav").sidenav();
    $(".modal").modal({
        "opacity": "0.2"
    });
    $(".materialboxed").materialbox();
    $("select").formSelect();
});

let close = document.getElementsByClassName("closebtn");
for (let i = 0; i < close.length; i++) {
    close[i].onclick = function() {
        let div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(() => {
            div.style.display = "none";
        }, 400);
    }
}

let searchBox = document.querySelector("#txt");
if (searchBox != null) {
    searchBox.addEventListener("input", () => {
        let count = 0;
        let rows = document.getElementsByTagName("table")[0].rows;
        for (let i = 1; i < rows.length; i++) {
            for (let cell = 0; cell < rows[i].childNodes.length; cell++) {
                if (rows[i].childNodes[cell].firstChild != null) {
                    if (rows[i].childNodes[cell].firstChild.className === "material-placeholder") {
                        continue;
                    }
                }
                if (rows[i].childNodes[cell].childNodes.length !== 0) {
                    if (rows[i].childNodes[cell].childNodes[0].nodeValue.toUpperCase().indexOf(document.querySelector("#txt").value
                            .toUpperCase()) > -1) {
                        rows[i].style.display = "";
                        count++;
                        break;
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        }
        if (count === 0) {
            rows[0].style.display = "none";
        } else {
            rows[0].style.display = "";
        }
    });
}

toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
