console.clear();
console.log(
    "%cHACK! THE COOKER :]",
    "color:black;font-family:monospace;font-size:4rem;font-weight:bold"
);
$(document).ready(() => {
    $(".sidenav").sidenav();
    $(".modal").modal();
    $(".materialboxed").materialbox();
    $("select").formSelect();
    $(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        changeMonth: true,
        changeYear: true,
        i18n: {
            cancel: `Hủy`,
            clear: `Xóa`,
            done: `Thêm`,
            months: [
                `Tháng 1`,
                `Tháng 2`,
                `Tháng 3`,
                `Tháng 4`,
                `Tháng 5`,
                `Tháng 6`,
                `Tháng 7`,
                `Tháng 8`,
                `Tháng 9`,
                `Tháng 10`,
                `Tháng 11`,
                `Tháng 12`
            ],
            monthsShort: [
                `Tháng 1, Ngày `,
                `Tháng 2, Ngày `,
                `Tháng 3, Ngày `,
                `Tháng 4, Ngày `,
                `Tháng 5, Ngày `,
                `Tháng 6, Ngày `,
                `Tháng 7, Ngày `,
                `Tháng 8, Ngày `,
                `Tháng 9, Ngày `,
                `Tháng 10, Ngày `,
                `Tháng 11, Ngày `,
                `Tháng 12, Ngày `
            ],
            weekdays: [
                `Chủ nhật`,
                `Thứ 2`,
                `Thứ 3`,
                `Thứ 4`,
                `Thứ 5`,
                `Thứ 6`,
                `Thứ 7`
            ],
            weekdaysShort: [
                `Chủ nhật`,
                `Thứ 2`,
                `Thứ 3`,
                `Thứ 4`,
                `Thứ 5`,
                `Thứ 6`,
                `Thứ 7`
            ],
            weekdaysAbbrev: [`CN`, `T2`, `T3`, `T4`, `T5`, `T6`, `T7`]
        }
    });
});

let close = document.getElementsByClassName("closebtn");
for (let i = 0; i < close.length; i++) {
    close[i].onclick = function() {
        let div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(() => {
            div.style.display = "none";
        }, 600);
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
