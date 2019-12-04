document.querySelector("#btn-cancel").addEventListener("click", () => {
    $(".modal").modal();
    document.querySelector("#kg").value = "";
    document.querySelector("#amount").value = "";
});
document.querySelector("#btn-add").addEventListener("click", () => {
    axios.post("{{route('prices.store')}}", {
            _token: "{{ csrf_token() }}",
            "kg": document.querySelector("#kg").value,
            "amount": document.querySelector("#amount").value
        })
        .then(function(response) {
            $(".modal").modal();
            toastr.success(response.data.message);
            document.querySelector("#kg").value = "";
            document.querySelector("#amount").value = "";
            document.querySelector("#tbl").innerHTML = "";
            let tbody = "";
            response.data.data.map((val) => {
                tbody += "<tr>";
                tbody += "<td>" + val.kg + "</td>";
                tbody += "<td>" + val.amount + "</td>";
                tbody += "<td>";
                tbody += "<form method='POST' action='{{route('prices.status')}}'>";
                tbody += "<input type='hidden' name='_token' value='{{csrf_token()}}'>";
                tbody += "<input type='hidden' name='id' value='" + val.id + "'></input>";
                if (val.turn_on == 0) {
                    tbody +=
                        "<button class='waves-effect waves-light btn btn-small pink lighten-1'>bật</button>";
                } else {
                    tbody +=
                        "<button class='waves-effect waves-light btn btn-small green accent-3 lighten-1'>tắt</button>";
                }
                tbody += "</form>";
                tbody += "</td>";

                tbody += "<td>";
                tbody += "<form method='POST' action='" + val.url + "'>";
                tbody += "<input type='hidden' name='_method' value='DELETE'>";
                tbody += "<input type='hidden' name='_token' value='{{csrf_token()}}'>";
                tbody +=
                    "<button class='waves-effect waves-light btn btn-small red darken-2 lighten-1'>xóa</button>";
                tbody += "</form>";
                tbody += "</td>";

                tbody += "</tr>";
            });
            document.querySelector("#tbl").innerHTML = tbody;
        })
        .catch(function(error) {
            console.log(error);
        });
});
