console.log("THE COOKER");
console.clear();
console.log("%cHACK!", "color:black;font-family:monospace;font-size:2rem;font-weight:bold");

$(document).ready(() => {
    window.history.pushState(null, "", window.location.href);
    window.onpopstate = () => {
        window.history.pushState(null, "", window.location.href);
    };
    $("select").formSelect();
    $(".sidenav").sidenav();
    $(".modal").modal({
        opacity: "0.2",
        dismissible: false
    });
    $(".tabs").tabs();
    $(".materialboxed").materialbox();
    $(".tooltipped").tooltip();
});

const onClickCloseBtn = element => {
    let div = element.parentElement;
    div.style.opacity = "0";
    setTimeout(() => {
        div.style.display = "none";
    }, 400);
}

for (let i = 0; i < document.querySelectorAll(".closebtn").length; i++) {
    document.querySelectorAll(".closebtn")[i].addEventListener("click", () => {
        onClickCloseBtn(document.querySelectorAll(".closebtn")[i]);
    });
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
                    if (rows[i].childNodes[cell].childNodes[0].nodeValue.toUpperCase().indexOf(document.querySelector("#txt").value.toUpperCase()) > -1) {
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
    "progressBar": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "8000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}
