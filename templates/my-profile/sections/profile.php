<div class="section-header">
    <h2 class="section-header_text">
        <span><?php echo $heading_text; ?></span>
    </h2>
</div>
<div class="section-content profile__settings">
    <p class="section-description"><?php echo $description; ?></p>

    <div class="basic-info">
        <div class="edit-avatar">
            <div class="avatar-chooser">
                <div class="avatar">
                    <img src="<?php echo get_avatar_url($current_user_id, array('size' => 150)); ?>" alt="<?php echo $current_user->display_name; ?>">
                </div>
                <div class="overlay">
                    <div class="text">
                        <div class="icon"></div>
                        <?php echo esc_html(__('Click to change photo', 'ramphor_user_profile')); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="edit-name">
            <div class="edit-field first-name">
                <label class="field-label"><?php echo esc_html(__('First Name', 'ramphor_user_profile')); ?></label>
                <div class="input-wrap">
                    <input type="text" class="field-editing" name="first_name" value="<?php echo $current_user->first_name; ?>" />
                </div>
            </div>

            <div class="edit-field last-name">
                <label class="field-label"><?php echo esc_html(__('Last Name', 'ramphor_user_profile')); ?></label>
                <div class="input-wrap">
                    <input type="text" class="field-editing" name="last_name" value="<?php echo $current_user->last_name; ?>" />
                </div>
            </div>
        </div>
    </div>

    <div class="publish-display">
        <div class="edit-display-name">
            <div class="edit-field display-name">
                <label for="" class="field-label">
                    <?php echo esc_html(__('Public display name', 'ramphor_user_profile')); ?>
                </label>
                <div class="input-wrap">
                    <input type="text" class="field-editing" name="display_name" value="<?php echo $current_user->display_name; ?>" />
                </div>
            </div>
        </div>

        <div class="edit-biography">
            <div class="edit-field my-biography">
                <label for="" class="field-label">
                    <?php echo esc_html(__('About me', 'ramphor_user_profile')); ?>
                </label>
                <div class="input-wrap">
                    <textarea name="description" class="field-editing"><?php echo $current_user->description; ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
