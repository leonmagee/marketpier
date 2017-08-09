<!-- @todo this should pull options from custom field repeater -->
<div class="search-form-wrap">
    <form method="post" action="#"><!-- @todo form action to switch page to search results? -->
        <div class="main-form-inner">
            <input type="hidden" name="listing-search-form"/>
			<?php if ( $status_options = get_field( 'status_select_options', 'option' ) ) { ?>
                <div class="input-wrap status" data-toggle="status-dropdown">
                    <div class="select-toggle">For Sale</div>
                    <i class="fa fa-sort" aria-hidden="true"></i>
                    <div class="dropdown-pane" id="status-dropdown" data-dropdown data-hover="true"
                         data-hover-pane="true">
                        <ul>
							<?php foreach ( $status_options as $option ) {
								echo '<li name="' . $option["status_name"] . '">' . $option['status'] . '</li>';
							} ?>
                        </ul>
                    </div>
                    <input class="hidden-input" type="hidden" name="status"/>
                </div>
			<?php } ?>
			<?php if ( $property_type_options = get_field( 'property_type_select_options', 'option' ) ) { ?>
            <div class="input-wrap property-type" data-toggle="property-type-dropdown">
                <div class="select-toggle">All Property Types</div>
                <i class="fa fa-sort" aria-hidden="true"></i>
                <div class="dropdown-pane" id="property-type-dropdown" data-dropdown data-hover="true"
                     data-hover-pane="true">
                    <ul>
                        <li class="default-choice" name="all_property_types">All Property Types</li>
						<?php foreach ( $property_type_options as $option ) {
							echo '<li name="' . $option["property_type_name"] . '">' . $option['property_type'] . '</li>';
						} ?>
                    </ul>
                </div>
				<?php } ?>
                <input class="hidden-input" type="hidden" name="property-type"/>
            </div>
            <div class="input-wrap main-input">
                <input type="text" placeholder="<?php echo get_field( 'search_input_placeholder', 'option' ); ?>"
                       name="city-zip"/>
                <i class="fa fa-search" aria-hidden="true"></i>
            </div>
            <input class="submit-input" type="submit" value="Submit"/>
        </div>
		<?php if ( is_page( 'search-listings' ) ) {

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

			?>
            <div class="advanced-options-wrap">
                <a class="toggle-advanced-options">Advanced Options</a>
                <div class="advanced-options-toggle">
                    <div class="advanced-options-item price-min-max">
                        <h5>Price Min and Max</h5>
                        <div class="advanced-options-inputs">
                            <select name="price-min">
                                <option value="">No Min</option>
								<?php foreach ( $price_array as $label => $value ) { ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php } ?>
                            </select>
                            <select name="price-max">
                                <option value="">No Max</option>
								<?php foreach ( $price_array as $label => $value ) { ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
								<?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
		<?php } ?>
    </form>
</div>