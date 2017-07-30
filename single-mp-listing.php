<?php
/**
 * The template for displaying all single listing posts
 *
 * @package MarketPier
 */
get_header();

require_once( 'inc/listing_data.php' );
$listing_data = new listing_data();
$listing_data->listing_data_from_WP();
?>
    <div class="single-listing-wrap">
        <div class="single-listing-details"><h2 class="listing-title"><?php echo $listing_data->title; ?></h2>

            <div class="address-details"><?php echo $listing_data->city_state_zip; ?></div>

            <div class="listing-price"><?php echo '$' . number_format( $listing_data->price ); ?></div>

            <div class="apn-parcel-id">
                <div class="parcel-label">APN/Parcel ID</div>
                <div class="number"><?php echo $listing_data->apn_parcel_id; ?></div>
            </div>
            <div class="save-link"><a href="#"><i class="fa fa-heart"></i> Save</a></div>

            <div class="description"><h5>Description</h5>
                <p><?php echo $listing_data->description; ?></p></div>

            <div class="misc-details-wrap">

                <div class="misc-details">
                    <div class="icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="details">
                        <div class="detail">
                            <div class="detail-label">Type</div>
                            <div class="detail-content"><?php echo $listing_data->type; ?></div>
                        </div>
                        <div class="detail">
                            <div class="detail-label">Sub Type</div>
                            <div class="detail-content"><?php echo $listing_data->sub_type; ?></div>
                        </div>
                    </div>
                </div>

                <div class="misc-details">
                    <div class="icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <div class="details">
                        <div class="detail">
                            <div class="detail-label">Building Size</div>
                            <div class="detail-content"><?php echo number_format( $listing_data->building_size ); ?> sqft</div>
                        </div>
                        <div class="detail">
                            <div class="detail-label">Lot Size</div>
                            <div class="detail-content"><?php echo number_format( $listing_data->lot_size ); ?> sqft</div>
                        </div>
                        <div class="detail">
                            <div class="detail-label">No Units</div>
                            <div class="detail-content"><?php echo $listing_data->number_of_units; ?></div>
                        </div>
                    </div>
                </div>

                <div class="misc-details">
                    <div class="icon">
                        <i class="fa fa-dollar"></i>
                    </div>
                    <div class="details">
                        <div class="detail">
                            <div class="detail-label">Net Income</div>
                            <div class="detail-content">$<?php echo number_format( $listing_data->net_operating_income ); ?></div>
                        </div>
                        <div class="detail">
                            <div class="detail-label">Cap Rate</div>
                            <div class="detail-content"><?php echo number_format( $listing_data->cap_rate, 2 ); ?>%</div>
                        </div>
						<?php if ( $listing_data->price_per_unit ) { ?>
                            <div class="detail">
                                <div class="detail-label">Price / Unit</div>
                                <div class="detail-content">$<?php echo number_format( $listing_data->price_per_unit ); ?></div>
                            </div>
						<?php } ?>
                    </div>
                </div>

                <div class="misc-details">
                    <div class="icon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <div class="details">
                        <div class="detail">
                            <div class="detail-label">Listing Date</div>
                            <div class="detail-content"><?php echo $listing_data->listing_date; ?></div>
                        </div>
                        <div class="detail">
                            <div class="detail-label">Days Active</div>
                            <div class="detail-content"><?php echo $listing_data->days_on_market; ?></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="single-listing-gallery">
            <div class="image-wrap image-wrap-1">
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[0]['sizes']['large']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[0]['sizes']['listing-gallery']; ?>"/></a></div>
            </div>
            <div class="image-wrap image-wrap-2">
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[1]['sizes']['large']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[1]['sizes']['listing-gallery']; ?>"/></a></div>
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[2]['sizes']['large']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[2]['sizes']['listing-gallery']; ?>"/></a></div>
            </div>
            <div class="image-wrap image-wrap-3">
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[3]['sizes']['large']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[3]['sizes']['listing-gallery']; ?>"/></a></div>
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[4]['sizes']['large']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[4]['sizes']['listing-gallery']; ?>"/></a></div>
            </div>
            <div class="image-wrap image-wrap-4">
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[5]['sizes']['large']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[5]['sizes']['listing-gallery']; ?>"/></a></div>
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[6]['sizes']['large']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[6]['sizes']['listing-gallery']; ?>"/></a></div>
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[7]['sizes']['large']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[7]['sizes']['listing-gallery']; ?>"/></a></div>
                <div class="single-gallery-image"><a rel="lightbox"
                                                     href="<?php echo $listing_data->image_gallery[8]['sizes']['large']; ?>"><img
                                src="<?php echo $listing_data->image_gallery[8]['sizes']['listing-gallery']; ?>"/></a></div>
            </div>
        </div>
    </div>
<?php
get_footer();
