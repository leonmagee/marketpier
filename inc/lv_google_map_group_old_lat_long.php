<?php

/**
 * Class lv_google_map_group
 * Google Maps API script enqueued through 'output_map' method - url includes reference
 * to callback function 'initMap' - https://maps.googleapis.com/maps/api/js?callback=initMap
 *
 */
class lv_google_map_group_old {

	public $location_array;
	public $zoom;

	public function __construct( $location_array, $zoom = 12 ) {

		$this->location_array = $location_array;
		$this->zoom           = $zoom;
	}

	private function generate_map_lat_lng() { ?>

        <script>
            function initMap() {

                /**
                 * Create Starting Variables
                 */
                var latlngArray = [];
                var latTotal = 0;
                var lngTotal = 0;

				<?php

				/**
				 *  Move data from PHP array to JS array
				 */
				foreach ( $this->location_array as $location ) {

				//$latitude = $location['lat'] ? $location['lat'] : 0;
				//$longitude = $location['long'] ? $location['long'] : 0;
				?>
                latlngArray.push({
//                    latLng: {
//                        lat: <?php //echo $latitude; ?>//,
//                        lng: <?php //echo $longitude; ?>
//                    },
                    address: '<?php echo $location['address']; ?>',
                    price: '<?php echo $location['price']; ?>',
                    url: '<?php echo $location['url']; ?>'
                });

				<?php } ?>

                var len = latlngArray.length;
                var count = 0;
                var latitude_array = [];
                var longitude_array = [];
                var url_array = [];
                var price_array = [];
                var geo = new google.maps.Geocoder();

                getLatLngAddress(latlngArray, len, geo);

                function getLatLngAddress(latlngArray, array_length, geo) {

                    if (count < array_length) {

                        var new_address = latlngArray[count].address;
                        var latitude = latlngArray[count].latLng.lat;
                        var longitude = latlngArray[count].latLng.lng;
                        var listing_url = latlngArray[count].url;
                        var listing_price = latlngArray[count].price;

                        geo.geocode({address: new_address}, function (results, status) {
                            console.log('count' + count, results);
                            if (results[0]) { // @todo finish this
                                if (!latitude || !longitude) {
                                    latitude = results[0].geometry.location.lat();
                                    longitude = results[0].geometry.location.lng();
                                }

                                latTotal = latTotal + latitude;
                                lngTotal = lngTotal + longitude;

                                latitude_array.push(latitude);
                                longitude_array.push(longitude);
                                url_array.push(listing_url);
                                price_array.push(listing_price);
                            }

                            ++count;

                            getLatLngAddress(latlngArray, array_length, geo);
                        });

                    } else {

                        /**
                         * Calculate Map Center
                         */
                        var center_lat = latTotal / array_length;
                        var center_lng = lngTotal / array_length;
                        var centerLatLng = {lat: center_lat, lng: center_lng};

                        /**
                         * Get Map Element
                         */
                        var mapDiv = document.getElementById('map');

                        /**
                         * Generate Map
                         */
                        var map = new google.maps.Map(mapDiv, {
                            center: centerLatLng,
                            zoom: <?php echo $this->zoom; ?>,
                            scrollwheel: false,
                            draggable: true
                        });

                        /**
                         *  Create Map Markers
                         */

                        var squareBg = {
                            path: 'M95.62,34.988c0,5.522-4.478,10-10,10H14.38c-5.523,0-10-4.478-10-10V15.011c0-5.522,4.477-9.999,10-9.999h71.24c5.522,0,10,4.477,10,9.999V34.988z',
                            fillColor: '#00A3E4',
                            fillOpacity: 1,
                            scale: 0.47,
                            strokeColor: '#FFF',
                            strokeWeight: 3,
                            color: '#FFF',
                            labelOrigin: new google.maps.Point(47, 25),
                            anchor: new google.maps.Point(9, 35),
                        };

                        for (var index = 0; index < array_length; ++index) {

                            var current_price = price_array[index];

                            //var listing_price = '999k';
                            var marker = new google.maps.Marker({
                                //position: map.getCenter(),
                                position: {lat: latitude_array[index], lng: longitude_array[index]},
                                //icon: goldStar,
                                icon: squareBg,
                                label: {
                                    text: current_price,
                                    color: '#FFF',
                                    fontWeight: '700',
                                    fontFamily: 'Open Sans',
                                    fontSize: '11px'
                                },
                                map: map
                            });

                            var current_link = url_array[index];


                            new_marker_link(marker, current_link);

                            function new_marker_link(marker, current_link) {
                                marker.addListener('click', function () {
                                    window.location.href = current_link;
                                });
                            }

                        }
                    }
                }
            }
        </script>

	<?php }

	/**
	 *  Output Google Map - called from snippets loop?
	 */
	public function output_map() {

		$this->generate_map_lat_lng();

		?>

        <script src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyCicY4hdtrXeGNvBQSivkxAKOseNIDWZdc"
                async defer></script>

        <div class="google-map-outer-wrapper">

            <div class="map-spinner-div"><i class="fa fa-refresh fa-spin" aria-hidden="true"></i></div>

            <div id="map"></div>

        </div>

	<?php }

}