<div class="dropdown">
	<div class="dropdown-toggle" id="ramphor-user-account" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<img
			src="<?php echo get_avatar_url( $currentUser->ID, array( 'size' => 30 ) ); ?>"
			alt="<?php echo $currentUser->display_name; ?>"
		/>
		<span class="navbar-text">
			<?php echo $currentUser->display_name; ?>
		</span>
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
