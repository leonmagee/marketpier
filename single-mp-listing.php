<?php
/**
 * The template for displaying all single listing posts
 *
 * @package MarketPier
 */
get_header();

require_once( 'inc/lv_google_map.php' );
require_once( 'inc/listing_data.php' );
$listing_data = new listing_data();
$listing_data->listing_data_from_WP();
?>
    <div class="single-listing-wrap">
        <div class="single-listing-details"><h2 class="listing-title"><?php echo $listing_data->title; ?></h2>

            <div class="address-details">
				<?php if ( $address = $listing_data->combined_address ) {
					echo $address;
				} elseif ( $address = $listing_data->city_state_zip ) {
					echo $address;
				} ?>
            </div>

            <div class="listing-price"><?php echo '$' . number_format( $listing_data->price ); ?></div>

            <div class="save-share-links">
                <a href="#"><i class="fa fa-heart"></i> Save</a>
                <a href="#"><i class="fa fa-share"></i> Share</a>
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
					<?php } ?>
                </div>
            </div>
			<?php
			if ( $unit_mix = $listing_data->unit_mix ) {
				//if ( $unit_mix = get_field( 'unit_mix' ) ) {
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
			<?php } ?>
        </div>

        <div class="single-listing-gallery"><!-- @todo change the name of this class - holds more than images -->
            <div class="image-wrap image-wrap-1">
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[0]['link']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[0]['image']; ?>"/></a></div>
            </div>
            <div class="image-wrap image-wrap-2">
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[1]['link']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[1]['image']; ?>"/></a></div>
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[2]['link']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[2]['image']; ?>"/></a></div>
            </div>
            <div class="image-wrap image-wrap-4">
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[3]['link']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[3]['image']; ?>"/></a></div>
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[4]['link']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[4]['image']; ?>"/></a></div>
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[5]['link']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[5]['image']; ?>"/></a></div>
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[6]['link']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[6]['image']; ?>"/></a></div>
            </div>


            <div class="listing-agent-form-wrap">
                <h3>Contact Agent</h3>
                <form method="post">
                    <input class='name' type="text" name="your-name" placeholder="Your Name"/>
                    <input class='phone' type="number" name="your-phone" placeholder="Phone"/>
                    <input class='email' type="email" name="your-email" placeholder="Email"/>
                    <textarea name="listing-comment">I am interested in <?php echo $address; ?></textarea>
                    <div class="agent-choice-wrap">
                        <div class="agent-radio">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        </div>
                        <div class="agent-choice">
                            <div class="avatar-wrap">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="details-wrap">
                                <div class="agent-name">Desirae Sweeney</div>
                                <div class="broker-name">Listing Agent</div>
                            </div>
                        </div>
                    </div>
                    <div class="agent-choice-wrap">
                        <div class="agent-radio">
                            <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                        </div>
                        <div class="agent-choice">
                            <div class="avatar-wrap">
                                <div class="marketpier-fav-logo">MP</div>
                            </div>
                            <div class="details-wrap">
                                <div class="agent-name">Dan Haas</div>
                                <div class="broker-name">MarketPier Agent</div>
                            </div>
                        </div>
                    </div>
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
