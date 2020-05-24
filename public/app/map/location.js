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
        lat.textContent = latitude;
        lng.textContent = longitude
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
geoGet();
