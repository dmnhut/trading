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

$(".datepicker").datepicker("setDate", new Date(document.querySelector("#birthdate").value.split("/")[2], document.querySelector("#birthdate").value.split("/")[1] - 1, document.querySelector("#birthdate").value.split("/")[0], "00", "00", "00"));
document.querySelector("#btn-edit").addEventListener("click", event => {
    event.preventDefault();
    $(".main-loader").css("display", "");
    let data = new FormData(document.querySelector("#users-edit"));
    $.ajax({
        method: "POST",
        enctype: "multipart/form-data",
        url: document.querySelector("#users-edit").action,
        contentType: false,
        processData: false,
        data: data,
        success: response => {
            $(".main-loader").css("display", "none");
            if (response.error) {
                response.messages.map(val => {
                    toastr["error"](val);
                });
            } else {
                document.querySelector("#message").innerHTML = response.messages[0];
                $("#modal-message").modal("open");
            }
        }
    });
});
