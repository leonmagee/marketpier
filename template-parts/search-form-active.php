<div class="search-form-wrap-snippets">
    <form method="post" action="#"><!-- @todo form action to switch page to search results? -->
        <div class="main-form-inner">
            <input type="hidden" name="listing-search-form"/>
			<?php if ( ! ( $page_number = $snippets_query->page_number ) ) {
				$page_number = 1;
			} ?>
            <input value="<?php echo $page_number; ?>" type="hidden" name="page-number"/>
			<?php if ( $for_sale_lease_options = get_field( 'for_sale_for_lease_select_options', 'option' ) ) { ?>
                <div class="input-wrap status">
                    <select name="for-sale-lease">
						<?php foreach ( $for_sale_lease_options as $option ) {
							if ( $option['status_name'] == $snippets_query->status ) {
								echo '<option selected="selected" value="' . $option["status_name"] . '">' . $option['status'] . '</option>';
							} else {
								echo '<option value="' . $option["status_name"] . '">' . $option['status'] . '</option>';
							}
						} ?>
                    </select>
                </div>
			<?php } ?>
			<?php if ( $property_type_options = get_field( 'property_type_select_options', 'option' ) ) { ?>
                <div class="input-wrap property-type">
                    <select name="property-type">
                        <option value="all_property_types">All Property Types</option>
						<?php foreach ( $property_type_options as $option ) {
							if ( $option['property_type_name'] == $snippets_query->property_type ) {
								echo '<option selected="selected" value="' . $option["property_type_name"] . '">' . $option['property_type'] . '</option>';
							} else {
								echo '<option value="' . $option["property_type_name"] . '">' . $option['property_type'] . '</option>';
							}
						} ?>
                    </select>
                </div>
			<?php } ?>
            <div class="input-wrap main-input">
				<?php if ( $city_zip = $snippets_query->city_zip ) { ?>
                    <input type="text" placeholder="<?php echo get_field( 'search_input_placeholder', 'option' ); ?>"
                           name="city-zip" value="<?php echo $city_zip; ?>"/>
				<?php } else { ?>
                    <input type="text" placeholder="<?php echo get_field( 'search_input_placeholder', 'option' ); ?>"
                           name="city-zip"/>
				<?php } ?>
            </div>
            <input class="submit-input" type="submit" value="Search"/>
        </div>
		<?php
		$price_array_min = array(
			'No Min' => 0,
			'$200k'  => 200000,
			'$300k'  => 300000,
			'$400k'  => 400000,
			'$500k'  => 500000,
			'$600k'  => 600000,
			'$700k'  => 700000,
			'$800k'  => 800000,
			'$900k'  => 900000,
			'$1M'    => 1000000,
			'$1.5M'  => 1500000,
			'$2M'    => 2000000,
			'$2.5M'  => 2500000,
			'$5M'    => 5000000,
			'$7.5M'  => 7500000,
			'$10M'   => 10000000,
			'$15M'   => 15000000,
			'$20M'   => 20000000,
			'$30M'   => 30000000,
			'$50M'   => 50000000
		);

		$price_array_max = array(
			'No Max' => 0,
			'$200k'  => 200000,
			'$300k'  => 300000,
			'$400k'  => 400000,
			'$500k'  => 500000,
			'$600k'  => 600000,
			'$700k'  => 700000,
			'$800k'  => 800000,
			'$900k'  => 900000,
			'$1M'    => 1000000,
			'$1.5M'  => 1500000,
			'$2M'    => 2000000,
			'$2.5M'  => 2500000,
			'$5M'    => 5000000,
			'$7.5M'  => 7500000,
			'$10M'   => 10000000,
			'$15M'   => 15000000,
			'$20M'   => 20000000,
			'$30M'   => 30000000,
			'$50M'   => 50000000
		);

		$sqft_min_array = array(
			'No Min'      => 0,
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
			'No Max'      => 0,
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

		$lot_size_array = array(
			'Any'                    => 0,
			'2,000+ sqft'            => 2000,
			'3,000+ sqft'            => 3000,
			'4,000+ sqft'            => 4000,
			'5,000+ sqft'            => 5000,
			'7,500+ sqft'            => 7000,
			'.25+ acre/10,890+ sqft' => 10890,
			'.5+ acre/10,890+ sqft'  => 21780,
			'1+ acre'                => 43560,
			'2+ acres'               => 87120,
			'5+ acres'               => 217800,
			'10+ acres'              => 435600,
		);

		$days_on_market_array = array(
			'Any'       => 0,
			'1 day'     => 1,
			'7 days'    => 7,
			'14 days'   => 14,
			'30 days'   => 30,
			'90 days'   => 90,
			'6 months'  => 182,
			'12 months' => 365,
			'24 months' => 730,
			'36 months' => 1095,
		);

		$search_request = $_SERVER['REQUEST_URI'];
		?>
        <div class="advanced-options-wrap">
            <a class="toggle-advanced-options">Advanced Options</a>
			<?php if ( is_user_logged_in() ) {

				global $wpdb;
				$prefix              = $wpdb->prefix;
				$table_name          = $prefix . 'mp_saved_searches';
				$user_id             = MP_LOGGED_IN_ID;
				$saved_search_query  = "SELECT * FROM `{$table_name}` WHERE `user_id` = '{$user_id}' AND `search_url` = '{$search_request}'";
				$saved_search_result = $wpdb->get_results( $saved_search_query );
				if ( $saved_search_result ) {
					$saved_class = 'saved';
				} else {
					$saved_class = '';
				}

				?>
                <a class="save-search-link <?php echo $saved_class; ?>" search_request="<?php echo $search_request; ?>"
                   user_id="<?php echo MP_LOGGED_IN_ID; ?>">Save<span>d</span> Search<i
                            class="fa fa-refresh fa-spin"></i></a>
			<?php } else { ?>
                <a class="save-search-link" data-open="login-modal">Save Search<i class="fa fa-refresh fa-spin"></i></a>
			<?php } ?>
            <div class="advanced-options-toggle">
                <div class="advanced-options-item price-min-max">
                    <h5>Price Range ($)</h5>
                    <div class="advanced-options-inputs input-style-snippet-wrap">
                        <select name="price-min">
							<?php foreach ( $price_array_min as $label => $value ) {
								if ( $snippets_query->price_min == $value ) { ?>
                                    <option selected="selected"
                                            value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php } else { ?>

                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php }
							} ?>
                        </select>
                        <select name="price-max">
							<?php foreach ( $price_array_max as $label => $value ) {
								if ( $snippets_query->price_max == $value ) { ?>
                                    <option selected="selected"
                                            value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php } else { ?>

                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php }
							} ?>
                        </select>
                    </div>
                </div>
                <div class="advanced-options-item sqft-min-max">
                    <h5>Building Size (SF)</h5>
                    <div class="advanced-options-inputs input-style-snippet-wrap">
                        <select name="sqft-min">
							<?php foreach ( $sqft_min_array as $label => $value ) {
								if ( $snippets_query->sqft_min == $value ) { ?>
                                    <option selected="selected"
                                            value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php } else { ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php }
							} ?>
                        </select>
                        <select name="sqft-max">
							<?php foreach ( $sqft_max_array as $label => $value ) {
								if ( $snippets_query->sqft_max == $value ) { ?>
                                    <option selected="selected"
                                            value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php } else { ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php }
							} ?>
                        </select>
                    </div>
                </div>
                <div class="advanced-options-item cap-rate-min-max">
                    <h5>Cap Rate (%)</h5>
                    <div class="advanced-options-inputs input-style-snippet-wrap">
						<?php
						if ( $cap_rate_min = $snippets_query->cap_rate_min ) {
							?>
                            <input type="text" name="cap-rate-min" value="<?php echo $cap_rate_min; ?>"/>
						<?php } else { ?>
                            <input type="text" name="cap-rate-min" placeholder="0.00"/>
						<?php } ?>
						<?php
						if ( $cap_rate_max = $snippets_query->cap_rate_max ) {
							?>
                            <input type="text" name="cap-rate-max" value="<?php echo $cap_rate_max; ?>"/>
						<?php } else { ?>
                            <input type="text" name="cap-rate-max" placeholder="0.00"/>
						<?php } ?>
                    </div>
                </div>
                <div class="advanced-options-item lot-size quarter">
                    <h5>Lot Size (SF or AC)</h5>
                    <div class="advanced-options-inputs input-style-snippet-wrap">
                        <select name="lot-size">
							<?php foreach ( $lot_size_array as $label => $value ) {
								if ( $snippets_query->lot_size_min == $value ) { ?>
                                    <option selected="selected"
                                            value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php } else { ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php }
							} ?>
                        </select>
                    </div>
                </div>
                <div class="advanced-options-item days-on-market quarter">
                    <h5>Days on Market</h5>
                    <div class="advanced-options-inputs input-style-snippet-wrap">
                        <select name="days-on-market">
							<?php foreach ( $days_on_market_array as $label => $value ) {
								if ( $snippets_query->days_on_market == $value ) { ?>
                                    <option selected="selected"
                                            value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php } else { ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php }
							} ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>