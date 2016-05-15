
// Misc-Gmaps.js
// ====================================================================
// This file should not be included in your project.
// This is just a sample how to initialize plugins or components.
//
// - ThemeOn.net -



$(document).ready(function() {


	// GMAPS
	// =================================================================
	// Require gmaps
	// -----------------------------------------------------------------
	// http://hpneo.github.io/gmaps/
	// =================================================================



	



	// Geocoding
	// =================================================================
	var geomap = new GMaps({
		div: '#demo-geocoding-map',
		lat: -12.043333,
		lng: -77.028333
	});

	$('#demo-geocoding-form').submit(function(e){
		e.preventDefault();
		GMaps.geocode({
			address: $('#demo-geocoding-address').val().trim(),
			callback: function(results, status){
				if(status=='OK'){
					var latlng = results[0].geometry.location;
					geomap.setCenter(latlng.lat(), latlng.lng());
					geomap.addMarker({
						lat: latlng.lat(),
						lng: latlng.lng()
					})
				}
			}
		})
	})

});
