<?php
use Ramphor\User\TemplateLoader;

function ramphor_login_url() {
}

function ramphor_user_profile_asset_url($path = '') {
	$baseUrl = str_replace(
		ABSPATH,
		home_url('/'),
		RAMPHOR_USER_PROFILE_ROOT
	);

	return sprintf('%s/assets/%s', $baseUrl, $path);
}

function ramphor_load_modal_login($args) {
	$args = wp_parse_args( $args, array(
		'style' => 'modal'
	) );
	$template = '';
	if ($args['style'] === 'modal') {
		$template = 'login-modal';
	}
	ramphor_user_profile_load_template($template, [
	]);
}

function ramphor_user_profile_load_template($templates, $data = [], $templateDirPath = null) {
	$loader = TemplateLoader::instance($templateDirPath);
	$template = $loader->searchTemplate($templates);
	if (!empty($template)) {
		extract($data);
		require $template;
	}
}
