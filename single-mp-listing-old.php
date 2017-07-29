<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package MarketPier
 */

get_header();

require_once( 'inc/listing-custom-fields.php' );
//var_dump( $image_gallery );

$title = get_the_title();
?>

    <listing class="single-listing-wrap">
        <div class="single-listing-details"><h2 class="listing-title"><?php echo $title; ?></h2>
            listing details
        </div>
        <div class="single-listing-gallery">

            <div class="image-wrap-1">
                <div class="single-gallery-image image-1"><img src="<?php echo $image_gallery[0]['sizes']['listing-gallery']; ?>"/></div>
            </div>
           <div class="image-wrap-2">
               <div class="single-gallery-image image-1"><img src="<?php echo $image_gallery[1]['sizes']['listing-gallery']; ?>"/></div>
               <div class="single-gallery-image image-1"><img src="<?php echo $image_gallery[2]['sizes']['listing-gallery']; ?>"/></div>
           </div>


			<?php
			$counter = 1;
			foreach ( $image_gallery as $image ) {
				$count_class = 'image-' . $counter;
				?>
                <div class="single-gallery-image <?php echo $count_class; ?>"><img
                            src="<?php echo $image['sizes']['listing-gallery']; ?>"/></div>
				<?php
				++ $counter;
			} ?>
        </div>
    </listing>

<?php
get_footer();
