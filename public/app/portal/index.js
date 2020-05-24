$(document).ready(() => {
    document.querySelector("#" + document.querySelector("input[name=_tab_active").value + ">div>table").classList.add("activated");
    document.querySelector("#" + document.querySelector("input[name=_tab_active").value + ">div>table").style.display = "";
});

const removeMessage = node => {
    setTimeout(() => {
        node.parent().css("display", "none");
        document.querySelector(".section.error").style.display = "none";
    }, 400);
    document.querySelector(".message").style.display = "none";
};

document.querySelectorAll(".btn-assign").forEach(element => {
    element.addEventListener("click", () => {
        event.preventDefault();
        document.querySelector(".message").style.display = "none";
        document.querySelector(".section.error").style.display = "none";
        document.querySelector("#modal-assign>div>h5>div>.code").innerHTML = element.getAttribute("code");
        document.querySelector("#tbl-shippers").innerHTML = "";
        document.querySelector(".main-loader").style.display = "";
        axios.get(document.querySelector("input[name=_url_shippers]").value).then(response => {
            if (response.data.error) {
                document.querySelector(".message").style.display = "";
                $(".alert").html("<span class='closebtn' onclick='removeMessage($(this))'>&times;</span>");
                $(".alert").append(response.data.message + "<br>");
                document.querySelector(".alert").style.display = "";
                document.querySelector(".section.error").style.display = "";
            } else {
                let html = "";
                response.data.data.forEach(val => {
                    html += "<tr>";
                    html += "<td data-label='" + document.querySelector("#th-shippers-name").textContent + "'>" + val.name + "</td>";
                    html += "<td data-label='" + document.querySelector("#th-shippers-email").textContent + "'>" + val.email + "</td>";
                    html += "<td data-label='" + document.querySelector("#th-shippers-phone").textContent + "'>" + val.phone + "</td>";
                    html += "<td data-label='" + document.querySelector("#th-shippers-province").textContent + "'>" + val.province + "</td>";
                    html += "<td data-label='" + document.querySelector("#th-shippers-district").textContent + "'>" + val.district + "</td>";
                    html += "<td data-label='" + document.querySelector("#th-shippers-ward").textContent + "'>" + val.ward + "</td>";
                    html += "<td data-label='" + document.querySelector("#th-shippers-assign").textContent + "'>";
                    html += "<button class='waves-effect waves-light btn btn-small green darken-3 tooltipped btn-modal-assign' data-position='top' data-tooltip='Chọn' data-order='" + element.getAttribute("data") + "' data-shipper='" + val.id_shipper + "'>";
                    html += "<i class='material-icons'>done</i>";
                    html += "</button>";
                    html += "</td>";
                    html += "</tr>";
                });
                document.querySelector("#tbl-shippers").innerHTML = html;
                document.querySelectorAll(".btn-modal-assign").forEach(element => {
                    element.addEventListener("click", () => {
                        document.querySelector(".main-loader").style.display = "";
                        event.preventDefault();
                        let params = {};
                        params._token = document.querySelector("input[name=_token]").value;
                        params.order = element.getAttribute("data-order");
                        params.shipper = element.getAttribute("data-shipper");
                        axios.post(document.querySelector("input[name=_url_assign]").value, params).then(response => {
                            if (response.data.error) {
                                let modal = document.querySelector("#modal-assign>div");
                                let message = modal.querySelector(".message");
                                message.style.display = "";
                                let sectionError = message.querySelector(".section.error");
                                sectionError.style.display = "";
                                let alert = sectionError.querySelector(".alert");
                                alert.style.display = "";
                                alert.innerHTML = "<span class='closebtn' onclick='removeMessage($(this))'>&times;</span>";
                                alert.append(response.data.message);
                                document.querySelector(".main-loader").style.display = "none";
                            } else {
                                document.querySelector("#message").innerHTML = response.data.message;
                                document.querySelector(".main-loader").style.display = "none";
                                $("#modal-message").modal("open");
                            }
                        }).catch(error => {
                            console.log(error);
                        });
                    });
                });
            }
            document.querySelector(".main-loader").style.display = "none";
            $("#modal-assign").modal("open");
        }).catch(error => {
            console.log(error);
        }).then(() => {});
    });
});

document.querySelectorAll(".tabs>li").forEach(element => {
    element.addEventListener("click", () => {
        event.preventDefault();
        let tab = element.querySelector("a").getAttribute("href").match(/[a-z]+\-[a-z]+/).pop();
        let page = "";
        if (document.querySelector(".pagination>li.active>a") !== NULL) {
            let page = Number(document.querySelector(".pagination>li.active>a").innerText);
        }
        location.href = document.querySelector("input[name=_url]").value + "?page=" + page + "&tab=" + tab;
    });
});

document.querySelectorAll(".btn-change-status").forEach(element => {
    element.addEventListener("click", () => {
        event.preventDefault();
        document.querySelector("#modal-shipping").style["max-height"] = "100%";
        document.querySelector("#modal-shipping>div>h5>div>.code").innerHTML = element.getAttribute("code");
        document.querySelectorAll("input[name=status]").forEach(radio => {
            if (document.querySelector("input[name=_radio_assign]").value == radio.value) {
                radio.disabled = true;
            } else {
                radio.disabled = false;
            }
        });
        let radio = document.querySelector("input[name=status][value='" + element.getAttribute("status") + "']");
        radio.checked = true;
        radio.setAttribute("disabled", "disabled");
        document.querySelector("input[name=_order]").value = element.getAttribute("data");
        let modal = document.querySelector("#modal-shipping>div");
        let message = modal.querySelector(".message");
        message.style.display = "none";
        let sectionError = message.querySelector(".section.error");
        sectionError.style.display = "none";
        let alert = sectionError.querySelector(".alert");
        alert.style.display = "none";
        $("#modal-shipping").modal("open");
    });
});

document.querySelector(".btn-modal-shipping").addEventListener("click", () => {
    event.preventDefault();
    if (document.querySelector("input[name=_order]").value === "") {
        return;
    }
    let params = {};
    params._token = document.querySelector("input[name=_token]").value;
    params.id = document.querySelector("input[name=_order]").value;
    params.status = document.querySelector("input[name=status]:checked").value;
    document.querySelector(".main-loader").style.display = "";
    axios.post(document.querySelector("input[name=_url_status]").value, params).then(response => {
        if (response.data.error) {
            let modal = document.querySelector("#modal-shipping>div");
            let message = modal.querySelector(".message");
            message.style.display = "";
            let sectionError = message.querySelector(".section.error");
            sectionError.style.display = "";
            let alert = sectionError.querySelector(".alert");
            alert.style.display = "";
            alert.innerHTML = "<span class='closebtn' onclick='removeMessage($(this))'>&times;</span>";
            alert.append(response.data.message);
            document.querySelector(".main-loader").style.display = "none";
        } else {
            let tab = document.querySelector(".tabs>li>a.active").getAttribute("href").match(/[a-z]+\-[a-z]+/).pop();
            let page = "";
            if (document.querySelector(".pagination>li.active>a") !== NULL) {
                let page = Number(document.querySelector(".pagination>li.active>a").innerText);
            }
            document.querySelector("#message").innerHTML = response.data.message;
            document.querySelector(".main-loader").style.display = "none";
            document.querySelector("input[name=tab]").value = tab;
            document.querySelector("input[name=page]").value = page;
            $("#modal-message").modal("open");
        }
    }).catch(error => {
        console.log(error);
    });
});

document.querySelectorAll(".btn-transfers").forEach(element => {
    element.addEventListener("click", () => {
        event.preventDefault();
        let params = {};
        params._token = document.querySelector("input[name=_token]").value;
        params.id = element.getAttribute("data");
        document.querySelector(".main-loader").style.display = "";
        axios.post(document.querySelector("input[name=_url_transfers]").value, params).then(response => {
            if (response.data.error) {
                let tab = document.querySelector("#tab-transfers");
                let message = tab.querySelector(".message");
                message.style.display = "";
                let sectionError = message.querySelector(".section.error");
                sectionError.style.display = "";
                let alert = sectionError.querySelector(".alert");
                alert.style.display = "";
                alert.innerHTML = "<span class='closebtn' onclick='removeMessage($(this))'>&times;</span>";
                alert.append(response.data.message);
                document.querySelector(".main-loader").style.display = "none";
            } else {
                let tab = document.querySelector(".tabs>li>a.active").getAttribute("href").match(/[a-z]+\-[a-z]+/).pop();
                let page = "";
                if (document.querySelector(".pagination>li.active>a") !== NULL) {
                    let page = Number(document.querySelector(".pagination>li.active>a").innerText);
                }
                document.querySelector("#message").innerHTML = response.data.message;
                document.querySelector(".main-loader").style.display = "none";
                document.querySelector("input[name=tab]").value = tab;
                document.querySelector("input[name=page]").value = page;
                $("#modal-message").modal("open");
            }
        }).catch(error => {
            console.log(error);
        });
    });
});

document.querySelectorAll(".btn-shipping").forEach(element => {
    element.addEventListener("click", () => {
        let params = {};
        params._token = document.querySelector("input[name=_token]").value;
        params.id = element.getAttribute("data");
        document.querySelector(".main-loader").style.display = "";
        axios.post(document.querySelector("input[name=_url_status]").value, params).then(response => {
            if (response.data.error) {
                let tab = document.querySelector("#tab-transfers");
                let message = tab.querySelector(".message");
                message.style.display = "";
                let sectionError = message.querySelector(".section.error");
                sectionError.style.display = "";
                let alert = sectionError.querySelector(".alert");
                alert.style.display = "";
                alert.innerHTML = "<span class='closebtn' onclick='removeMessage($(this))'>&times;</span>";
                alert.append(response.data.message);
                document.querySelector(".main-loader").style.display = "none";
            } else {
                let tab = document.querySelector(".tabs>li>a.active").getAttribute("href").match(/[a-z]+\-[a-z]+/).pop();
                let page = "";
                if (document.querySelector(".pagination>li.active>a") !== NULL) {
                    let page = Number(document.querySelector(".pagination>li.active>a").innerText);
                }
                document.querySelector("#message").innerHTML = response.data.message;
                document.querySelector(".main-loader").style.display = "none";
                document.querySelector("input[name=tab]").value = tab;
                document.querySelector("input[name=page]").value = page;
                $("#modal-message").modal("open");
            }
        }).catch(error => {
            console.log(error);
        });
    });
});

document.querySelectorAll(".btn-map").forEach(element => {
    element.addEventListener("click", () => {
        axios.post(document.querySelector("input[name=_url_map_check]").value, {
            _token: document.querySelector("input[name=_token]").value,
            btn: "map",
            id: element.getAttribute("data")
        }).then(response => {
            if (response.data.error) {
                toastr.error(response.data.message);
            } else {
                document.querySelector("input[name=order]").value = element.getAttribute("data");
                document.querySelector("form[name=frm-map]").action = document.querySelector("input[name=_url_map]").value;
                document.querySelector("#btn-map-submit").click();
            }
        }).catch(error => {
            console.log(error);
        });
    });
});

document.querySelectorAll(".btn-location").forEach(element => {
    element.addEventListener("click", () => {
        axios.post(document.querySelector("input[name=_url_map_check]").value, {
            _token: document.querySelector("input[name=_token]").value,
            btn: "location",
            id: element.getAttribute("data")
        }).then(response => {
            if (response.data.error) {
                toastr.error(response.data.message);
            } else {
                document.querySelector("input[name=order]").value = element.getAttribute("data");
                document.querySelector("form[name=frm-map]").action = document.querySelector("input[name=_url_map_location]").value;
                document.querySelector("#btn-map-submit").click();
            }
        }).catch(error => {
            console.log(error);
        });
    });
});
