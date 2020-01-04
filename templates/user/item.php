<div class="rp-user user-item size-small">
	<div class="rp-avatar">
		<img
			src="<?php echo get_avatar_url( $user->ID, array( 'size' => 30 ) ); ?>"
			alt="<?php echo $user->display_name; ?>"
		/>
		<div class="laurel-wreath"></div>
	</div>
	<span class="navbar-text">
		<?php echo $user->display_name; ?>
	</span>
</div>
