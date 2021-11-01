function initialize(DEFAULT_LATITUDE, DEFAULT_LONGITUDE) {
    const locationInputs = document.getElementsByClassName("map-input");

    const autocompletes = [];
    const geocoder = new google.maps.Geocoder();
    for (let i = 0; i < locationInputs.length; i++) {
        const input = locationInputs[i];
        const fieldKey = input.id.replace("-input", "");
        const isEdit =
            document.getElementById(fieldKey + "-latitude").value != "" &&
            document.getElementById(fieldKey + "-longitude").value != "";

        const latitude =
            parseFloat(document.getElementById(fieldKey + "-latitude").value) ||
            DEFAULT_LATITUDE;
        const longitude =
            parseFloat(
                document.getElementById(fieldKey + "-longitude").value
            ) || DEFAULT_LONGITUDE;

        const map = new google.maps.Map(
            document.getElementById(fieldKey + "-map"),
            {
                center: { lat: latitude, lng: longitude },
                zoom: 13
            }
        );

        const marker = new google.maps.Marker({
            map: map,
            position: { lat: latitude, lng: longitude }
        });

        map.addListener("click", mapsMouseEvent => {
            input.value = "";

            marker.setPosition({
                lat: mapsMouseEvent.latLng.lat(),
                lng: mapsMouseEvent.latLng.lng()
            });

            map.setCenter(marker.getPosition());

            geocoder.geocode({ location: marker.getPosition() }, function(
                results,
                status
            ) {
                if (status === google.maps.GeocoderStatus.OK) {
                    if (results[0]) {
                        const lat = results[0].geometry.location.lat();
                        const lng = results[0].geometry.location.lng();
                        map.setZoom(17);
                        results[0].address_components.pop();
                        console.log(results[0].address_components);
                        for (
                            let index = 1;
                            index < results[0].address_components.length;
                            index++
                        ) {
                            if (index === 1) {
                                input.value +=
                                    results[0].address_components[0].long_name +
                                    " " +
                                    results[0].address_components[index]
                                        .long_name +
                                    ", ";

                                continue;
                            }

                            input.value +=
                                results[0].address_components[index].long_name +
                                ", ";
                        }

                        setLocationCoordinates(fieldKey, lat, lng);
                    } else {
                        window.alert("No results found");
                        input.value = "";

                        return;
                    }
                }
            });

            // marker.setPosition(place.geometry.location);
            marker.setVisible(true);
        });

        marker.setVisible(isEdit);

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.key = fieldKey;
        autocompletes.push({
            input: input,
            map: map,
            marker: marker,
            autocomplete: autocomplete
        });
    }

    for (let i = 0; i < autocompletes.length; i++) {
        const input = autocompletes[i].input;
        const autocomplete = autocompletes[i].autocomplete;
        const map = autocompletes[i].map;
        const marker = autocompletes[i].marker;

        google.maps.event.addListener(
            autocomplete,
            "place_changed",
            function() {
                marker.setVisible(false);
                const place = autocomplete.getPlace();

                geocoder.geocode({ placeId: place.place_id }, function(
                    results,
                    status
                ) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        const lat = results[0].geometry.location.lat();
                        const lng = results[0].geometry.location.lng();
                        setLocationCoordinates(autocomplete.key, lat, lng);
                    }
                });

                if (!place.geometry) {
                    window.alert(
                        "No details available for input: '" + place.name + "'"
                    );
                    input.value = "";
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }
                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
            }
        );
    }
}

function setLocationCoordinates(key, lat, lng) {
    const latitudeField = document.getElementById(key + "-" + "latitude");
    const longitudeField = document.getElementById(key + "-" + "longitude");
    latitudeField.value = lat;
    longitudeField.value = lng;
}
