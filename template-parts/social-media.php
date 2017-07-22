<?php
$social_media = get_field( 'social_media', 'option' );

foreach ( $social_media as $social ) { ?>
    <a href="<?php echo $social['social_media_url']; ?>" target="_blank">
        <i class="fa <?php echo $social['social_media_icon']; ?>"></i>
    </a>
<?php }