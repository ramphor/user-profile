<div class="modal micromodal-slide" id="rp-login-form" aria-hidden="true">
	<div class="modal__overlay" tabindex="-1" data-micromodal-close>
		<div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="rp-login-form-title">
			<header class="modal__header">
				<h2 class="modal__title" id="rp-login-form-title">
					<?php _e( 'Login', 'rp_user_profile' ); ?>
				</h2>
				<button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
			</header>
			<main class="modal__content" id="rp-login-form-content">
			<div class="rp-loginform">
				<div class="rpf-left the-form">
					<form action="<?php echo ramphor_user_profile_url( 'login' ); ?>" method="POST">
						<div class="rp-field field-email">
							<label class="rp-label lbl-email">
								Email
							</label>
							<div class="rp-input input-email">
								<input name="rp_user_email" class="rp-text text-email" />
							</div>
						</div>

						<div class="rp-field field-password">
							<label class="rp-label label-password">
								Password
							</label>
							<div class="rp-input input-password">
								<input type="password" name="rp_user_password">
							</div>
						</div>

						<div class="rp-field field-remember">
							<div class="rp-input input-remember">
								<input id="rp-field-remember-me" type="checkbox" name="remmeber_me" value="yes">
								<label for="rp-field-remember-me"><?php _e( 'Remember me', 'rp_user_profile' ); ?></label>
							</div>
						</div>

						<footer class="modal__footer">
							<button class="modal__btn modal__btn-primary"><?php _e( 'Login', 'rp_user_profile' ); ?></button>
							<button class="modal__btn" data-micromodal-close aria-label="Close this dialog window"><?php _e( 'Close', 'rp_user_profile' ); ?></button>
						</footer>
					</form>
				<div>
				<div class="rpf-right socials">
					<?php _e( 'Socials', 'rp_user_profile' ); ?>
					<div class="list-socials">
						<ul class="social-provider">
							<li>
								<a href=""><?php _e( 'Signin with Facebook', 'rp_user_profile' ); ?></a>
							</li>
						</ul>
					</div>
				</div>
			</div>
			</main>
		</div>
	</div>
</div>
