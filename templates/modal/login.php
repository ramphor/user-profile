<div class="modal micromodal-slide" id="modal-login" aria-hidden="true">
  <div class="modal__overlay" tabindex="-1" data-micromodal-close>
    <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-login-title">
      <header class="modal__header">
        <?php echo $logo_content; ?>

        <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
      </header>
      <main class="modal__content" id="modal-login-content">
        <div class="login-form-inputs">
          <?php echo $the_form; ?>
        </div>

        <div class="login-form-img">
          <img src="https://connectindiadigi.com/images/login.png" alt="<?php bloginfo('name'); ?>">
        </div>
      </main>
    </div>
  </div>
</div>
