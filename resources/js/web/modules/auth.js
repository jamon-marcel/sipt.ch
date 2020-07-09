import Loader from './loader';
import Notify from './notify';


var Auth = (function() {

  /* --------------------------------------------------------------
   * VARIABLES
   * ------------------------------------------------------------ */

  // selectors
  var selectors = {
    html:     'html',
    body:     'body',
    form:     '.js-auth-form',
    email:    '.js-auth-email',
    password: '.js-auth-password',
  };

  // classes
  var classes = {
    visible: 'is-visible'
  };

  /* --------------------------------------------------------------
   * METHODS
   * ------------------------------------------------------------ */
  
  // Init
  var _initialize = function() {
    _bind();

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  };

  // Bind events
  var _bind = function() {
    $(selectors.body).on('submit', selectors.form, function(e){
      e.preventDefault();
      _submit();
    });
  };

  var _submit = function(event) {

    var formData = {
      email: $(selectors.form).find('input[name="email"]').val(),
      password: $(selectors.form).find('input[name="password"]').val(),
    };
    
    if (_validate(formData)) {
      Loader.show();
      $.ajax({
        url: '/auth/student/login',
        method: 'post',
        dataType: 'json',
        data: formData,
        success: function(data){
          Loader.hide();
          _redirect();
        },
        error: function(data) {
          Loader.hide();
          Notify.error('Es sind Fehler aufgetreten.', '.js-booking-form', data.responseJSON.errors);
        }
      });
    }
  };

  var _validate = function(formData) {
    var valid = true, validationErrors = [];

    if (formData.email == '') {
      validationErrors.push('E-Mail muss ausgefüllt sein.');
      valid = false;
    }
    if (formData.password == '') {
      validationErrors.push('Passwort muss ausgefüllt sein.');
      valid = false;
    }

    if (!valid) {
      Notify.error('Es sind Fehler aufgetreten.', '.js-booking-form', validationErrors);
      return false;
    }

    return true;
  };

  var _redirect = function() {
    document.location.href = document.location.href + '/student';
  };

  /* --------------------------------------------------------------
   * RETURN PUBLIC METHODS
   * ------------------------------------------------------------ */

  return {
    init:  _initialize,
  };

})();

// Initialize
$(function() {
  Auth.init();
});

