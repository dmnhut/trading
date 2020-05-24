window.apikey = 'rdPtJTe3tAU-3NtGSN8ZaPeJGm63EsYwqSFwxEzmBYg';
window.addEventListener('resize', () => map.getViewPort().resize());
window.onload = () => {
    moveMapToOrder(map);
    let client = new H.map.Marker({
        lat: 10.02379,
        lng: 105.76654
    });
    client.setData(document.querySelector("#title-address").value);
    client.addEventListener("tap", evt => {
        let bubble = new H.ui.InfoBubble(evt.target.getGeometry(), {
            content: evt.target.getData()
        });
        ui.addBubble(bubble);
    }, false);
    map.addObject(client);
    map.setZoom(16);
};
let platform = new H.service.Platform({
    apikey: window.apikey
});
let defaultLayers = platform.createDefaultLayers();
let map = new H.Map(document.getElementById('map'),
    defaultLayers.vector.normal.map, {
        center: {
            lat: 0,
            lng: 0
        },
        zoom: 4,
        pixelRatio: window.devicePixelRatio || 1
    });
let shipper = new H.map.Marker({
    lat: 10.0336632,
    lng: 105.7738036
});
shipper.setData(document.querySelector("#title-location").value);
shipper.addEventListener("tap", evt => {
    let bubble = new H.ui.InfoBubble(evt.target.getGeometry(), {
        content: evt.target.getData()
    });
    ui.addBubble(bubble);
}, false);
map.addObject(shipper);
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
    map.setCenter({
        lat: 10.02379,
        lng: 105.76654
    });
}
