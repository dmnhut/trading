$(document).ready(() => {
    $("select").formSelect("destroy");
    $("#kg").val(0);
    $("select").formSelect();
    document.querySelector("#total-amount").value = 0;
    $("#btn-back").on("click", (event) => {
        event.preventDefault();
        window.location.href = document.querySelector("#orders-create").getAttribute("action");
    });
});

function removeRow(node) {
    event.preventDefault();
    node.parents("tr").remove();
    if ($("#items").children().length === 0) {
        $("#items").parents("table").css("display", "none");
    }
};
$("#btn-add-item").on("click", (event) => {
    event.preventDefault();
    let messages = [];
    if (document.querySelector("#item").value.length == 0) {
        messages.push(JSON.parse($("input[name=_messages]").val()).item);
    }
    if ($("#unit").formSelect("getSelectedValues").length == 0) {
        messages.push(JSON.parse($("input[name=_messages]").val()).unit);
    }
    if (document.querySelector("#quantity").value.length == 0) {
        messages.push(JSON.parse($("input[name=_messages]").val()).quantity);
    } else {
        if (Array.isArray(document.querySelector("#quantity").value.match(new RegExp(JSON.parse($("input[name=_validator]").val()).re)))) {
            messages.push(JSON.parse($("input[name=_validator]").val()).error);
        }
    }
    if (messages.length != 0) {
        messages.map((val) => {
            toastr["error"](val);
        });
        return;
    }
    let row = document.createElement("tr");
    row.appendChild(document.createElement("td"));
    row.appendChild(document.createElement("td"));
    row.appendChild(document.createElement("td"));
    row.appendChild(document.createElement("td"));
    row.childNodes[0].appendChild(document.createTextNode(document.querySelector("#item").value));
    row.childNodes[0].setAttribute("data", document.querySelector("#item").value);
    row.childNodes[1].appendChild(document.createTextNode($("#unit>option:selected").html()));
    row.childNodes[1].setAttribute("data", $("#unit").formSelect("getSelectedValues")[0]);
    row.childNodes[2].appendChild(document.createTextNode(document.querySelector("#quantity").value));
    row.childNodes[2].setAttribute("data", document.querySelector("#quantity").value);
    row.childNodes[3].innerHTML = "<button class='waves-effect waves-light btn red' onclick='removeRow($(this))'><i class='small material-icons'>close</i></button>";
    document.querySelector("#items").appendChild(row);
    $("#items").parents().css("display", "");
});
$("#kg").on("change", () => {
    document.querySelector("#total-amount").value = $("#kg").formSelect()[0].selectedOptions[0].value.split('-')[1] + " VND";
    document.querySelector("#total-amount").setAttribute("data", $("#kg").formSelect()[0].selectedOptions[0].value.split('-')[0]);
});
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
        url: document.querySelector("input[name=_url_districts]").value,
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
                url: document.querySelector("input[name=_url_wards]").value,
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
        url: document.querySelector("input[name=_url_wards]").value,
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
JsBarcode("#barcode",
    document.querySelector("#code").value, {
        width: 1,
        height: 80,
        displayValue: true
    });
new QRCode(document.getElementById("qrcode"), {
    text: document.querySelector("#code").value,
    width: 128,
    height: 128,
    colorDark: "#000000",
    colorLight: "#ffffff",
    correctLevel: QRCode.CorrectLevel.H
});
