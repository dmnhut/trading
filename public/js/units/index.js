$(document).ready(() => {
    $("label").removeClass("active");
    $("#name").val("");
});

document.querySelector(".btn-close").addEventListener("click", () => {
    $(".modal").modal("close");
    $('label').removeClass("active");
    $("#name").val("");
});

document.querySelector(".fixed-action-btn").addEventListener("click", () => {
    $("#modal-add").modal("open");
});

document.querySelector("#btn-modal-add").addEventListener("click", () => {
    $(".main-loader").css("display", "");
    $.ajax({
        method: "POST",
        url: document.querySelector("#url").value,
        data: {
            _token: document.querySelector("input[name=_token]").value,
            name: document.querySelector("#name").value.trim()
        },
        success: function(response) {
            $(".main-loader").css("display", "none");
            if (response.error) {
                response.messages.map((val) => {
                    toastr["error"](val);
                });
            } else {
                document.querySelector("#message").innerHTML = response.messages[0];
                $("#modal-message").modal("open");
            }
        }
    });
});
