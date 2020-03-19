<?php

function ramphor_the_user($user = null, $options = array())
{
    if (is_null($user)) {
        $user = wp_get_current_user();
    }
    $options = wp_parse_args($options, array(
        'show_avatar' => true,
        'show_name' => true,
    ));

    ramphor_user_profile_template(
        'user/item',
        compact('user', 'options'),
        $options['template_dir']
    );
}
