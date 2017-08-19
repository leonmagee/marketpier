<?php
$user = wp_get_current_user();
$username = $user->user_login;
?>
<div class="logged-in-user-sidebar-wrap">
    <a href="<?php echo site_url(); ?>/your-profile" class="sidebar-option update-profile">
        <i class="fa fa-cog" aria-hidden="true"></i>
        <span>Account Settings</span>
    </a>
    <a href="<?php echo site_url(); ?>/your-profile" class="sidebar-option update-profile">
        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
        <span>Update Profile</span>
    </a>
    <a href="<?php echo site_url(); ?>/author/<?php echo $username; ?>" class="sidebar-option view-profile">
        <i class="fa fa-user"></i>
        <span>View Your Profile</span>
    </a>
    <a href="<?php echo site_url(); ?>/add-listing" class="sidebar-option add-listing">
        <i class="fa fa-plus-square" aria-hidden="true"></i>
        <span>Add a Listing</span>
    </a>
    <a href="<?php echo site_url(); ?>/your-listings" class="sidebar-option your-listings">
        <i class="fa fa-list" aria-hidden="true"></i>
        <span>Your Listings</span>
    </a>
    <a href="<?php echo site_url(); ?>" class="sidebar-option">
        <i class="fa fa-home" aria-hidden="true"></i>
        <span>MarketPier Home</span>
    </a>
    <a href="<?php echo wp_logout_url( site_url() ); ?>" class="sidebar-option">
        <i class="fa fa-sign-out" aria-hidden="true"></i>
        <span>Log Out</span>
    </a>

</div>