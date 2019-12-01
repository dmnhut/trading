console.clear();
$('.materialboxed').materialbox();
document.querySelector("#txt").addEventListener("input", function() {
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
                if (rows[i].childNodes[cell].childNodes[0].nodeValue.toUpperCase().indexOf(this.value
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
