document.querySelectorAll(".btn-detail").forEach(function(element) {
    element.addEventListener("click", function() {
        let data = {
            _token: document.querySelector("input[name=_token]").value,
            id: this.getAttribute("data")
        }
        axios.post(document.querySelector("#modal-detail").getAttribute("url"), data)
            .then(function(response) {
                if (response.data != 0) {
                    document.querySelector("#detail-name").innerHTML = response.data.name;
                    document.querySelector("#detail-birthdate").innerHTML = response.data.birthdate;
                    document.querySelector("#detail-email").innerHTML = response.data.email;
                    document.querySelector("#detail-identity_card").innerHTML = response.data.identity_card;
                    document.querySelector("#detail-phone").innerHTML = response.data.phone;
                    document.querySelector("#detail-gender").innerHTML = response.data.gender;
                    $("#modal-detail").modal("open");
                }
            })
            .catch(function(error) {
                console.log(error);
            });
    });
});
