<div class="profile-avatar">
    <div class="avartar">
        <?php echo get_avatar($current_user->ID, 150); ?>
    </div>
    <div class="layout__secondary">
        <h2 class="profile-display-name"><?php echo $current_user->display_name; ?></h2>
        <div class="secondary-use">
            @<?php echo $current_user->user_login; ?>
        </div>
    </div>
</div>
