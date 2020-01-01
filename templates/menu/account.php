<div class="dropdown">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="ramphor-user-account" data-toggle="dropdown"
		aria-haspopup="true" aria-expanded="false">
		<img
			src="<?php echo get_avatar_url( $currentUser->ID, array( 'size' => 30 ) ); ?>"
			alt="<?php echo $currentUser->display_name; ?>"
		/>
	</button>
	<div class="dropdown-menu" aria-labelledby="ramphor-user-account">
		<h5 class="dropdown-header"><?php echo $currentUser->display_name; ?></h6>
		<a class="dropdown-item">Thông tin</a>
		<a class="dropdown-item">Cài đặt</a>
		<div class="dropdown-divider"></div>
		<a
			class="dropdown-item"
			href="<?php echo ramphor_user_profile_url( 'logout' ); ?>?redirect=<?php echo $redirect; ?>"
		>
			Đăng xuất
		</a>
	</div>
</div>
