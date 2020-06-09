const geoGet = () => {
    const status = document.querySelector("#status");
    const lat = document.querySelector("#lat");
    const lng = document.querySelector("#lng");
    lat.textContent = "";
    lng.textContent = "";
    const success = position => {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        status.textContent = "";
        lat.innerHTML = latitude;
        lng.innerHTML = longitude;
        axios.post(document.querySelector("input[name=_url_location_store]").value, {
            _token: document.querySelector("input[name=_token]").value,
            _method: document.querySelector("input[name=_method]").value,
            order: document.querySelector("input[name=order]").value,
            shipper: document.querySelector("input[name=shipper]").value,
            lat: latitude,
            lng: longitude
        }).then(response => {
            console.log(response.data);
            if (response.data.error) {
                // TODO
            } else {
                // TODO
            }
        }).catch(error => {
            console.log(error);
        });
    }
    const error = () => {
        status.textContent = "Unable to retrieve your location";
    }
    if (!navigator.geolocation) {
        status.textContent = "Geolocation is not supported by your browser";
    } else {
        status.textContent = "Locating…";
        navigator.geolocation.getCurrentPosition(success, error);
    }
}

setInterval(() => {
    geoGet();
}, 10000);
