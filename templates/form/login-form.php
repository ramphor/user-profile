<form name="<?php echo $form_id; ?>" id="<?php echo $form_id; ?>" action="<?php echo $form_action; ?>" method="post">
    <?php echo $login_form_top; ?>

    <div class="ramphor-field login-field login-username">
        <div class="field-icon"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 483.3 483.3" style="enable-background:new 0 0 483.3 483.3;" xml:space="preserve"><g><g><path d="M424.3,57.75H59.1c-32.6,0-59.1,26.5-59.1,59.1v249.6c0,32.6,26.5,59.1,59.1,59.1h365.1c32.6,0,59.1-26.5,59.1-59.1v-249.5C483.4,84.35,456.9,57.75,424.3,57.75z M456.4,366.45c0,17.7-14.4,32.1-32.1,32.1H59.1c-17.7,0-32.1-14.4-32.1-32.1v-249.5c0-17.7,14.4-32.1,32.1-32.1h365.1c17.7,0,32.1,14.4,32.1,32.1v249.5H456.4z"/><path d="M304.8,238.55l118.2-106c5.5-5,6-13.5,1-19.1c-5-5.5-13.5-6-19.1-1l-163,146.3l-31.8-28.4c-0.1-0.1-0.2-0.2-0.2-0.3c-0.7-0.7-1.4-1.3-2.2-1.9L78.3,112.35c-5.6-5-14.1-4.5-19.1,1.1c-5,5.6-4.5,14.1,1.1,19.1l119.6,106.9L60.8,350.95c-5.4,5.1-5.7,13.6-0.6,19.1c2.7,2.8,6.3,4.3,9.9,4.3c3.3,0,6.6-1.2,9.2-3.6l120.9-113.1l32.8,29.3c2.6,2.3,5.8,3.4,9,3.4c3.2,0,6.5-1.2,9-3.5l33.7-30.2l120.2,114.2c2.6,2.5,6,3.7,9.3,3.7c3.6,0,7.1-1.4,9.8-4.2c5.1-5.4,4.9-14-0.5-19.1L304.8,238.55z"/></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></div>
        <div class="input-wrap edit-field">
            <label for="<?php echo $id_username; ?>">
                <span><?php echo $label_username; ?></span>
            </label>
            <input type="text" name="log" id="<?php echo $id_username; ?>" class="input" value="<?php echo $value_username; ?>" size="20" />
        </div>
    </div>
    <div class="ramphor-field login-field login-password">
        <div class="field-icon"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 54 54" style="enable-background:new 0 0 54 54;" xml:space="preserve"><g><path d="M43,20.113V14.5C43,6.505,35.822,0,27,0S11,6.505,11,14.5v5.613c-3.401,0.586-6,3.55-6,7.117v19.542C5,50.757,8.243,54,12.229,54h29.542C45.757,54,49,50.757,49,46.771V27.229C49,23.663,46.401,20.699,43,20.113z M13,14.5C13,7.607,19.28,2,27,2s14,5.607,14,12.5V20H13V14.5z M47,46.771C47,49.654,44.654,52,41.771,52H12.229C9.346,52,7,49.654,7,46.771V27.229C7,24.346,9.346,22,12.229,22h29.542C44.654,22,47,24.346,47,27.229V46.771z"/><path d="M27,28c-2.206,0-4,1.794-4,4v6c0,2.206,1.794,4,4,4s4-1.794,4-4v-6C31,29.794,29.206,28,27,28z M29,38c0,1.103-0.897,2-2,2s-2-0.897-2-2v-6c0-1.103,0.897-2,2-2s2,0.897,2,2V38z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg></div>
        <div class="input-wrap edit-field">
            <label for="<?php echo $id_password; ?>">
                <span><?php echo $label_password; ?></span>
            </label>
            <input type="password" name="pwd" id="<?php echo $id_password; ?>" class="input" value="" size="20" />
        </div>
    </div>

    <?php echo $login_form_middle; ?>

    <?php if ($remember_password) : ?>
        <p class="login-remember">
            <label>
                <input name="rememberme" type="checkbox" id="<?php echo $id_remember; ?>" class="mgc mgc-success" value="forever"<?php echo $value_remember ? ' checked="checked"' : ''; ?>  />
                <?php echo $label_remember; ?>
            </label>
        </p>
    <?php endif; ?>
    <p class="login-submit">
        <button type="submit" name="wp-submit" id="<?php echo $id_submit; ?>" class="button button-primary" value="<?php echo $label_log_in; ?>"><?php echo $label_log_in; ?></button>
        <a href="javascript:MicroModal.close('modal-login');" class="button button-primary" data-custom-close="modal-login" data-micromodal-trigger="modal-register"><?php _e('Register'); ?></a>
        <input type="hidden" name="redirect_to" value="<?php echo $redirect_url; ?>" />
    </p>

    <?php echo $login_form_bottom; ?>
</form>
