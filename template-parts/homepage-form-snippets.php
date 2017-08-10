<!-- homepage form for snippets page -->
<?php

//$form_price_min = intval( filter_input( INPUT_GET, 'price_min', FILTER_SANITIZE_SPECIAL_CHARS ) );
//var_dump( $form_price_min );

?>

<div class="search-form-wrap-snippets">
    <form method="post" action="#"><!-- @todo form action to switch page to search results? -->
        <div class="main-form-inner">
            <input type="hidden" name="listing-search-form"/>
			<?php if ( $status_options = get_field( 'status_select_options', 'option' ) ) { ?>
                <div class="input-wrap status">
                    <select name="status">
						<?php foreach ( $status_options as $option ) {
							echo '<option value="' . $option["status_name"] . '">' . $option['status'] . '</option>';
						} ?>
                    </select>
                </div>
			<?php } ?>
			<?php if ( $property_type_options = get_field( 'property_type_select_options', 'option' ) ) { ?>
                <div class="input-wrap property-type">
                    <select name="property-type">
                        <option value="all_property_types">All Property Types</option>
						<?php foreach ( $property_type_options as $option ) {
							echo '<option value="' . $option["property_type_name"] . '">' . $option['property_type'] . '</option>';
						} ?>
                    </select>
                </div>
			<?php } ?>
            <div class="input-wrap main-input">
                <input type="text" placeholder="<?php echo get_field( 'search_input_placeholder', 'option' ); ?>"
                       name="city-zip"/>
            </div>
            <input class="submit-input" type="submit" value="Search"/>
        </div>
		<?php
		$price_array = array(
			'$200k' => 200000,
			'$300k' => 300000,
			'$400k' => 400000,
			'$500k' => 500000,
			'$600k' => 600000,
			'$700k' => 700000,
			'$800k' => 800000,
			'$900k' => 900000,
			'$1M'   => 1000000,
			'$1.5M' => 1500000,
			'$2M'   => 2000000,
			'$2.5M' => 2500000,
			'$5M'   => 5000000,
			'$7.5M' => 7500000,
			'$10M'  => 10000000,
			'$15M'  => 15000000,
			'$20M'  => 20000000,
			'$30M'  => 30000000,
			'$50M'  => 50000000
		);

		$sqft_min_array = array(
			'500 sqft'    => 500,
			'1,000 sqft'  => 1000,
			'1,500 sqft'  => 1500,
			'2,000 sqft'  => 2000,
			'3,000 sqft'  => 3000,
			'4,000 sqft'  => 4000,
			'5,000 sqft'  => 5000,
			'6,000 sqft'  => 6000,
			'7,000 sqft'  => 7000,
			'8,000 sqft'  => 8000,
			'9,000 sqft'  => 9000,
			'10,000 sqft' => 10000,
			'11,000 sqft' => 11000
		);

		$sqft_max_array = array(
			'1,000 sqft'  => 1000,
			'1,500 sqft'  => 1500,
			'2,000 sqft'  => 2000,
			'3,000 sqft'  => 3000,
			'4,000 sqft'  => 4000,
			'5,000 sqft'  => 5000,
			'6,000 sqft'  => 6000,
			'7,000 sqft'  => 7000,
			'8,000 sqft'  => 8000,
			'9,000 sqft'  => 9000,
			'10,000 sqft' => 10000,
			'11,000 sqft' => 11000,
			'12,000 sqft' => 12000
		);

		?>
        <div class="advanced-options-wrap">
            <a class="toggle-advanced-options">Advanced Options</a>
            <div class="advanced-options-toggle">
                <div class="advanced-options-item price-min-max">
                    <h5>Price Min and Max</h5>
					<?php //var_dump( $snippets_query ); ?>
                    <div class="advanced-options-inputs input-style-snippet-wrap">
                        <select name="price-min">
							<?php
							if ( $price_min = $snippets_query->price_min ) {
								$array_key = array_search( $price_min, $price_array );
								?>
                                <option value="<?php echo $price_min; ?>"><?php echo $array_key; ?></option>
							<?php } else { ?>
                                <option value="">No Min</option>
							<?php } ?>
							<?php foreach ( $price_array as $label => $value ) { ?>
                                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
							<?php } ?>
                        </select>
                        <select name="price-max">
	                        <?php
	                        if ( $price_max = $snippets_query->price_max ) {
		                        $array_key = array_search( $price_max, $price_array );
		                        ?>
                                <option value="<?php echo $price_max; ?>"><?php echo $array_key; ?></option>
	                        <?php } else { ?>
                                <option value="">No Max</option>
	                        <?php } ?>
							<?php foreach ( $price_array as $label => $value ) { ?>
                                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
							<?php } ?>
                        </select>
                    </div>
                </div>
                <div class="advanced-options-item sqft-min-max">
                    <h5>SQFT Min and Max</h5>
                    <div class="advanced-options-inputs input-style-snippet-wrap">
                        <select name="sqft-min">
                            <option value="">No Min</option>
							<?php foreach ( $sqft_min_array as $label => $value ) { ?>
                                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
							<?php } ?>
                        </select>
                        <select name="sqft-max">
                            <option value="">No Max</option>
							<?php foreach ( $sqft_max_array as $label => $value ) { ?>
                                <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
							<?php } ?>
                        </select>
                    </div>
                </div>
                <div class="advanced-options-item sqft-min-max">
                    <h5>Cap Rate Min and Max</h5>
                    <div class="advanced-options-inputs input-style-snippet-wrap">
                        <input type="text" name="cap-rate-min" placeholder="min"/>
                        <input type="text" name="cap-rate-max" placeholder="max"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>