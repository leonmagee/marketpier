<?php

/**
 * Class lv_google_map_group
 * Google Maps API script enqueued through 'output_map' method - url includes reference
 * to callback function 'initMap' - https://maps.googleapis.com/maps/api/js?callback=initMap
 *
 */
class lv_google_map_group {

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

				$latitude = $location['lat'] ? $location['lat'] : 0;
				$longitude = $location['long'] ? $location['long'] : 0;
				?>
                latlngArray.push({
                    latLng: {
                        lat: <?php echo $latitude; ?>,
                        lng: <?php echo $longitude; ?>
                    },
                    address: '<?php echo $location['address']; ?>',
                    url: '<?php echo $location['url']; ?>'
                });

				<?php } ?>

                var len = latlngArray.length;
                var count = 0;
                var latitude_array = [];
                var longitude_array = [];
                var url_array = [];
                var geo = new google.maps.Geocoder();

                getLatLngAddress(latlngArray, len, geo);

                function getLatLngAddress(latlngArray, array_length, geo) {

                    if (count < array_length) {

                        var new_address = latlngArray[count].address;
                        var latitude = latlngArray[count].latLng.lat;
                        var longitude = latlngArray[count].latLng.lng;
                        var listing_url = latlngArray[count].url;

                        geo.geocode({address: new_address}, function (results, status) {

                            if (!latitude || !longitude) {

                                latitude = results[0].geometry.location.lat();
                                longitude = results[0].geometry.location.lng();
                            }

                            latTotal = latTotal + latitude;
                            lngTotal = lngTotal + longitude;

                            latitude_array.push(latitude);
                            longitude_array.push(longitude);
                            url_array.push(listing_url);

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
                            draggable: false
                        });

                        /**
                         *  Create Map Markers
                         */

                        for (var index = 0; index < array_length; ++index) {

                            marker = new google.maps.Marker({
                                position: {lat: latitude_array[index], lng: longitude_array[index]},
                                map: map,
                                title: latlngArray[index].address
                            });

                            var current_link = url_array[index];

                            new_marker_link(marker, current_link);

                            function new_marker_link(marker, current_link){
                                marker.addListener('click', function() {
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

			<div id="map"></div>

		</div>

	<?php }

}