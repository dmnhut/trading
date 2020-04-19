$(document).ready(() => {
    let text = JSON.parse($("input[name=_text]").val());
    $(".datepicker").datepicker({
        format: "dd/mm/yyyy",
        changeMonth: true,
        changeYear: true,
        i18n: {
            cancel: text['cancel'],
            clear: text['clear'],
            done: text['done'],
            months: text['months'],
            monthsShort: text['monthsShort'],
            weekdays: text['weekdays'],
            weekdaysShort: text['weekdaysShort'],
            weekdaysAbbrev: text['weekdaysAbbrev']
        }
    });
    document.querySelector(".datepicker-calendar-container").classList.add(...["grey", "darken-3", "white-text"]);
});

document.querySelector("#btn-add").addEventListener("click", event => {
    event.preventDefault();
    document.querySelector(".main-loader").style.display = "";
    let data = new FormData(document.querySelector("#users-create"));
    $.ajax({
        method: "POST",
        enctype: "multipart/form-data",
        url: document.querySelector("#users-create").action,
        contentType: false,
        processData: false,
        data: data,
        success: response => {
            document.querySelector(".main-loader").style.display = "none";
            if (response.error) {
                response.messages.map(val => {
                    toastr.error(val);
                });
            } else {
                document.querySelector("#message").innerHTML = response.messages[0];
                $("#modal-message").modal("open");
            }
        }
    });
});

onFocusOutInputNumber(["#identity_card", "#phone"]);
