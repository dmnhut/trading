document.querySelector("#btn-add").addEventListener("click", (event) => {
    event.preventDefault();
    let data = new FormData(document.querySelector("#users-create"));
    $.ajax({
        method: "POST",
        enctype: 'multipart/form-data',
        url: document.querySelector("#users-create").action,
        contentType: false,
        processData: false,
        data: data,
        success: function(response) {
            if (response.error) {
                response.messages.map((val) => {
                    toastr["error"](val);
                });
            } else {
                location = document.querySelector("#users-create").action
            }
        }
    });
});
