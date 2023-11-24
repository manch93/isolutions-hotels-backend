@if (Route::has('login'))
    <div>
        @auth
            <a href="{{ route('cms.dashboard') }}">Dashboard</a>
        @else
            <a href="{{ route('login') }}">Log in</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
            @endif
        @endauth
    </div>
@endif


<div id="osm-map" style="width: 100%;height: 400px"></div>

<!-- Leaflet -->
<link href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" rel="stylesheet"/>
<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>

<!-- Eazy button -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.css">
<script src="https://cdn.jsdelivr.net/npm/leaflet-easybutton@2/src/easy-button.js"></script>
<style>
    .easy-button-button .button-state {
        top: 7;
    }
</style>

<!-- Font awesome -->
<link rel="stylesheet" href="https://unpkg.com/@fortawesome/fontawesome-free@6.4.2/css/all.min.css" />
<script src="https://unpkg.com/@fortawesome/fontawesome-free@6.4.2/js/all.min.js"></script>

<!-- Auto complete gmap -->
<input id="autocomplete" type="text" placeholder="Enter a location" style="width: 100%;" />
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCM0gMyC9oVbrpMTRyUvC06Iz79BUKrkw&libraries=places"></script>

<script>
    // Bandung
    const defaultLocation = L.latLng(-6.914864, 107.608238)

    // Map element
    const map = L.map('osm-map').setView(defaultLocation, 14)
    const layerMarker = L.layerGroup().addTo(map)
    let initialLat = 0
    let initialLong = 0
    let latitude = 0
    let longitude = 0

    // Custom red marker icon
    const redIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    })

    askMyLocation()

    // Ask location permission
    function askMyLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(getMyLocation)
        }
    }

    // if browser doesn't support geolocation
    if (typeof navigator.geolocation == "undefined") {
        alert("Your browser doesn't support the Geolocation API")
    }

    // Get location
    function getMyLocation(position) {
        initialLat = position.coords.latitude
        initialLong = position.coords.longitude

        // Set initial location
        const target = L.latLng(initialLat, initialLong)

        changeLongLat(target)

        map.setView(target, 17)
        createMarker(target)
    }

    // Create Marker
    function createMarker(target) {
        let marker = new L.marker(target, {
            draggable: true,
            icon: redIcon,
        })
        marker.on('dragend', event => {
            let marker2 = event.target
            let position = marker2.getLatLng()
            changeLongLat(position)
            marker.setLatLng(position, {
                draggable: true,
            }).update()
        })

        layerMarker.clearLayers()

        marker.addTo(layerMarker)
    }

    // Change location
    function changeLongLat(target) {
        latitude = target.lat
        longitude = target.lng

        console.log(latitude, longitude)
    }

    // Map on drag
    map.on('drag',function(e){
        changeLongLat(map.getCenter())
        createMarker(map.getCenter())
    })

    // Map on click
    map.on('click', function(e) {
        const target = L.latLng(e.latlng.lat, e.latlng.lng)
        changeLongLat(target)
        map.setView(target, 17)

        // Add a marker to the map
        createMarker(target)
    })

    // Show the map
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map)

    // Add zoom home button
    L.easyButton('fa-home', (btn, map) => {
        const target = L.latLng(initialLat, initialLong)
        map.setView(target, 17)

        // Add a marker to the map
        createMarker(target)
    }, 'Zoom To Home').addTo(map)


    // Gmap autocomplete
    const input = document.getElementById('autocomplete')

    const options = {
        fields: ['formatted_address', 'geometry', 'name'],
        strictBounds: false,
    }

    const autocomplete = new google.maps.places.Autocomplete(input, options)

    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace()

        if (!place.geometry || !place.geometry.location) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert('No details available for input: ' + place.name)
            return
        }

        // Get latitude and longitude
        const target = L.latLng(place.geometry.location.lat(), place.geometry.location.lng())

        changeLongLat(target)
        map.setView(target, 17)

        // Add a marker to the map
        createMarker(target)
    })
</script>
