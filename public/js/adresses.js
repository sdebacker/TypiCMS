!function( $ ){

	"use strict";

	$(function () {

		var isGeocoded = false;

		function initAddressForm() {
			var form = $('#address').closest('form');
			form.submit(function(event) {
				if ( ! isGeocoded) {
					var address = [$('#rue').val(),$('#numero').val(),$('#codepostal').val(),$('#localite').val()+', '+$('#pays').val()];
					var addressString = address.join(' ');
					getGeocoderFromAddress(addressString, submitAdressForm);
					return false;
				} else {
					return true;
				}
			});
		}

		function submitAdressForm() {
			var form = $('#address').closest('form');
			form.submit();
		}

		function getGeocoderFromAddress(address, callback) {
			var geocoder = new google.maps.Geocoder();
			geocoder.geocode({
				'address': address
			},
			function(results, status) {
				if(status == google.maps.GeocoderStatus.OK) {
					$('#latitude').attr('value',results[0].geometry.location.lat());
					$('#longitude').attr('value',results[0].geometry.location.lng());
					// console.log(results[0].geometry.location);
					// return false;
					// showMapForLocation(results[0].geometry.location);
					isGeocoded = true;
					callback();
				} else {
					isGeocoded = true;
					callback();
					// alert('Impossible de trouver la position de l’adresse entrée.');
				}
			});
		}

		function showMapForLocation(myLocation) {
			$('#address div').append('<div id="map"></div>');
			$('#map').css({'margin-bottom':'10px','height':'300px','width':'auto'});
			var mapOptions = {
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				center: myLocation,
				zoom: 15
			};
			var map = new google.maps.Map(document.getElementById("map"), mapOptions);
			new google.maps.Marker({
				position: myLocation,
				map: map
			});
		}

		initAddressForm();

	});

}( window.jQuery || window.ender );
