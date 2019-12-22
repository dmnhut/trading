$(document).ready(() => {
    formSelect();
    $(".btn-close").on("click", () => {
        formSelect();
    });
});

function formSelect() {
    $("#province").formSelect("destroy");
    $("#province").empty();
    $("#province").formSelect();
    $("#district").formSelect("destroy");
    $("#district").empty();
    $("#district").prop("disabled", true);
    $("#district").formSelect();
    $("#ward").formSelect("destroy");
    $("#ward").empty();
    $("#ward").prop("disabled", true);
    $("#ward").formSelect();
}

$("#province").on("change", () => {
    $(".main-loader").css("display", "");
    $("#district").empty();
    $("#district").prop("disabled", true);
    $("#district").formSelect();
    $("#ward").empty();
    $("#ward").prop("disabled", true);
    $("#ward").formSelect();
    $.ajax({
        method: "GET",
        url: "districts",
        data: {
            id: $("#province").formSelect()[0].selectedOptions[0].value
        },
        success: function(response) {
            response.forEach((element) => {
                let opt = document.createElement('option');
                opt.value = element.id;
                opt.innerHTML = element.text;
                document.querySelector("#district").appendChild(opt);
            });
            $("#district").prop("disabled", false);
            $("#district").formSelect();
            $.ajax({
                method: "GET",
                url: "wards",
                data: {
                    id: $("#district").formSelect("getSelectedValues").pop()
                },
                success: function(response) {
                    response.forEach((element) => {
                        let opt = document.createElement('option');
                        opt.value = element.id;
                        opt.innerHTML = element.text;
                        document.querySelector("#ward").appendChild(opt);
                    });
                    $("#ward").prop("disabled", false);
                    $("#ward").formSelect();
                    $(".main-loader").css("display", "none");
                }
            });
        }
    });
});

$("#district").on("change", () => {
    $(".main-loader").css("display", "");
    $("#ward").empty();
    $("#ward").prop("disabled", true);
    $("#ward").formSelect();
    $.ajax({
        method: "GET",
        url: "wards",
        data: {
            id: $("#district").formSelect()[0].selectedOptions[0].value
        },
        success: function(response) {
            response.forEach((element) => {
                let opt = document.createElement('option');
                opt.value = element.id;
                opt.innerHTML = element.text;
                document.querySelector("#ward").appendChild(opt);
            });
            $("#ward").prop("disabled", false);
            $("#ward").formSelect();
            $(".main-loader").css("display", "none");
        }
    });
});

document.querySelectorAll(".btn-add").forEach((element) => {
    element.addEventListener("click", () => {
        $(".main-loader").css("display", "");
        document.querySelector("input[name=_id]").value = element.getAttribute("data")
        $.ajax({
            method: "GET",
            url: "provinces",
            success: function(response) {
                response.forEach((element) => {
                    let opt = document.createElement('option');
                    opt.value = element.id;
                    opt.innerHTML = element.text;
                    document.querySelector("#province").appendChild(opt);
                });
                $("#province").formSelect();
                $.ajax({
                    method: "GET",
                    url: "districts",
                    data: {
                        id: $("#province").formSelect("getSelectedValues").pop()
                    },
                    success: function(response) {
                        $("#district").empty();
                        response.forEach((element) => {
                            let opt = document.createElement('option');
                            opt.value = element.id;
                            opt.innerHTML = element.text;
                            document.querySelector("#district").appendChild(opt);
                        });
                        $("#district").prop("disabled", false);
                        $("#district").formSelect();
                        $.ajax({
                            method: "GET",
                            url: "wards",
                            data: {
                                id: $("#district").formSelect("getSelectedValues").pop()
                            },
                            success: function(response) {
                                $("#ward").empty();
                                response.forEach((element) => {
                                    let opt = document.createElement('option');
                                    opt.value = element.id;
                                    opt.innerHTML = element.text;
                                    document.querySelector("#ward").appendChild(opt);
                                });
                                $("#ward").prop("disabled", false);
                                $("#ward").formSelect();
                                $(".main-loader").css("display", "none");
                            }
                        });
                    }
                });
            }
        });
        $("#modal-area").modal("open");
    });
});

document.querySelectorAll(".btn-detail").forEach((element) => {
    let id = element.getAttribute("data");
    element.addEventListener("click", () => {
        $(".main-loader").css("display", "");
        let data = {
            _token: document.querySelector("input[name=_token]").value,
            id: id
        }
        axios.post(document.querySelector("#modal-detail").getAttribute("url"), data)
            .then((response) => {
                if (response.data != 0) {
                    document.querySelector("#detail-name").innerHTML = response.data.name;
                    document.querySelector("#detail-birthdate").innerHTML = response.data.birthdate;
                    document.querySelector("#detail-email").innerHTML = response.data.email;
                    document.querySelector("#detail-identity_card").innerHTML = response.data.identity_card;
                    document.querySelector("#detail-phone").innerHTML = response.data.phone;
                    document.querySelector("#detail-gender").innerHTML = response.data.gender;
                    $(".main-loader").css("display", "none");
                    $("#modal-detail").modal("open");
                }
            })
            .catch((error) => {
                console.log(error);
            });
    });
});

document.querySelector("#btn-modal-add").addEventListener("click", () => {
    $(".main-loader").css("display", "");
    if ($("#province").formSelect("getSelectedValues") == 0 || $("#district").formSelect("getSelectedValues") == 0 || $("#ward").formSelect("getSelectedValues") == 0) {
        console.log("wait loading...");
        return false;
    }
    let data = {
        _token: document.querySelector("input[name=_token]").value,
        user: document.querySelector("input[name=_id]").value,
        province: $("#province").formSelect()[0].selectedOptions[0].value,
        district: $("#district").formSelect()[0].selectedOptions[0].value,
        ward: $("#ward").formSelect()[0].selectedOptions[0].value
    };
    axios.post(document.querySelector("#url").value, data)
        .then((response) => {
            console.log(response);
            if (response.data.error) {
                $(".btn-close").click();
            } else {
                document.querySelector("#message").innerHTML = response.data.message;
                $(".main-loader").css("display", "none");
                $("#modal-message").modal("open");
            }
        })
        .catch((error) => {
            console.log(error);
        });
});
