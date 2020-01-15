$(document).ready(() => {
    $("label").removeClass("active");
    $("#kg").val("");
    $("#amount").val("");
});

document.querySelector("#btn-cancel").addEventListener("click", () => {
    $(".modal").modal("close");
    $("label").removeClass("active");
    $("#kg").val("");
    $("#amount").val("");
});

$("#btn-add").on("click", () => {
    $(".main-loader").css("display", "");
    axios.post(location, {
        "_token": document.querySelector("input[name=_token]").value,
        "kg": document.querySelector("#kg").value,
        "amount": document.querySelector("#amount").value
    }).then(response => {
        $("#kg").val("");
        $("#amount").val("");
        $("#tbl").html("");
        $("label").removeClass("active");
        let tbody = "";
        response.data.data.map(val => {
            tbody += "<tr>";
            tbody += "<td>" + val.kg + "</td>";
            tbody += "<td>" + val.amount + "</td>";
            tbody += "<td>";
            tbody += "<form method='POST' action='" + location + "/status'>";
            tbody += "<input type='hidden' name='_token' value='" + document.querySelector("input[name='_token']").value + "'>";
            tbody += "<input type='hidden' name='id' value='" + val.id + "'></input>";
            if (val.turn_on == 0) {
                tbody += "<button class='waves-effect waves-light btn btn-small pink lighten-1'>bật</button>";
            } else {
                tbody += "<button class='waves-effect waves-light btn btn-small green accent-3 lighten-1'>tắt</button>";
            }
            tbody += "</form>";
            tbody += "</td>";
            tbody += "<td>";
            tbody += "<form method='POST' action='" + val.url + "'>";
            tbody += "<input type='hidden' name='_method' value='DELETE'>";
            tbody += "<input type='hidden' name='_token' value='" + document.querySelector("input[name='_token']").value + "'>";
            tbody += "<button class='waves-effect waves-light btn btn-small red darken-2 lighten-1'>xóa</button>";
            tbody += "</form>";
            tbody += "</td>";
            tbody += "</tr>";
        });
        $(".modal").modal("close");
        $("#tbl").html(tbody);
        $(".main-loader").css("display", "none");
        toastr.success(response.data.message);
    }).catch(error => {
        console.log(error);
    });
});
