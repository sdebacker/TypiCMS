// Gmaps
if (jQuery('#map').length) {
    var infoWindow = new google.maps.InfoWindow(),
        markers = [],
        markersPoints = [],
        markersPos = [],
        noms = [],
        iterator = 0,
        mapOptions = {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: new google.maps.LatLng(50.85,4.36),
            mapTypeControl: false,
            streetViewControl: false,
            zoom: 12
        },
        markerShape = {
            coord: [0,0, 27,0, 27,37, 0,37],
            type: 'poly'
        },
        map = new google.maps.Map(document.getElementById('map'), mapOptions);
    // var markerCluster = new MarkerClusterer(map);

    google.maps.event.addListener(map, 'click', function() {
        infoWindow.close();
    });

    function getMarkerIcon(shape) {
        if (!shape) {
            shape = '/images/marker.png';
        }
        return new google.maps.MarkerImage('/images/'+shape+'.png',
            new google.maps.Size(34, 44),
            new google.maps.Point(0, 0),
            new google.maps.Point(14, 36)
        )
    }

    function drop() {
        if (markers.length <= 3) {
            for (var i = 0; i < markers.length; i++) {
                setTimeout(function() {
                    addMarker(google.maps.Animation.DROP);
                }, i * 200);
            }
        } else {
            for (var i = 0; i < markers.length; i++) {
                addMarker(false);
            }
        }
    }

    function addMarker(animation) {

        // decaler un marker s'il y a déjà un point à la même position
        var dedans = 0;
        for (var i = markers.length - 1; i >= 0; i--){
            // console.log(markers[iterator].lat());
            if (markersPos[iterator].lat() == markersPos[i].lat() && markersPos[iterator].lng() == markersPos[i].lng()) {
                // markers[i]['html'] += markers[iterator]['html'];
                dedans++;
            }
        };
        var latLng;
        if (dedans >= 2) {
            // console.log(dedans+' '+iterator);
            // Il y a au moins deux points ayant la même position, alors on décale un des deux
            latLng = new google.maps.LatLng(markersPos[iterator].lat(), markersPos[iterator].lng() + Math.random() / 4000 + 0.00001);
        } else {
            latLng = markersPos[iterator];
        }

        markersPoints[iterator] = new google.maps.Marker({
            // icon: getMarkerIcon(markers[iterator]['shape']),
            shape: markerShape,
            position: latLng,
            map: map,
            draggable: false,
            animation: animation
        });
        // console.log(markers[iterator]);
        markersPoints[iterator].html = markers[iterator]['html'];
        markersPoints[iterator].id = markers[iterator]['id'];
        // console.log(marker);
        google.maps.event.addListener(markersPoints[iterator], 'click', onMarkerClick);
        // google.maps.event.addListener(marker, 'mouseover', highligthAddress);
        iterator++;
    }

    function highligthAddress(markerId) {
        // console.log('marker : '+markerId);
        var item = jQuery('#item-'+markerId);
        if (item.length && ! item.hasClass('active')) {
            jQuery('.addresses .active').removeClass('active');
            item.addClass('active');
        }
    }

    function AutoCenter() {
        var bounds = new google.maps.LatLngBounds();
        jQuery.each(markers, function (index, marker) {
            bounds.extend(markersPos[index]);
        });
        map.fitBounds(bounds);
        var listener = google.maps.event.addListener(map, 'idle', function() {
            if (map.getZoom() > 17) map.setZoom(17);
            google.maps.event.removeListener(listener);
        });
    }

    var onMarkerClick = function() {
        // console.log(this);
        highligthAddress(this.id);
        infoWindow.setContent(this.html);
        infoWindow.open(map, this);
    };

    jQuery.getJSON('/api/places' + location.search, function(data) {
        if ( ! jQuery.isArray(data) ) {
            data = [data];
        }
        for (var i = 0; i < data.length; i++) {
            markersPos[i] = new google.maps.LatLng(data[i].latitude, data[i].longitude);
            markers[i] = {};
            var coords = [];
            markers[i]['id'] = data[i].id;
            markers[i]['shape'] = data[i].shape;
            markers[i]['html'] = '<h4>' + data[i].title + '</h4>';
            markers[i]['html'] += '<p>';
            if (data[i].address) coords.push(data[i].address);
            if (data[i].phone) coords.push('T ' + data[i].phone);
            if (data[i].fax) coords.push('F ' + data[i].fax);
            if (data[i].email) coords.push('<a href="mailto:' + data[i].email + '">' + data[i].email + '</a>');
            if (data[i].website) coords.push('<a href="' + data[i].website + '" target="_blank">' + data[i].website + '</a>');
            markers[i]['html'] += coords.join('<br>');
            markers[i]['html'] += '</p>';
        }
        // console.log(markers);
        if (markers.length > 0) {
            drop();
            AutoCenter();
        }
    });
}

jQuery('.btn-map').click(function(){
    var id = jQuery(this).closest('li').attr('id').replace(/item-/gi,'');
    // console.log( 'click : '+id );
    for (var i = markers.length - 1; i >= 0; i--){
        // console.log( markers[i].id );
        if (markers[i].id == id) {
            var latLng = new google.maps.LatLng(markersPos[i].lat(),markersPos[i].lng());
            map.panTo( latLng );
            // map.setZoom(13);
            google.maps.event.trigger(markersPoints[i], 'click');
        }
    }
    return false;
});
