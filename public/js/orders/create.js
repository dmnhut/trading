$(document).ready(() => {
    clear();
    printCode();
    $("#btn-back").on("click", event => {
        event.preventDefault();
        window.location.href = document
            .querySelector("#orders-create")
            .getAttribute("action");
    });
    $("#btn-clear").on("click", event => {
        event.preventDefault();
        clear();
        axios.post(document.querySelector("input[name=_url_code]").value, {
            _token: document.querySelector("input[name=_token]").value
        }).then(response => {
            document.querySelector("#code").value = response.data.code;
            printCode();
        }).catch(error => {
            console.log(error);
        });
    });
});

const printCode = () => {
    JsBarcode("#barcode", document.querySelector("#code").value, {
        width: 1,
        height: 80,
        displayValue: true
    });
    document.getElementById("qrcode").innerHTML = "";
    let qrcode = new QRCode(document.getElementById("qrcode"), {
        width: 128,
        height: 128,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
    qrcode.clear();
    qrcode.makeCode(document.querySelector("#code").value);
}

const clear = () => {
    $("#quantity").parent().children().last().removeClass("active");
    $("select").formSelect("destroy");
    $("#kg").val(0);
    $("#province").val(0);
    $("#district").prop("disabled", true);
    $("#ward").prop("disabled", true);
    $("#district").empty();
    $("#ward").empty();
    $("#district").append(new Option("---", 0));
    $("#ward").append(new Option("---", 0));
    $("#district").val(0);
    $("#ward").val(0);
    $("select").formSelect();
    document.querySelector("#total-amount").value = 0;
    document.querySelector("#address").value = "";
    document.querySelector("#item").value = "";
    document.querySelector("#quantity").value = "";
    $("#items").html("");
    $("#items").parents("table").css("display", "none");
    $(".alert").css("display", "none");
    $(".section.error").css("display", "none");
    $(".message.items").css("display", "none");
    $(".message.form").css("display", "none");
};

const removeRow = node => {
    event.preventDefault();
    node.parents("tr").remove();
    if ($("#items").children().length === 0) {
        $("#items").parents("table").css("display", "none");
    }
};

const removeMessage = node => {
    let div = node.parent();
    setTimeout(() => {
        div.css("display", "none");
        $(".section.error").css("display", "none");
    }, 400);
    $(".message.items").css("display", "none");
    $(".message.form").css("display", "none");
};
$("#btn-add-item").on("click", event => {
    event.preventDefault();
    let messages = [];
    let {
        item,
        unit,
        quantity,
        re,
        error
    } = JSON.parse($("input[name=_messages]").val());
    if (document.querySelector("#item").value.length == 0) {
        messages.push(item);
    }
    if ($("#unit").formSelect("getSelectedValues").length == 0) {
        messages.push(unit);
    }
    if (document.querySelector("#quantity").value.length == 0) {
        messages.push(quantity);
    } else {
        if (Array.isArray(document.querySelector("#quantity").value.match(new RegExp(re)))) {
            messages.push(error);
        }
    }
    if (messages.length != 0) {
        $(".message.items").css("display", "");
        $(".message.form").css("display", "none");
        $(".alert").html("<span class='closebtn' type='items' onclick='removeMessage($(this))'>&times;</span>");
        messages.map(val => {
            $(".alert").append(val + "<br>");
        });
        $(".alert").css("display", "");
        $(".section.error").css("display", "");
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

const getDataItems = () => {
    let result = [];
    let arr = Array.from(document.querySelector("#items").children);
    if (arr.length == 0) {
        return result;
    }
    Array.from(document.querySelector("#items").children).forEach(el => {
        let dataTable = {
            item_name: el.children[0].getAttribute("data"),
            id_unit: el.children[1].getAttribute("data"),
            quantity: el.children[2].getAttribute("data")
        };
        result.push(dataTable);
    });
    return result;
};
$("#kg").on("change", () => {
    document.querySelector("#total-amount").value = $("#kg").formSelect()[0].selectedOptions[0].value.split("-")[1] + " VND";
    document.querySelector("#total-amount").setAttribute("data", $("#kg").formSelect()[0].selectedOptions[0].value.split("-")[0]);
});
$("#province").on("change", () => {
    $(".main-loader").css("display", "");
    $("#district").empty();
    $("#district").prop("disabled", true);
    $("#district").formSelect();
    $("#ward").empty();
    $("#ward").prop("disabled", true);
    $("#ward").formSelect();
    axios.get(document.querySelector("input[name=_url_districts]").value, {
        params: {
            id: $("#province").formSelect()[0].selectedOptions[0].value
        }
    }).then(response => {
        response.data.forEach(element => {
            let opt = document.createElement("option");
            opt.value = element.id;
            opt.innerHTML = element.text;
            document.querySelector("#district").appendChild(opt);
        });
        $("#district").prop("disabled", false);
        $("#district").formSelect();
        axios.get(document.querySelector("input[name=_url_wards]").value, {
            params: {
                id: $("#district").formSelect("getSelectedValues").pop()
            }
        }).then(response => {
            response.data.forEach(element => {
                let opt = document.createElement("option");
                opt.value = element.id;
                opt.innerHTML = element.text;
                document.querySelector("#ward").appendChild(opt);
            });
            $("#ward").prop("disabled", false);
            $("#ward").formSelect();
        }).catch(error => {
            console.log(error);
        }).finally(() => {
            $(".main-loader").css("display", "none");
        });
    }).catch(error => {
        console.log(error);
    })
});
$("#district").on("change", () => {
    $(".main-loader").css("display", "");
    $("#ward").empty();
    $("#ward").prop("disabled", true);
    $("#ward").formSelect();
    axios.get(document.querySelector("input[name=_url_wards]").value, {
        params: {
            id: $("#district").formSelect()[0].selectedOptions[0].value
        }
    }).then(response => {
        response.data.forEach(element => {
            let opt = document.createElement("option");
            opt.value = element.id;
            opt.innerHTML = element.text;
            document.querySelector("#ward").appendChild(opt);
        });
        $("#ward").prop("disabled", false);
        $("#ward").formSelect();
    }).catch(error => {
        console.log(error);
    }).finally(() => {
        $(".main-loader").css("display", "none");
    });
});
document.querySelector("#btn-add").addEventListener("click", event => {
    event.preventDefault();
    let messages = [];
    let {
        items,
        province,
        district,
        ward,
        address,
        kg
    } = JSON.parse($("input[name=_messages]").val());
    let listItems = getDataItems();
    if (listItems.length == 0) {
        messages.push(items);
    }
    if ($("#province").formSelect("getSelectedValues")[0] == 0) {
        messages.push(province);
    }
    if ($("#district").formSelect("getSelectedValues")[0] == 0) {
        messages.push(district);
    }
    if ($("#ward").formSelect("getSelectedValues")[0] == 0) {
        messages.push(ward);
    }
    if (document.querySelector("#address").value == "") {
        messages.push(address);
    }
    if ($("#kg").formSelect("getSelectedValues")[0] == 0) {
        messages.push(kg);
    }
    if (messages.length != 0) {
        $(".message.form").css("display", "");
        $(".message.items").css("display", "none");
        $(".alert").html("<span class='closebtn' type='form' onclick='removeMessage($(this))'>&times;</span>");
        messages.map(val => {
            $(".alert").append(val + "<br>");
        });
        $(".alert").css("display", "");
        $(".section.error").css("display", "");
        return;
    }
    let params = {};
    params._token = document.querySelector("input[name=_token]").value;
    params.code = document.querySelector("#code").value;
    params.items = JSON.stringify(listItems);
    params.user = $("#user").formSelect()[0].selectedOptions[0].value;
    params.province = $("#province").formSelect()[0].selectedOptions[0].value;
    params.district = $("#district").formSelect()[0].selectedOptions[0].value;
    params.ward = $("#ward").formSelect()[0].selectedOptions[0].value;
    params.address = document.querySelector("#address").value;
    params.kg = $("#kg").formSelect()[0].selectedOptions[0].value.split("-")[0];
    params.total_amount = document.querySelector("#total-amount").value.split(" ")[0];
    $(".main-loader").css("display", "");
    axios.post(document.querySelector("#orders-create").getAttribute("action"), params).then(response => {
        if (response.data.error == true) {
            axios.post(document.querySelector("input[name=_url_code]").value, {
                _token: document.querySelector("input[name=_token]").value
            }).then(response => {
                document.querySelector("#code").value = response.data.code;
                printCode();
            }).catch(error => {
                console.log(error);
            });
            $(".message.form").css("display", "");
            $(".message.items").css("display", "none");
            $(".alert").html("<span class='closebtn' type='form' onclick='removeMessage($(this))'>&times;</span>");
            $(".alert").append(response.data.message);
            $(".alert").css("display", "");
            $(".section.error").css("display", "");
            $(".main-loader").css("display", "none");
        } else {
            document.querySelector("#message").innerHTML = response.data.message;
            $(".main-loader").css("display", "none");
            $(".alert").css("display", "none");
            $(".section.error").css("display", "none");
            $(".message.form").css("display", "none");
            $(".message.items").css("display", "none");
            $(".main-loader").css("display", "none");
            $("#modal-message").modal("open");
        }
    }).catch(error => {
        console.log(error);
    });
});
