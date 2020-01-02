$(document).ready(() => {
  $("select").formSelect("destroy");
  $("select").formSelect();
  $("#btn-back").on("click", (event) => {
      event.preventDefault();
      window.location.href = document.querySelector("#orders-create").getAttribute("action");
  });
  $("#quantity").on("change", () => {
    // console.log();
    // if()
    // toastr["error"]();
  });
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
