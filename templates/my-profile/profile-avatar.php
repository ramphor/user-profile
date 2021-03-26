<div class="profile-avatar">
    <div class="avartar">
        <?php echo get_avatar($current_user->ID, 150); ?>
    </div>
    <div class="layout__secondary">
        <h2 class="profile-display-name"><?php echo $current_user->display_name; ?></h2>
        <div class="secondary-use">
            <a href="<?php echo get_author_posts_url($current_user->ID); ?>" title="<?php echo $current_user->display_name; ?>">
                @<?php echo $current_user->user_login; ?>
            </a>
        </div>
    </div>
</div>
