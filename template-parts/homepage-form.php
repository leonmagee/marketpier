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
		<?php if ( is_page( 'search-listings' ) ) { ?>
            <div class="advanced-options-wrap">
                <a href="#">Advanced Options</a>
            </div>
		<?php } ?>
    </form>
</div>