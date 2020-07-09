import Loader from './loader';
import Notify from './notify';

var Booking = (function() {

  /* --------------------------------------------------------------
   * VARIABLES
   * ------------------------------------------------------------ */

  // selectors
  var selectors = {
    html:               'html',
    body:               'body',
    wrapper:            '.js-booking-wrapper',
    forms:              '.js-booking-form',
    formRegister:       '.js-register-form',
    formAuth:           '.js-auth-form',
    listing:            '.js-bookings',
    empty:              '.js-no-bookings',
    btnAdd:             '.js-btn-add-booking',
    btnDelete:          '.js-btn-delete-booking',
    btnToggle:          '.js-btn-bookings',
    btnToggleAuth:      '.js-btn-show-auth',
    btnToggleRegister:  '.js-btn-show-register',
    btnStoreBookings:   '.js-btn-store-bookings',
    counter:            '.js-booking-counter',
  };

  // classes
  var classes = {
    visible: 'is-visible'
  };

  // booking template
  var tpl = `<div class="list list--booking">
              <div class="list__item">%module%</div>
              <div class="list__item">Datum: %date%</div>
              <div class="list__item">Kosten: CHF %cost%.–</div>
              <div class="list__item list__item--button">
                <a href="javascript:;" class="js-btn-delete-booking" data-id="%id%">löschen</a>
              </div>
            </div>`;

  /* --------------------------------------------------------------
   * METHODS
   * ------------------------------------------------------------ */
  
  var _initialize = function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    _bind();
  };

  /* --------------------------------------------------------------
   * EVENTS
   * ------------------------------------------------------------ */

  var _bind = function() {
    $(selectors.body).on('click', selectors.btnAdd, function(){
      _addBooking($(this));
    });

    $(selectors.body).on('click', selectors.btnDelete, function(){
      _destroyBooking($(this));
    });

    $(selectors.body).on('click', selectors.btnToggle, function(){
      _toogleBookings();
    });

    $(selectors.body).on('click', selectors.btnToggleAuth, function(){
      _toggleAuthForm(this);
    });

    $(selectors.body).on('click', selectors.btnToggleRegister, function(){
      _toggleRegisterForm(this);
    });

    $(selectors.body).on('submit', selectors.formRegister, function(e){
      e.preventDefault();
      _registerAndStoreBooking();
    });

    $(selectors.body).on('click', selectors.btnStoreBookings, function(e) {
      e.preventDefault();
      _storeBooking();
    });

  };

  /* --------------------------------------------------------------
   * PRIVATE METHODS
   * ------------------------------------------------------------ */

  var _addBooking = function(event) {
    Loader.show();
    var eventId = event.prev('[name="event_id"]').val();
    $.ajax({
      url: '/booking/' + eventId,
      method: 'get',
      success: function(data){
        _refreshBookings(data);
        _showBookings();
        _toggleRegisterForm();
      },
      error: function(data) { }
    });
  };

  var _destroyBooking = function(event) {
    var eventId = event.data('id');
    Loader.show();
    $.ajax({
      url: '/booking/' + eventId,
      method: 'delete',
      success: function(data){
        _refreshBookings(data);
      },
      error: function(data) { }
    });
  };

  var _registerAndStoreBooking = function() {

    var form = $(selectors.formRegister); 

    // Gather form data
    var formData = {
      firstname: form.find('input[name="firstname"]').val().trim(),
      name: form.find('input[name="name"]').val().trim(),
      title: form.find('input[name="title"]').val().trim(),
      street: form.find('input[name="street"]').val().trim(),
      street_no: form.find('input[name="street_no"]').val().trim(),
      zip: form.find('input[name="zip"]').val().trim(),
      city: form.find('input[name="city"]').val().trim(),
      country: form.find('input[name="country"]').val().trim(),
      phone: form.find('input[name="phone"]').val().trim(),
      phone_business: form.find('input[name="phone_business"]').val().trim(),
      mobile: form.find('input[name="mobile"]').val().trim(),
      email: form.find('input[name="email"]').val().trim(),
      qualifications: form.find('input[name="qualifications"]').val().trim(),
      toc: form.find('input[name="toc"]').is(':checked'),
    };

    if (_validate(formData)) {
      Loader.show();
      $.ajax({
        url: '/booking/register',
        method: 'post',
        dataType: 'json',
        data: formData,
        success: function(data){
          _reset();
          Loader.hide();
          Notify.success('Vielen Dank für Ihre Anmeldung. Die Bestätigung für den/die Kurse folgt in Kürze per Mail', '.js-booking-form');
        },
        error: function(data) {
          Loader.hide();
          Notify.error('Es sind Fehler aufgetreten.', '.js-booking-form', data.responseJSON.errors);
        }
      });
    }
  };

  var _storeBooking = function() {
    Loader.show();
    $.ajax({
      url: '/booking',
      method: 'post',
      dataType: 'json',
      success: function(data){
        _reset();
        Loader.hide();
        Notify.success('Vielen Dank für Ihre Anmeldung. Die Bestätigung für den/die Kurse folgt in Kürze per Mail', '.js-booking-form');
      },
      error: function(data) {
        Loader.hide();
        Notify.error('Es sind Fehler aufgetreten.', '.js-booking-form', data.responseJSON.errors);
      }
    });
  };

  var _reset = function() {
    $(selectors.formRegister).trigger('reset').hide();
    $(selectors.formAuth).trigger('reset').hide();
    $(selectors.forms).hide();
    $(selectors.listing).html('');
    $(selectors.counter).html('');
  };

  var _refreshBookings = function(data) {

    if (data.length == 0) {
      $(selectors.listing).html('');
      $(selectors.counter).html('');
      $(selectors.empty).show();
      Loader.hide();
      _hideBookings();
      return;
    }

    if (data.length > 0) {
      $(selectors.listing).html('');
      $(selectors.empty).hide();
      $(data).each(function(){
        var item = tpl.replace("%date%", this.date);
            item = item.replace("%module%", this.title);
            item = item.replace("%cost%", this.cost);
            item = item.replace("%id%", this.id);
        $(item).appendTo(selectors.listing);
      });
      $(selectors.counter).html('['+data.length+']');
      Loader.hide();
    }
  };

  var _showBookings = function() {
    Notify.hide();
    $(selectors.wrapper).addClass(classes.visible);
    $(selectors.forms).show();
  };

  var _hideBookings = function() {
    $(selectors.wrapper).removeClass(classes.visible);
    $(selectors.forms).hide();
  };

  var _toogleBookings = function() {
    $(selectors.wrapper).toggleClass(classes.visible);
  };

  var _toggleAuthForm = function(btn) {
    $(selectors.btnToggleRegister).show();
    $(selectors.formAuth).show();
    $(selectors.btnToggleAuth).hide();
    $(selectors.formRegister).hide();
    Notify.hide();
  };

  var _toggleRegisterForm = function(btn) {
    $(selectors.btnToggleAuth).show();
    $(selectors.formRegister).show();
    $(selectors.btnToggleRegister).hide();
    $(selectors.formAuth).hide();
    Notify.hide();
  };

  var _validate = function(formData) {
    
    var valid = true, 
        validationErrors = [];

    if (formData.firstname == '') {
      validationErrors.push('Vorname muss ausgefüllt sein.');
      valid = false;
    }

    if (formData.name == '') {
      validationErrors.push('Name muss ausgefüllt sein.');
      valid = false;
    }

    if (formData.street == '') {
      validationErrors.push('Strasse muss ausgefüllt sein.');
      valid = false;
    }

    if (formData.zip == '') {
      validationErrors.push('PLZ muss ausgefüllt sein.');
      valid = false;
    }

    if (formData.city == '') {
      validationErrors.push('Ort muss ausgefüllt sein.');
      valid = false;
    }

    if (formData.country == '') {
      validationErrors.push('Land muss ausgefüllt sein.');
      valid = false;
    }

    if (formData.phone == '') {
      validationErrors.push('Telefon P muss ausgefüllt sein.');
      valid = false;
    }

    if (formData.email == '') {
      validationErrors.push('E-Mail muss ausgefüllt sein.');
      valid = false;
    }

    if (formData.qualifications == '') {
      validationErrors.push('Berufsabschluss muss ausgefüllt sein.');
      valid = false;
    }

    if (!formData.toc) {
      validationErrors.push('AGBs müssen akzeptiert werden.');
      valid = false;
    }

    if (!valid) {
      Notify.error('Es sind Fehler aufgetreten.', '.js-booking-form', validationErrors);
      return false;
    }

    return true;
  };


  /* --------------------------------------------------------------
   * PUBLIC METHODS
   * ------------------------------------------------------------ */

  return {
    init: _initialize,
  };

})();

// Initialize
$(function() {
  Booking.init();
});

