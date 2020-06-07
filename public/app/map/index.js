window.apikey = "rdPtJTe3tAU-3NtGSN8ZaPeJGm63EsYwqSFwxEzmBYg";
window.addEventListener("resize", () => map.getViewPort().resize());
window.onload = () => {
    moveMapToOrder(map);
    let {
        lat,
        lng
    } = JSON.parse(document.querySelector("#destination").value);
    let client = new H.map.Marker({
        lat,
        lng
    });
    client.setData(document.querySelector("#title-address").value);
    client.addEventListener("tap", evt => {
        let bubble = new H.ui.InfoBubble(evt.target.getGeometry(), {
            content: evt.target.getData()
        });
        ui.addBubble(bubble);
    }, false);
    map.addObject(client);
    map.setZoom(18);
    setInterval(
        () => {
            getLocationShipper()
        },
        10000
    );
};

let platform = new H.service.Platform({
    apikey: window.apikey
});
let defaultLayers = platform.createDefaultLayers();
let map = new H.Map(document.getElementById("map"),
    defaultLayers.vector.normal.map, {
        center: {
            lat: 0,
            lng: 0
        },
        zoom: 4,
        pixelRatio: window.devicePixelRatio || 1
    });
let ui = H.ui.UI.createDefault(map, defaultLayers);
let behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

const moveMapToOrder = map => {
    let x = document.getElementById("demo");
    const getLocation = () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }
    const showPosition = position => {
        x.innerHTML = "Latitude: " + position.coords.latitude +
            "<br>Longitude: " + position.coords.longitude;
    }
    let {
        lat,
        lng
    } = JSON.parse(document.querySelector("#destination").value);
    map.setCenter({
        lat,
        lng
    });
}

const getLocationShipper = () => {
    axios.get(document.querySelector("input[name=_url_map_get]").value, {
        params: {
            order: document.querySelector("input[name=order]").value
        }
    }).then(response => {
        if (response.data.error) {
            // TODO
        } else {
            if (map.getObjects().length > 1) {
                map.removeObject(map.getObjects()[1])
            }
            ui.getBubbles().forEach(bubble => {
                ui.removeBubble(bubble);
            });
            let shipper = new H.map.Marker({
                lat: response.data.data.lat,
                lng: response.data.data.lng
            });
            shipper.setData(document.querySelector("#title-location").value);
            shipper.addEventListener("tap", evt => {
                let bubble = new H.ui.InfoBubble(evt.target.getGeometry(), {
                    content: evt.target.getData()
                });
                ui.addBubble(bubble);
            }, false);
            map.addObject(shipper);
            map.setCenter({
                lat: response.data.data.lat,
                lng: response.data.data.lng
            });
        }
    }).catch(error => {
        console.log(error);
    });
}