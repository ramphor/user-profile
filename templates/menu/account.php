<div class="dropdown">
	<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"
		aria-haspopup="true" aria-expanded="false">
		Tài khoản
	</button>
	<div class="dropdown-menu" aria-labelledby="dropdownMenu2">
		<span class="fas fa-user"></span>
		<h6 class="dropdown-header"><?php echo $currentUser->display_name; ?></h6>

		<a class="dropdown-item">Thông tin</a>
		<a class="dropdown-item">Cài đặt</a>
		<div class="dropdown-divider"></div>
		<a class="dropdown-item" href="<?php echo ramphor_user_profile_url( 'logout' ); ?>">Đăng xuất</a>
	</div>
</div>
