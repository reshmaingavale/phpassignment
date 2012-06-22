jQuery(document).ready(function () {
    if (typeof google !== "undefined") {
        var eo_venue_Lat = jQuery("#eo_venue_Lat").val();
        var eo_venue_Lng = jQuery("#eo_venue_Lng").val();
	console.log(eo_venue_Lat);
        if (typeof eo_venue_Lat !== "undefined" && typeof eo_venue_Lng !== "undefined") {
            var map;
            var marker;
            eo_initialize_map(eo_venue_Lat, eo_venue_Lng);
            jQuery(".eo_addressInput").change(function () {
                address = "";
                jQuery(".eo_addressInput").each(function () {
                    if (jQuery(this).attr('id') != 'country-selector') {
                        address = address + " " + jQuery(this).val()
                    }
                });
                codeAddress(address)
            })
        }
    }
});

function eo_initialize_map(Lat, Lng) {

    if (typeof google !== "undefined") {
        var latlng = new google.maps.LatLng(Lat, Lng);

        var myOptions = {
            zoom: 15,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById("venuemap"), myOptions);

        if (typeof EO_Venue != 'undefined') {
            draggable = true
        } else {
            draggable = false
        }

        marker = new google.maps.Marker({
            position: latlng,
            map: map,
            draggable: draggable
        });

        if (typeof EO_Venue != 'undefined') {
            google.maps.event.addListener(marker, 'dragend', function (evt) {
                jQuery("#eo_venue_Lat").val(evt.latLng.lat().toFixed(6));
                jQuery("#eo_venue_Lng").val(evt.latLng.lng().toFixed(6));
                map.setCenter(marker.position)
            })
        }
    }
}

function codeAddress(addrStr) {
    var geocoder;
    geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        'address': addrStr
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            map.setCenter(results[0].geometry.location);
            marker.setMap(null);
            if (typeof EO_Venue != 'undefined') {
                draggable = true
            } else {
                draggable = false
            }
            marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location,
                draggable: draggable
            });
            if (typeof EO_Venue != 'undefined') {
                google.maps.event.addListener(marker, 'dragend', function (evt) {
                    jQuery("#eo_venue_Lat").val(evt.latLng.lat().toFixed(6));
                    jQuery("#eo_venue_Lng").val(evt.latLng.lng().toFixed(6));
                    map.setCenter(marker.position)
                })
            }
            jQuery("#eo_venue_Lat").val(results[0].geometry.location.lat());
            jQuery("#eo_venue_Lng").val(results[0].geometry.location.lng())
        }
    })
}
