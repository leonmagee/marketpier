<?php
/**
 * The template for displaying all single listing posts
 *
 * @package MarketPier
 */
get_template_part( 'template-parts/spinner' );

get_header();

require_once( 'inc/lv_google_map.php' );
require_once( 'inc/listing_data.php' );
$listing_data = new listing_data();
/**
 * Conditional based on url string.
 */
$request_uri     = $_SERVER['REQUEST_URI'];
$request_details = explode( '/', $request_uri );

if ( $request_details[2] == 'idx' ) {
	$mls_number = $request_details[5];
	$status     = $request_details[4];
	$market     = $request_details[3];
	if ( $status === 'sold' ) {
		$sold_single = true;
	} else {
		$sold_single = false;
	}
	$listing_data->listing_data_from_IDX( $mls_number, $sold_single, $market );
} else {
	$listing_data->listing_data_from_WP();
}
?>
    <div class="single-listing-wrap">

		<?php if ( $listing_data->combined_address ) {
			$address = $listing_data->combined_address;
		} elseif ( $listing_data->city_state_zip ) {
			$address = $listing_data->city_state_zip;
		} else {
			$address = '';
		} ?>

        <div class="single-listing-details">
			<?php if ( $listing_data->title ) { ?>
                <h2 class="listing-title"><?php echo $listing_data->title; ?></h2>
			<?php } else { ?>
                <h2 class="listing-title address"><?php echo $address; ?></h2>
			<?php } ?>

			<?php if ( $listing_data->title ) { ?>
                <div class="address-details">
					<?php echo $address; ?>
                </div>
			<?php } ?>

			<?php if ( $listing_data->is_for_sale ) { ?>
				<?php if ( $listing_data->price ) { ?>
                    <div class="listing-price"><?php echo '$' . number_format( $listing_data->price ); ?></div>
				<?php } else { ?>
                    <div class="listing-price no-price">No Price Given</div>
				<?php } ?>
			<?php } elseif ( $listing_data->is_for_lease ) { ?>
				<?php if ( $listing_data->rent ) { ?>
                    <div class="listing-price"><?php echo '$' . number_format( $listing_data->rent ); ?>
                        <span>/ month</span></div>
				<?php } else { ?>
                    <div class="listing-price no-price">No Rent Given</div>
				<?php } ?>
			<?php } ?>
            <div class="save-share-links">
				<?php if ( is_user_logged_in() ) {
					if ( $listing_data->favorite_listing == true ) {
						$saved_class = 'saved';
					} else {
						$saved_class = '';
					}
					/**
					 * @todo here we want to replace the 'listing-id' with 'listing-title' and 'listing-url'
					 */
					?>
                    <a href="#" user_id="<?php echo MP_LOGGED_IN_ID; ?>"
                       listing_id="<?php echo $listing_data->listing_id; ?>"
                       listing_address="<?php echo $listing_data->combined_address; ?>"
                       listing_url="<?php echo $listing_data->listing_url; ?>"
                       class="save-link <?php echo $saved_class; ?>"><i class="fa fa-heart"></i> Save<span>d</span><i
                                class="fa fa-refresh fa-spin" aria-hidden="true"></i></a>
				<?php } else { ?>
                    <a href="#" data-open="login-modal" class="save-link"><i class="fa fa-heart"></i> Save</a>
				<?php } ?>
                <a class="a2a_dd addtoany_share_save" href="#"><i class="fa fa-share"></i> Share</a>
				<?php if ( $listing_data->author ) { ?>
                    <a href="<?php echo site_url(); ?>/profile/<?php echo $listing_data->author; ?>"
                       class="profile-link"><i
                                class="fa fa-user"></i>
                        Submitter Profile</a>
					<?php
					/**
					 * Add listing data author image here..
					 */
					if ( $author_id = $listing_data->author_id ) {
						if ( $company_logo = get_field( 'company_logo', 'user_' . $author_id ) ) { ?>
                            <span class="company-logo-wrap">
                            <img src="<?php echo $company_logo; ?>"/>
                           </span>
						<?php }
					}
					?>
				<?php } ?>
            </div>

            <div class="description">
                <h5 class="section-title">Listing Description</h5>
                <p><?php echo $listing_data->description; ?></p>
            </div>

            <div class="details-wrap-outer">
                <h5 class="section-title">Listing Information</h5>
                <div class="details-wrap">
					<?php if ( $listing_data->mls ) { ?>
                        <div class="detail">
                            <div class="detail-label">MLS Number</div>
                            <div class="detail-content"><?php echo $listing_data->mls; ?></div>
                        </div>
					<?php }
					if ( $listing_data->apn_parcel_id ) { ?>
                        <div class="detail">
                            <div class="detail-label">APN/Parcel ID</div>
                            <div class="detail-content"><?php echo $listing_data->apn_parcel_id; ?></div>
                        </div>
					<?php }
					if ( $listing_data->type ) { ?>
                        <div class="detail">
                            <div class="detail-label">Type</div>
                            <div class="detail-content"><?php echo $listing_data->type; ?></div>
                        </div>
					<?php }
					if ( $listing_data->sub_type ) { ?>
                        <div class="detail">
                            <div class="detail-label">Sub Type</div>
                            <div class="detail-content"><?php echo ucfirst( $listing_data->sub_type ); ?></div>
                        </div>
					<?php }
					if ( $listing_data->is_for_lease && $listing_data->rate_sf_month ) { ?>
                        <div class="detail">
                            <div class="detail-label">Rate/SF/Month</div>
                            <div class="detail-content"><?php echo '$' . number_format( $listing_data->rate_sf_month, 2 ); ?></div>
                        </div>
					<?php }
					if ( $listing_data->building_size ) { ?>
                        <div class="detail">
                            <div class="detail-label">Building Size</div>
                            <div class="detail-content"><?php echo number_format( $listing_data->building_size ); ?>
                                sqft
                            </div>
                        </div>
					<?php }
					if ( $listing_data->space_available ) { ?>
                        <div class="detail">
                            <div class="detail-label">Space Available</div>
                            <div class="detail-content"><?php echo number_format( $listing_data->space_available ); ?> sqft
                            </div>
                        </div>
					<?php }
					if ( $listing_data->lot_size ) { ?>
                        <div class="detail">
                            <div class="detail-label">Lot Size</div>
                            <div class="detail-content"><?php echo number_format( $listing_data->lot_size ); ?> sqft
                            </div>
                        </div>
					<?php }
					if ( $listing_data->price_per_sqft ) { ?>
                        <div class="detail">
                            <div class="detail-label">Price / SQFT</div>
                            <div class="detail-content">
                                $<?php echo number_format( $listing_data->price_per_sqft ); ?></div>
                        </div>
					<?php }
					if ( $listing_data->number_of_units ) { ?>
                        <div class="detail">
                            <div class="detail-label">No Units</div>
                            <div class="detail-content"><?php echo $listing_data->number_of_units; ?></div>
                        </div>
					<?php }
					if ( $listing_data->price_per_unit ) { ?>
                        <div class="detail">
                            <div class="detail-label">Price / Unit</div>
                            <div class="detail-content">
                                $<?php echo number_format( $listing_data->price_per_unit ); ?></div>
                        </div>
					<?php }
					if ( $gross_income = $listing_data->gross_operating_income ) { ?>
                        <div class="detail">
                            <div class="detail-label">Gross Income</div>
                            <div class="detail-content">
                                $<?php echo number_format( $gross_income ); ?></div>
                        </div>
					<?php }
					if ( $operating_expenses = $listing_data->operating_expenses ) { ?>
                        <div class="detail">
                            <div class="detail-label">Expenses</div>
                            <div class="detail-content">
                                $<?php echo $operating_expenses; ?></div>
                        </div>
					<?php }
					if ( $income = $listing_data->net_operating_income ) { ?>
                        <div class="detail">
                            <div class="detail-label">Net Income</div>
                            <div class="detail-content">
                                $<?php echo number_format( $income ); ?></div>
                        </div>
					<?php }
					if ( $rent_multiplier = $listing_data->gross_rent_multiplier ) { ?>
                        <div class="detail">
                            <div class="detail-label">Rent Multiplier</div>
                            <div class="detail-content">
								<?php echo $rent_multiplier; ?></div>
                        </div>
					<?php }
					if ( $listing_data->cap_rate ) { ?>
                        <div class="detail">
                            <div class="detail-label">Cap Rate</div>
                            <div class="detail-content"><?php echo number_format( $listing_data->cap_rate, 2 ); ?>%
                            </div>
                        </div>
					<?php }
					if ( $listing_data->listing_date ) { ?>
                        <div class="detail">
                            <div class="detail-label">Listing Date</div>
                            <div class="detail-content"><?php echo $listing_data->listing_date; ?></div>
                        </div>
					<?php }
					if ( $listing_data->sale_date ) { ?>
                        <div class="detail">
                            <div class="detail-label">Sale Date</div>
                            <div class="detail-content"><?php echo $listing_data->sale_date; ?></div>
                        </div>
					<?php }
					if ( $listing_data->days_on_market ) { ?>
                        <div class="detail">
                            <div class="detail-label">Days Active</div>
                            <div class="detail-content"><?php echo $listing_data->days_on_market; ?></div>
                        </div>
					<?php }
					if ( $listing_data->last_updated ) { ?>
                        <div class="detail">
                            <div class="detail-label">Last Updated</div>
                            <div class="detail-content"><?php echo $listing_data->last_updated; ?></div>
                        </div>
					<?php } ?>
                </div>
            </div>
			<?php
			if ( $listing_data->is_for_sale ) {
				if ( $unit_mix = $listing_data->unit_mix ) {
					?>
                    <div class="unit-mix-outer">
                        <h5 class="section-title">Unit Mix</h5>
						<?php foreach ( $unit_mix as $unit ) { ?>
                            <div class="unit-mix-row">
								<?php if ( isset( $unit['unit_name_plan'] ) ) { ?>
                                    <div class="unit-mix-item unit-mix-plan">
                                        <label>Unit Name / Plan</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['unit_name_plan']; ?>
                                        </div>
                                    </div>
								<?php }
								if ( isset( $unit['number_of_units'] ) ) { ?>
                                    <div class="unit-mix-item unit-mix-units">
                                        <label>Units</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['number_of_units']; ?>
                                        </div>
                                    </div>
								<?php }
								if ( isset( $unit['number_of_beds'] ) ) { ?>
                                    <div class="unit-mix-item unit-mix-beds">
                                        <label>Beds</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['number_of_beds']; ?>
                                        </div>
                                    </div>
								<?php }
								if ( isset( $unit['number_of_baths'] ) ) { ?>
                                    <div class="unit-mix-item unit-mix-baths">
                                        <label>Baths</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['number_of_baths']; ?>
                                        </div>
                                    </div>
								<?php }
								if ( isset( $unit['average_sq_ft'] ) ) { ?>
                                    <div class="unit-mix-item unit-mix-sqft">
                                        <label>Average Sqft</label>
                                        <div class="unit-mix-value">
											<?php echo number_format( $unit['average_sq_ft'] ); ?>
                                        </div>
                                    </div>
								<?php }
								if ( isset( $unit['average_rent'] ) ) { ?>
                                    <div class="unit-mix-item unit-mix-average-rent">
                                        <label>Average Rent</label>
                                        <div class="unit-mix-value">
                                            $<?php echo number_format( $unit['average_rent'] ); ?>
                                        </div>
                                    </div>
								<?php } ?>
                            </div>
						<?php } ?>
                    </div>
				<?php }
			} elseif ( $listing_data->is_for_lease ) {
				if ( $unit_mix = $listing_data->rental_unit_mix ) { ?>
                    <div class="unit-mix-outer">
                        <h5 class="section-title">Rental Unit Mix</h5>
						<?php foreach ( $unit_mix as $unit ) { ?>
                            <div class="unit-mix-row">
								<?php if ( isset( $unit['unit_number'] ) ) { ?>
                                    <div class="unit-mix-item unit-mix-unit-number">
                                        <label>Unit Number</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['unit_number']; ?>
                                        </div>
                                    </div>
								<?php }
								if ( isset( $unit['monthly_asking_rent'] ) ) { ?>
                                    <div class="unit-mix-item unit-mix-asking-rent">
                                        <label>Monthly Rent</label>
                                        <div class="unit-mix-value">
											<?php echo '$' . number_format( $unit['monthly_asking_rent'] ); ?>
                                        </div>
                                    </div>
								<?php }
								if ( isset( $unit['unit_size_sf'] ) ) { ?>
                                    <div class="unit-mix-item unit-mix-size-sf">
                                        <label>Unit Size (SF)</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['unit_size_sf']; ?>
                                        </div>
                                    </div>
								<?php } ?>
                            </div>
						<?php } ?>
                    </div>
				<?php }
			} ?>
			<?php if ( ( $file_attachments = $listing_data->file_attachments ) && $file_attachments[0]['file_attachment'] ) { ?>
                <div class="file-attachments-wrap">
                    <h5 class="section-title">File Attachments</h5>
					<?php foreach ( $file_attachments as $file ) { ?>
                        <div class="file-attachment">
                            <a href="<?php echo $file['file_attachment']['url']; ?>"><?php echo $file['file_attachment']['title']; ?></a>
                        </div>
					<?php } ?>
                </div>
			<?php } ?>
            <div class="listing-agent-attribution-wrap">
				<?php if ( $listing_agent_name = $listing_data->listing_agent_name ) { ?>
                    <div class="listing-agent-attribution">
                        <div class="title-block">Listing Provided By</div>
                        <div class="listing-agent-attribution-inner-wrap">
                            <div class="listing-agent-item agent-name">
								<?php echo $listing_agent_name; ?>
                            </div>
							<?php if ( $listing_office_name = $listing_data->listing_office_name ) { ?>
                                <div class="listing-agent-item office-name">
									<?php echo $listing_office_name; ?>
                                </div>
							<?php }
							if ( $listing_agent_id = $listing_data->listing_agent_id ) { ?>
                                <div class="listing-agent-item">
                                    BRE# <?php echo $listing_agent_id; ?>
                                </div>
							<?php } ?>
                        </div>
                    </div>
				<?php } ?>
            </div>
        </div>
        <div class="single-listing-right-side-wrap">
			<?php
			/**
			 * Make sure that any images exist before outputting anything.
			 */
			if ( isset( $listing_data->image_gallery[0] ) ) {
				$count_class = 'number-images-' . count( $listing_data->image_gallery );
				?>
                <div class="all-images-outer-wrap <?php echo $count_class; ?>">
                    <div class="image-wrap-outer wrap-1">
						<?php if ( $img_src = $listing_data->image_gallery[0]['image'] ) { ?>
                            <a rel="lightbox"
                               href="<?php echo $listing_data->image_gallery[0]['link']; ?>"
                               class="image-container-wrap image-1"
                               style="background-image: url(<?php echo $img_src; ?>);">
                            </a>
						<?php } ?>
                    </div>
					<?php if ( isset( $listing_data->image_gallery[1] ) ) { ?>
                        <div class="image-wrap-outer wrap-2">
							<?php if ( $img_src = $listing_data->image_gallery[1]['image'] ) { ?>
                                <a rel="lightbox"
                                   href="<?php echo $listing_data->image_gallery[1]['link']; ?>"
                                   class="image-container-wrap image-2"
                                   style="background-image: url(<?php echo $img_src; ?>);">
                                </a>
							<?php }
							if ( isset( $listing_data->image_gallery[2] ) ) {
								if ( $img_src = $listing_data->image_gallery[2]['image'] ) { ?>
                                    <a rel="lightbox"
                                       href="<?php echo $listing_data->image_gallery[2]['link']; ?>"
                                       class="image-container-wrap image-3"
                                       style="background-image: url(<?php echo $img_src; ?>);">
                                    </a>
								<?php }
							} ?>
                        </div>
					<?php } ?>
					<?php if ( isset( $listing_data->image_gallery[3] ) ) { ?>
                        <div class="image-wrap-outer wrap-3">
							<?php if ( $img_src = $listing_data->image_gallery[3]['image'] ) { ?>
                                <a rel="lightbox"
                                   href="<?php echo $listing_data->image_gallery[3]['link']; ?>"
                                   class="image-container-wrap image-4"
                                   style="background-image: url(<?php echo $img_src; ?>);">
                                </a>
							<?php }
							if ( isset( $listing_data->image_gallery[4] ) ) {
								if ( $img_src = $listing_data->image_gallery[4]['image'] ) { ?>
                                    <a rel="lightbox"
                                       href="<?php echo $listing_data->image_gallery[4]['link']; ?>"
                                       class="image-container-wrap image-5"
                                       style="background-image: url(<?php echo $img_src; ?>);">
                                    </a>
								<?php }
							}
							if ( isset( $listing_data->image_gallery[5] ) ) {
								if ( $img_src = $listing_data->image_gallery[5]['image'] ) { ?>
                                    <a rel="lightbox"
                                       href="<?php echo $listing_data->image_gallery[5]['link']; ?>"
                                       class="image-container-wrap image-6"
                                       style="background-image: url(<?php echo $img_src; ?>);">
                                    </a>
								<?php }
							}
							if ( isset( $listing_data->image_gallery[6] ) ) {
								if ( $img_src = $listing_data->image_gallery[6]['image'] ) { ?>
                                    <a rel="lightbox"
                                       href="<?php echo $listing_data->image_gallery[6]['link']; ?>"
                                       class="image-container-wrap image-7"
                                       style="background-image: url(<?php echo $img_src; ?>);">
                                    </a>
								<?php }
							} ?>
                        </div>
					<?php } ?>
                </div>
			<?php } ?>

            <div class="gallery-hidden-images">
				<?php
				unset( $listing_data->image_gallery[0] );
				unset( $listing_data->image_gallery[1] );
				unset( $listing_data->image_gallery[2] );
				unset( $listing_data->image_gallery[3] );
				unset( $listing_data->image_gallery[4] );
				unset( $listing_data->image_gallery[5] );
				unset( $listing_data->image_gallery[6] );
				if ( $listing_data->image_gallery ) {
					foreach ( $listing_data->image_gallery as $hidden_image ) { ?>
                        <a rel="lightbox"
                           href="<?php echo $hidden_image['link']; ?>">
                            <img src="<?php echo $hidden_image['image']; ?>"/>
                        </a>
					<?php }
				} ?>
            </div>

			<?php
			$form_modal = new mp_output_modal_generic(
				'contact-agent-modal',
				'Thank You',
				'An email has been sent. Someone will be in touch soon!'
			);
			$form_modal->output_modal(); ?>

            <div class="listing-agent-form-wrap">
                <h3>Contact Agent</h3>
                <div class="add-listing-validation-callout callout warning">Please Complete All Required Fields.</div>
                <form method="post">
                    <input class='name' type="text" name="your-name" placeholder="Your Name (required)"/>
                    <input class='phone' type="number" name="your-phone" placeholder="Phone"/>
                    <input class='email' type="email" name="your-email" placeholder="Email (required)"/>
                    <textarea class='comment'
                              ame="listing-comment">I am interested in <?php echo $address; ?></textarea>
                    <!-- @todo conditional based on email and name existing? -->
					<?php
					$default_class = 'one-link';
					if ( $listing_data->author_name && $listing_data->author_email ) {
						$default_class = '';
						?>
                        <div class="agent-choice-wrap">
                            <div class="agent-radio">
                                <i class="fa fa-circle-o" aria-hidden="true"></i>
                            </div>
                            <div class="agent-choice">
                                <div class="avatar-wrap">
									<?php
									$headshot_field = get_field(
										'headshot',
										'user_' . $listing_data->author_id
									);
									if ( $headshot_field ) {
										$headshot = $headshot_field['sizes']['thumbnail']; ?>
                                        <img src="<?php echo $headshot; ?>"/>
									<?php } else { ?>
                                        <i class="fa fa-user"></i>
									<?php } ?>
                                </div>
                                <div class="details-wrap">
                                    <div class="agent-name"><?php echo $listing_data->author_name; ?></div>
                                    <div class="broker-name">Listing Agent</div>
                                    <div class="agent-email"><?php echo $listing_data->author_email; ?></div>
                                </div>
                            </div>
                        </div>
					<?php } ?>
                    <div class="agent-choice-wrap <?php echo $default_class; ?>">
                        <div class="agent-radio">
                            <i class="fa fa-circle-o" aria-hidden="true"></i>
                        </div>
                        <div class="agent-choice">
                            <div class="avatar-wrap">
                                <div class="marketpier-fav-logo">MP</div>
                            </div>
                            <div class="details-wrap">
                                <div class="agent-name marketpier">MarketPier</div>
                                <div class="broker-name">Buyer Agent</div>
								<?php $admin_email = get_option( 'admin_email' ); ?>
                                <div class="agent-email"><?php echo $admin_email; ?></div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="agent_email" name="agent_email" value="<?php echo $admin_email; ?>"/>
                    <input type="submit" class="submit" name="Contact Agent" value="Contact Agent"/>
                </form>
            </div>
        </div>

        <div class="google-map-wrapper">
			<?php
			if ( ( $listing_data->lat && $listing_data->long ) || $listing_data->combined_address ) {
				$google_map = new lv_google_map(
					$listing_data->lat,
					$listing_data->long,
					$listing_data->title,
					$listing_data->combined_address
				);
				$google_map->output_map();
			}
			?>
        </div>
    </div>

<?php if ( $listing_market = $listing_data->market ) {
	$disclaimer = get_disclaimer( $listing_market ); ?>
    <div class="disclaimer-wrapper"><?php echo $disclaimer; ?></div>
<?php }

get_footer();
