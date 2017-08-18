<?php
$user = wp_get_current_user();
$username = $user->user_login;
?>
<div class="logged-in-user-sidebar-wrap">

    <a href="<?php echo site_url(); ?>/your-profile" class="sidebar-option update-profile">
        <span>Update Your Profile</span>
        <i class="fa fa-chevron-right"></i>
    </a>
    <a href="<?php echo site_url(); ?>/author/<?php echo $username; ?>" class="sidebar-option view-profile">
        <span>View Your Profile</span>
        <i class="fa fa-chevron-right"></i>
    </a>
    <a href="<?php echo site_url(); ?>/add-listing" class="sidebar-option add-listing">
        <span>Add a Listing</span>
        <i class="fa fa-chevron-right"></i>
    </a>
    <a href="<?php echo site_url(); ?>/your-listings" class="sidebar-option your-listings">
        <span>Your Listings</span>
        <i class="fa fa-chevron-right"></i>
    </a>
    <a href="<?php echo site_url(); ?>" class="sidebar-option">
        <span>MarketPier Home</span>
        <i class="fa fa-chevron-right"></i>
    </a>
    <a href="<?php echo wp_logout_url( site_url() ); ?>" class="sidebar-option">
        <span>Log Out</span>
        <i class="fa fa-chevron-right"></i>
    </a>

</div>