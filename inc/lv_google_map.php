<?php

/**
 * Class lv_google_map
 * Google Maps API script enqueued through 'output_map' method - url includes reference
 * to callback function 'initMap' - https://maps.googleapis.com/maps/api/js?callback=initMap
 */
class lv_google_map {

	public $lat;
	public $lng;
	public $title;
	public $address;
	public $zoom;

	public function __construct( $lat, $lng, $title, $address, $zoom = 17 ) {

		$this->lat     = $lat;
		$this->lng     = $lng;
		$this->title   = $title;
		$this->address = $address;
		$this->zoom = $zoom;
	}

	private function generate_map_lat_lng() { ?>

		<script>
            function initMap() {

                /**
                 * Generate map from lat and lng (entered manually in custom fields)
                 */
                var myLatLng = {lat: <?php echo $this->lat; ?>, lng: <?php echo $this->lng; ?>};

                var mapDiv = document.getElementById('map');

                var map = new google.maps.Map(mapDiv, {
                    center: myLatLng,
                    zoom: <?php echo $this->zoom; ?>,
                    scrollwheel: false,
                    draggable: false
                });

                new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: '<?php echo $this->title; ?>'
                });
            }
		</script>

	<?php }

	private function generate_map_address() { ?>

		<script>
            function initMap() {

                /**
                 *  Use Geocode to get lat and lng from address
                 */
                var geo = new google.maps.Geocoder();

                function mapFromAddress(address) {
                    geo.geocode({address: address}, function (results, status) {
                        var latitude = results[0].geometry.location.lat();
                        var longitude = results[0].geometry.location.lng();

                        var myLatLng = {lat: latitude, lng: longitude};

                        var mapDiv = document.getElementById('map');

                        var map = new google.maps.Map(mapDiv, {
                            center: myLatLng,
                            zoom: <?php echo $this->zoom; ?>,
                            scrollwheel: false,
                            draggable: false
                        });

                        new google.maps.Marker({
                            position: myLatLng,
                            map: map,
                            title: '<?php echo $this->title; ?>'
                        });
                    });
                }

                mapFromAddress('<?php echo $this->address; ?>');

            }
		</script>

	<?php }

	/**
	 *  Output Google Map - called from 'single-mp-listing.php'
	 */
	public function output_map() {

		if ( $this->lat && $this->lng ) {

			$this->generate_map_lat_lng();

		} else {

			$this->generate_map_address();
		}

		?>

		<script src="https://maps.googleapis.com/maps/api/js?callback=initMap&key=AIzaSyCKeKMky70N8WI8MXq9PWspwbRFBVSbnA4"
		        async defer></script>

		<div class="google-map-inner-wrapper">

			<div id="map"></div>

		</div>

	<?php }

}