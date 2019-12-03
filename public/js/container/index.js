console.clear();
console.log(
    "%cHACK! THE COOKER :]",
    "color:black;font-family:monospace;font-size:5rem;font-weight:bold"
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
            cancel: "Hủy",
            clear: "Xóa",
            done: "Thêm",
            months: [
                "Tháng 1",
                "Tháng 2",
                "Tháng 3",
                "Tháng 4",
                "Tháng 5",
                "Tháng 6",
                "Tháng 7",
                "Tháng 8",
                "Tháng 9",
                "Tháng 10",
                "Tháng 11",
                "Tháng 12"
            ],
            monthsShort: [
                "Tháng 1, Ngày ",
                "Tháng 2, Ngày ",
                "Tháng 3, Ngày ",
                "Tháng 4, Ngày ",
                "Tháng 5, Ngày ",
                "Tháng 6, Ngày ",
                "Tháng 7, Ngày ",
                "Tháng 8, Ngày ",
                "Tháng 9, Ngày ",
                "Tháng 10, Ngày ",
                "Tháng 11, Ngày ",
                "Tháng 12, Ngày "
            ],
            weekdays: [
                "Chủ nhật",
                "Thứ 2",
                "Thứ 3",
                "Thứ 4",
                "Thứ 5",
                "Thứ 6",
                "Thứ 7"
            ],
            weekdaysShort: [
                "Chủ nhật",
                "Thứ 2",
                "Thứ 3",
                "Thứ 4",
                "Thứ 5",
                "Thứ 6",
                "Thứ 7"
            ],
            weekdaysAbbrev: ["CN", "T2", "T3", "T4", "T5", "T6", "T7"]
        }
    });
});

let close = document.getElementsByClassName("closebtn");
let i;
for (i = 0; i < close.length; i++) {
    close[i].onclick = () => {
        let div = this.parentElement;
        div.style.opacity = "0";
        setTimeout(() => {
            div.style.display = "none";
        }, 600);
    }
}
