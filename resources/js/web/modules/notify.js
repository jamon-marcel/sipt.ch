var Notify = (function() {

  /* --------------------------------------------------------------
  * VARIABLES
  * ------------------------------------------------------------ */

  // selectors
  var selectors = {
    html:   'html',
    body:   'body',
    notify: '.js-notify',
  };

  var classes = {
    hidden: 'is-hidden',
  };

  var types = {
    success:  'success',
    info:     'info',
    danger:   'danger',
    warning:  'warning'
  };

  var messages = {
    success:  'Juhuu!',
    info:     'Hm!',
    danger:   'Hoppla!'
  };

  var templates = {
    danger: '<div class="alert alert--danger js-notify">' +
              '<div>%msg%</div>'+
              '%errors%' +
            '</div>',
    success: '<div class="alert alert--success js-notify">' +
               '<div>%msg%</div>'+
             '</div>',
  };

  /* --------------------------------------------------------------
  * METHODS
  * ------------------------------------------------------------ */

  var _initialize = function() {
    $(selectors.body).on('click', selectors.notify, function() {
      _hide($(this));
    });
  };

  /**
   * Add an error notification
   * 
   * @param string msg 
   * @param string parent 
   * @param array errors 
   */
  var _error = function(msg, parent, errors) {
    
    // hide previously shown notifications
    _hide();

    // initialize error string
    var errorStr = '';

    // loop all errors and add to error string
    $.each(errors, function(key,error){
      if ($.isArray(error)) {
        $.each(error, function(k,v){
          if (typeof v !== "undefined") {
            errorStr += '<li>' + v + '</li>';
          }
        });
      }
      else {
        errorStr += '<li>' + error + '</li>';
      }
    });

    // add message
    var m = msg || messages[type];
    var tpl = templates.danger.replace("%msg%", m);

    // add errors to errors container
    if (errorStr.length > 0) {
      tpl = tpl.replace('%errors%', '<ul>'+ errorStr +'</ul>');
    }
    
    $(tpl).insertBefore($(parent));
  };

  /**
   * Add an success notification
   * 
   * @param string msg 
   * @param string parent 
   */
  var _success = function(msg, parent) {
    
    // hide previously shown notifications
    _hide();

    // add message
    var m = msg || messages[type];
    var tpl = templates.success.replace("%msg%", m);

    $(tpl).insertBefore($(parent));
  };

  var _hide = function() {
    $(selectors.notify).hide();
  };

  /* --------------------------------------------------------------
  * RETURN PUBLIC METHODS
  * ------------------------------------------------------------ */

  return {
    init:  _initialize,
    hide:  _hide,
    error: _error,
    success: _success,
  };

})();

export default Notify;