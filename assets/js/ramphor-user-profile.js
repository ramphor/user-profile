(function($){
  MicroModal.init({
    onShow: modal => console.info(`${modal.id} is shown`), // [1]
    onClose: modal => console.info(`${modal.id} is hidden`), // [2]
    openTrigger: 'data-custom-open', // [3]
    disableScroll: true, // [5]
    disableFocus: false, // [6]
    awaitOpenAnimation: false, // [7]
    awaitCloseAnimation: false, // [8]
    debugMode: true // [9]
  });

  $(document).ready(function() {
    $('#rp-login-form').on('submit', function (e) {
      e.preventDefault();
      var data = $('#rp-login-form').serialize();
      console.log(data);
    });
  });
})(jQuery);