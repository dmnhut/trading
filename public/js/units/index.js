$(document).ready(() => {
    $("label").removeClass("active");
    $("#name").val("");
});

document.querySelector(".btn-close").addEventListener("click", () => {
    $(".modal").modal("close");
    $("label").removeClass("active");
    $("#name").val("");
});

document.querySelector(".fixed-action-btn").addEventListener("click", () => {
    $("#modal-add").modal("open");
});

document.querySelector("#btn-modal-add").addEventListener("click", () => {
    $(".main-loader").css("display", "");
    axios.post(document.querySelector("#url").value, {
        _token: document.querySelector("input[name=_token]").value,
        name: document.querySelector("#name").value.trim()
    }).then(response => {
        $(".main-loader").css("display", "none");
        if (response.data.error) {
            response.data.messages.map(val => {
                toastr["error"](val);
            });
        } else {
            document.querySelector("#message").innerHTML = response.data.messages[0];
            $("#modal-message").modal("open");
        }
    }).catch(error => {
        console.log(error);
    });
});
