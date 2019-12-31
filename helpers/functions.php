<?php
use Ramphor\User\TemplateLoader;
use Ramphor\User\Exceptions\ActionException;

function ramphor_login_url()
{
}

function ramphor_user_profile_asset_url($path = '')
{
    $baseUrl = str_replace(
        ABSPATH,
        home_url('/'),
        RAMPHOR_USER_PROFILE_ROOT
    );

    return sprintf('%s/assets/%s', $baseUrl, $path);
}

function ramphor_load_modal_login($args)
{
    $args = wp_parse_args($args, array(
        'style' => 'modal'
    ));
    $template = '';
    if ($args['style'] === 'modal') {
        $template = 'login-modal';
    }
    ramphor_user_profile_load_template($template, [
    ]);
}

function ramphor_user_profile_load_template($templates, $data = [], $templateDirPath = null)
{
    $loader = TemplateLoader::instance($templateDirPath);
    $template = $loader->searchTemplate($templates);
    if (!empty($template)) {
        extract($data);
        require $template;
    }
}


function ramphor_user_profile_url($action, $type = '')
{
    if (!in_array($action, array('register', 'login'))) {
        throw new ActionException('The action is not support by Ramphor User Profile');
    }

    if (get_option('permalink_structure', false)) {
        $path = sprintf('auth/%s/%s', $action, $type);
        return home_url($path);
    }

    /**
     * If WordPress don't enable Rewrite URL
     * Return the URL with query format
     */
    $params = [
        'ramphor' => 'auth',
        'action' => $action,
        'type' => $type,
    ];
    return home_url('index.php?' . http_build_query($params));
}
