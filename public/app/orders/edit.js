$(document).ready(() => {
    clear();
    printCode();
    $(".tabs").tabs();
    document.querySelector("#btn-back").addEventListener("click", event => {
        event.preventDefault();
        window.location.href = document.querySelector("#orders-edit").getAttribute("action").slice(0, -2);
    });
    document.querySelector("#btn-reload").addEventListener("click", event => {
        event.preventDefault();
        location.href = location.toLocaleString();
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
    $("select").formSelect();
    document.querySelector("#item").value = "";
    document.querySelector("#quantity").value = "";
    document.querySelector(".alert").style.display = "none";
    document.querySelector(".section.error").style.display = "none";
    document.querySelector(".message.items").style.display = "none";
    document.querySelector(".message.form").style.display = "none";
};

const removeRow = node => {
    event.preventDefault();
    node.parents("tr").remove();
    if ($("#items").children().length === 0) {
        $("#items").parents("table").css("display", "none");
    }
};

const removeMessage = node => {
    setTimeout(() => {
        node.parent().css("display", "none");
        document.querySelector(".section.error").style.display = "none";
    }, 400);
    document.querySelector(".message.items").style.display = "none";
    document.querySelector(".message.form").style.display = "none";
};

document.querySelector("#btn-add-item").addEventListener("click", event => {
    event.preventDefault();
    let messages = [];
    let {
        item,
        unit,
        quantity
    } = JSON.parse($("input[name=_messages]").val());
    let validate = JSON.parse($("input[name=_validator]").val());
    if (document.querySelector("#item").value.length == 0) {
        messages.push(item);
    }
    if ($("#unit").formSelect("getSelectedValues").length == 0) {
        messages.push(unit);
    }
    if (document.querySelector("#quantity").value.length == 0) {
        messages.push(quantity);
    } else {
        if (Array.isArray(document.querySelector("#quantity").value.match(new RegExp(validate.quantity.re)))) {
            messages.push(validate.quantity.error);
        }
    }
    if (messages.length != 0) {
        document.querySelector(".message.items").style.display = "";
        document.querySelector(".message.form").style.display = "none";
        $(".alert").html("<span class='closebtn' type='items' onclick='removeMessage($(this))'>&times;</span>");
        messages.map(val => {
            $(".alert").append(val + "<br>");
        });
        document.querySelector(".alert").style.display = "";
        document.querySelector(".section.error").style.display = "";
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
    row.childNodes[1].setAttribute("data", $("#unit").formSelect()[0].selectedOptions[0].value);
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

document.querySelector("#kg").addEventListener("change", () => {
    document.querySelector("#total-amount").value = $("#kg").formSelect()[0].selectedOptions[0].value.split("-")[1] + " VND";
    document.querySelector("#total-amount").setAttribute("data", $("#kg").formSelect()[0].selectedOptions[0].value.split("-")[0]);
});

document.querySelector("#province").addEventListener("change", () => {
    document.querySelector(".main-loader").style.display = "";
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
            document.querySelector("#address").value = [
                $("#" + $("#province").parent().children()[1].id + ">li.selected").text(),
                $("#" + $("#district").parent().children()[1].id + ">li.selected").text(),
                $("#" + $("#ward").parent().children()[1].id + ">li.selected").text()
            ].join(', ');
            document.querySelector("label[for=address]").classList.add("active");
        }).catch(error => {
            console.log(error);
        }).finally(() => {
            document.querySelector(".main-loader").style.display = "none";
        });
    }).catch(error => {
        console.log(error);
    })
});

document.querySelector("#district").addEventListener("change", () => {
    document.querySelector(".main-loader").style.display = "";
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
        document.querySelector("#address").value = [
            $("#" + $("#province").parent().children()[1].id + ">li.selected").text(),
            $("#" + $("#district").parent().children()[1].id + ">li.selected").text(),
            $("#" + $("#ward").parent().children()[1].id + ">li.selected").text()
        ].join(', ');
        document.querySelector("label[for=address]").classList.add("active");
    }).catch(error => {
        console.log(error);
    }).finally(() => {
        document.querySelector(".main-loader").style.display = "none";
    });
});

document.querySelector("#ward").addEventListener("change", () => {
    document.querySelector("#address").value = [
        $("#" + $("#province").parent().children()[1].id + ">li.selected").text(),
        $("#" + $("#district").parent().children()[1].id + ">li.selected").text(),
        $("#" + $("#ward").parent().children()[1].id + ">li.selected").text()
    ].join(', ');
    document.querySelector("label[for=address]").classList.add("active");
});

document.querySelector("#btn-edit").addEventListener("click", event => {
    event.preventDefault();
    let messages = [];
    let {
        items,
        province,
        district,
        ward,
        address,
        receiver,
        phone,
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
    if (document.querySelector("#receiver").value == "") {
        messages.push(receiver);
    }
    if (document.querySelector("#phone").value == "") {
        messages.push(phone);
    }
    if ($("#kg").formSelect("getSelectedValues")[0] == 0) {
        messages.push(kg);
    }
    if (messages.length != 0) {
        document.querySelector(".message.form").style.display = "";
        document.querySelector(".message.items").style.display = "none";
        $(".alert").html("<span class='closebtn' type='form' onclick='removeMessage($(this))'>&times;</span>");
        messages.map(val => {
            $(".alert").append(val + "<br>");
        });
        document.querySelector(".alert").style.display = "";
        document.querySelector(".section.error").style.display = "";
        return;
    }
    let params = {};
    params._token = document.querySelector("input[name=_token]").value;
    params._method = document.querySelector("input[name=_method]").value;
    params.code = document.querySelector("#code").value;
    params.items = JSON.stringify(listItems);
    params.user = $("#user").formSelect()[0].selectedOptions[0].value;
    params.province = $("#province").formSelect()[0].selectedOptions[0].value;
    params.district = $("#district").formSelect()[0].selectedOptions[0].value;
    params.ward = $("#ward").formSelect()[0].selectedOptions[0].value;
    params.address = document.querySelector("#address").value;
    params.receiver = document.querySelector("#receiver").value;
    params.phone = document.querySelector("#phone").value;
    params.kg = $("#kg").formSelect()[0].selectedOptions[0].value.split("-")[0];
    params.total_amount = document.querySelector("#total-amount").value.split(" ")[0];
    document.querySelector(".main-loader").style.display = "";
    axios.put(document.querySelector("#orders-edit").getAttribute("action"), params).then(response => {
        if (response.data.error == true) {
            document.querySelector(".message.form").style.display = "";
            document.querySelector(".message.items").style.display = "none";
            $(".alert").html("<span class='closebtn' type='form' onclick='removeMessage($(this))'>&times;</span>");
            $(".alert").append(response.data.message);
            document.querySelector(".alert").style.display = "";
            document.querySelector(".section.error").style.display = "";
            document.querySelector(".main-loader").style.display = "none";
        } else {
            document.querySelector("#message").innerHTML = response.data.message;
            document.querySelector(".main-loader").style.display = "none";
            document.querySelector(".alert").style.display = "none";
            document.querySelector(".section.error").style.display = "none";
            document.querySelector(".message.form").style.display = "none";
            document.querySelector(".message.items").style.display = "none";
            document.querySelector(".main-loader").style.display = "none";
            $("#modal-message").modal("open");
        }
    }).catch(error => {
        console.log(error);
    });
});
