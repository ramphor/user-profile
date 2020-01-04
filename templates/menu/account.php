<div class="dropdown">
	<div class="dropdown-toggle" id="ramphor-user-account" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?php ramphor_the_user(
			null,
			[
				'template_dir' => $template_dir,
			]
		); ?>
	</div>
	<div class="dropdown-menu" aria-labelledby="ramphor-user-account">
		<h5 class="dropdown-header">Tài khoản</h6>
		<a class="dropdown-item">Thông tin</a>
		<a class="dropdown-item">Cài đặt</a>
		<div class="dropdown-divider"></div>
		<a
			class="dropdown-item"
			href="<?php echo ramphor_user_profile_url( 'logout' ); ?><?php echo $redirect; ?>"
		>
			Đăng xuất
		</a>
	</div>
</div>
