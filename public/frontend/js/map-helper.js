"use strict"; // Start of use strict

// 7. google map
function gMap () {
	if ($('.google-map').length) {
        $('.google-map').each(function () {
        	// getting options from html
        	var Self = $(this); 
        	var mapName = Self.attr('id');
        	var mapLat = Self.data('map-lat');
        	var mapLng = Self.data('map-lng');
        	var iconPath = Self.data('icon-path');
        	var mapZoom = Self.data('map-zoom');
        	var mapTitle = Self.data('map-title');



        	// defined default style
            var filter = [{'filter': 'grayscale(100%)'}];
            var styles = [{"featureType":"landscape.man_made","elementType":"geometry","stylers":[{"color":"#eaeaea"}]},{"featureType":"landscape.natural","elementType":"geometry","stylers":[{"color":"#e9ddb9"}]},{"featureType":"landscape.natural.terrain","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"poi.business","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","elementType":"geometry","stylers":[{"color":"#e9ddb9"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#e9ddb9"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#fee59d"}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#e6c97d"}]},{"featureType":"road.arterial","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","elementType":"geometry.fill","stylers":[{"color":"black"}]},{"featureType":"transit.station.airport","elementType":"geometry.fill","stylers":[{"color":"#cfb2db"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#ffe7a3"}]}];

        	// if zoom not defined the zoom value will be 15;
        	if (!mapZoom) {
        		var mapZoom = 13;
        	};
        	// init map
        	var map;
            map = new GMaps({
                div: '#'+mapName,
                scrollwheel: false,
                lat: mapLat,
                lng: mapLng,
                styles: "",
                zoomControl : false,
                zoomControlOpt: {
                    style : 'SMALL',
                    position: 'RIGHT_BOTTOM'},
                panControl : false,
                streetViewControl : false,
                zoom: mapZoom,
            });
            
        });  
	};
}



// instance of fuction while Document ready event	
jQuery(document).on('ready', function () {
	(function ($) {
		gMap();
	})(jQuery);
});
