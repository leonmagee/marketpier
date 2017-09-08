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
	$mls_number = $request_details[3];
	$listing_data->listing_data_from_IDX( $mls_number );
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
					?>
                    <a href="#" user_id="<?php echo MP_LOGGED_IN_ID; ?>"
                       listing_id="<?php echo $listing_data->listing_id; ?>"
                       class="save-link <?php echo $saved_class; ?>"><i class="fa fa-heart"></i> Save<span>d</span><i
                                class="fa fa-refresh fa-spin" aria-hidden="true"></i></a>
				<?php } else { ?>
                    <a href="#" data-open="login-modal" class="save-link"><i class="fa fa-heart"></i> Save</a>
				<?php } ?>
                <a href="#"><i class="fa fa-share"></i> Share</a>
				<?php if ( $listing_data->author ) { ?>
                    <a href="<?php echo site_url(); ?>/profile/<?php echo $listing_data->author; ?>"
                       class="profile-link"><i
                                class="fa fa-user"></i>
                        Submitter Profile</a>
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
                            <div class="detail-content"><?php echo $listing_data->sub_type; ?></div>
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
					if ( $listing_data->lot_size ) { ?>
                        <div class="detail">
                            <div class="detail-label">Lot Size</div>
                            <div class="detail-content"><?php echo number_format( $listing_data->lot_size ); ?> sqft
                            </div>
                        </div>
					<?php }
					if ( $listing_data->number_of_units ) { ?>
                        <div class="detail">
                            <div class="detail-label">No Units</div>
                            <div class="detail-content"><?php echo $listing_data->number_of_units; ?></div>
                        </div>
					<?php }
					if ( $income = $listing_data->net_operating_income ) { ?>
                        <div class="detail">
                            <div class="detail-label">Net Income</div>
                            <div class="detail-content">
                                $<?php echo number_format( $income ); ?></div>
                        </div>
					<?php }
					if ( $listing_data->cap_rate ) { ?>
                        <div class="detail">
                            <div class="detail-label">Cap Rate</div>
                            <div class="detail-content"><?php echo number_format( $listing_data->cap_rate, 2 ); ?>%
                            </div>
                        </div>
					<?php }
					if ( $listing_data->price_per_unit ) { ?>
                        <div class="detail">
                            <div class="detail-label">Price / Unit</div>
                            <div class="detail-content">
                                $<?php echo number_format( $listing_data->price_per_unit ); ?></div>
                        </div>
					<?php }
					if ( $listing_data->price_per_sqft ) { ?>
                        <div class="detail">
                            <div class="detail-label">Price / SQFT</div>
                            <div class="detail-content">
                                $<?php echo number_format( $listing_data->price_per_sqft ); ?></div>
                        </div>
					<?php }
					if ( $listing_data->listing_date ) { ?>
                        <div class="detail">
                            <div class="detail-label">Listing Date</div>
                            <div class="detail-content"><?php echo $listing_data->listing_date; ?></div>
                        </div>
					<?php }
					if ( $listing_data->days_on_market ) { ?>
                        <!-- @todo auto generate this number -->
                        <div class="detail">
                            <div class="detail-label">Days Active</div>
                            <div class="detail-content"><?php echo $listing_data->days_on_market; ?></div>
                        </div>
					<?php }
					if ( $listing_data->space_available ) { ?>
                        <!-- @todo auto generate this number -->
                        <div class="detail">
                            <div class="detail-label">Space Available</div>
                            <div class="detail-content"><?php echo number_format( $listing_data->space_available ); ?>
                                sqft
                            </div>
                        </div>
					<?php }
					if ( $listing_data->is_for_lease && $listing_data->rate_sf_month ) { ?>
                        <!-- @todo auto generate this number -->
                        <div class="detail">
                            <div class="detail-label">Rate/SF/Month</div>
                            <div class="detail-content"><?php echo '$' . number_format( $listing_data->rate_sf_month, 2 ); ?></div>
                        </div>
					<?php }
					?>
                </div>
            </div>
			<?php
			/**
			 * @todo - move unit mix to different file?
			 */
			if ( $listing_data->is_for_sale ) {
				if ( $unit_mix = $listing_data->unit_mix ) {
					?>
                    <div class="unit-mix-outer">
                        <h5 class="section-title">Unit Mix</h5>
						<?php foreach ( $unit_mix as $unit ) { ?>
                            <div class="unit-mix-row">
								<?php if ( $unit['unit_name_plan'] ) { ?>
                                    <div class="unit-mix-item unit-mix-plan">
                                        <label>Unit Name / Plan</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['unit_name_plan']; ?>
                                        </div>
                                    </div>
								<?php }
								if ( $unit['number_of_units'] ) { ?>
                                    <div class="unit-mix-item unit-mix-units">
                                        <label>Units</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['number_of_units']; ?>
                                        </div>
                                    </div>
								<?php }
								if ( $unit['number_of_beds'] ) { ?>
                                    <div class="unit-mix-item unit-mix-beds">
                                        <label>Beds</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['number_of_beds']; ?>
                                        </div>
                                    </div>
								<?php }
								if ( $unit['number_of_baths'] ) { ?>
                                    <div class="unit-mix-item unit-mix-baths">
                                        <label>Baths</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['number_of_baths']; ?>
                                        </div>
                                    </div>
								<?php }
								if ( $unit['average_sq_ft'] ) { ?>
                                    <div class="unit-mix-item unit-mix-sqft">
                                        <label>Average Sqft</label>
                                        <div class="unit-mix-value">
											<?php echo number_format( $unit['average_sq_ft'] ); ?>
                                        </div>
                                    </div>
								<?php }
								if ( $unit['average_rent'] ) { ?>
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
								<?php if ( $unit['unit_number'] ) { ?>
                                    <div class="unit-mix-item unit-mix-unit-number">
                                        <label>Unit Number</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['unit_number']; ?>
                                        </div>
                                    </div>
								<?php }
								if ( $unit['monthly_asking_rent'] ) { ?>
                                    <div class="unit-mix-item unit-mix-asking-rent">
                                        <label>Monthly Rent</label>
                                        <div class="unit-mix-value">
											<?php echo '$' . number_format( $unit['monthly_asking_rent'] ); ?>
                                        </div>
                                    </div>
								<?php }
								if ( $unit['unit_size_sf'] ) { ?>
                                    <div class="unit-mix-item unit-mix-size-sf">
                                        <label>Unit Size (SF)</label>
                                        <div class="unit-mix-value">
											<?php echo $unit['unit_size_sf']; ?>
                                        </div>
                                    </div>
								<?php }
								if ( $unit['lease_term'] ) { ?>
                                    <div class="unit-mix-item unit-mix-lease-term">
                                        <label>Lease Term</label>
                                        <div class="unit-mix-value">
											<?php echo ucfirst( $unit['lease_term'] ); ?>
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
			<?php if ( $listing_agent_name = $listing_data->listing_agent_name ) { ?>
                <div class="listing-agent-attribution">
                    <div class="listing-agent-name">
                        Listing Provided Courtesy of <?php echo $listing_agent_name; ?>
                    </div>
					<?php if ( $listing_agent_phone = $listing_data->listing_agent_phone ) { ?>
                        <div class="listing-agent-phone"><?php echo $listing_agent_phone; ?></div>
					<?php } ?>
					<?php if ( $listing_agent_id = $listing_data->listing_agent_id ) { ?>
                        <div class="listing-agent-id">#<?php echo $listing_agent_id; ?></div>
					<?php } ?>
                </div>
			<?php } ?>
        </div>
        <div class="single-listing-right-side-wrap">
			<?php
			/**
			 * Make sure that any images exist before outputting anything.
			 */
			if ( $listing_data->image_gallery[0] ) {
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
					<?php if ( $listing_data->image_gallery[1] ) { ?>
                        <div class="image-wrap-outer wrap-2">
							<?php if ( $img_src = $listing_data->image_gallery[1]['image'] ) { ?>
                                <a rel="lightbox"
                                   href="<?php echo $listing_data->image_gallery[1]['link']; ?>"
                                   class="image-container-wrap image-2"
                                   style="background-image: url(<?php echo $img_src; ?>);">
                                </a>
							<?php }
							if ( $img_src = $listing_data->image_gallery[2]['image'] ) { ?>
                                <a rel="lightbox"
                                   href="<?php echo $listing_data->image_gallery[2]['link']; ?>"
                                   class="image-container-wrap image-3"
                                   style="background-image: url(<?php echo $img_src; ?>);">
                                </a>
							<?php } ?>
                        </div>
					<?php } ?>
					<?php if ( $listing_data->image_gallery[3] ) { ?>
                        <div class="image-wrap-outer wrap-3">
							<?php if ( $img_src = $listing_data->image_gallery[3]['image'] ) { ?>
                                <a rel="lightbox"
                                   href="<?php echo $listing_data->image_gallery[3]['link']; ?>"
                                   class="image-container-wrap image-4"
                                   style="background-image: url(<?php echo $img_src; ?>);">
                                </a>
							<?php }
							if ( $img_src = $listing_data->image_gallery[4]['image'] ) { ?>
                                <a rel="lightbox"
                                   href="<?php echo $listing_data->image_gallery[4]['link']; ?>"
                                   class="image-container-wrap image-5"
                                   style="background-image: url(<?php echo $img_src; ?>);">
                                </a>
							<?php }
							if ( $img_src = $listing_data->image_gallery[5]['image'] ) { ?>
                                <a rel="lightbox"
                                   href="<?php echo $listing_data->image_gallery[5]['link']; ?>"
                                   class="image-container-wrap image-6"
                                   style="background-image: url(<?php echo $img_src; ?>);">
                                </a>
							<?php }
							if ( $img_src = $listing_data->image_gallery[6]['image'] ) { ?>
                                <a rel="lightbox"
                                   href="<?php echo $listing_data->image_gallery[6]['link']; ?>"
                                   class="image-container-wrap image-7"
                                   style="background-image: url(<?php echo $img_src; ?>);">
                                </a>
							<?php } ?>
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
                <form method="post">
                    <input class='name' type="text" name="your-name" placeholder="Your Name"/>
                    <input class='phone' type="number" name="your-phone" placeholder="Phone"/>
                    <input class='email' type="email" name="your-email" placeholder="Email"/>
                    <textarea class='comment'
                              ame="listing-comment">I am interested in <?php echo $address; ?></textarea>
                    <!-- @todo conditional based on email and name existing? -->
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
                    <div class="agent-choice-wrap">
                        <div class="agent-radio">
                            <i class="fa fa-circle-o" aria-hidden="true"></i>
                        </div>
                        <div class="agent-choice">
                            <div class="avatar-wrap">
                                <div class="marketpier-fav-logo">MP</div>
                            </div>
                            <div class="details-wrap">
                                <div class="agent-name">Dan Haas</div>
                                <div class="broker-name">MarketPier Agent</div>
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
<?php
get_footer();
