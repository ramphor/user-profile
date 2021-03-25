<div <?php echo $wrapper_attributes; ?>>
    <div class="my-profile-inner">

        <div class="my-profile-sidebar">
            <?php echo $profile_avatar; ?>

            <?php ramphor_user_profile_template('my-profile/menu', array(
                'menu_items' => $menu_items,
                'unique_id' => $unique_id,
                'current_feature' => $feature_name,
            )); ?>
        </div>

        <div class="profile-feature-content-wrapper">
            <?php do_action(
                "{$unique_id}_before_feature_content",
                $feature_name
            ); ?>

            <div class="feature-content">
                <?php echo $feature_content; ?>
            </div>

            <?php do_action(
                "{$unique_id}_after_feature_content",
                $feature_name
            ); ?>
        </div>

    </div>
</div>
