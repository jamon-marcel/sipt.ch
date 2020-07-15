var Contact = (function() {

  /* --------------------------------------------------------------
   * VARIABLES
   * ------------------------------------------------------------ */

  // selectors
  var selectors = {
    html:               'html',
    body:               'body',
    wrapper:            '.js-contact',
    btnToggle:          '.js-btn-contact',

  };

  // classes
  var classes = {
    visible: 'is-visible',
    active: 'is-active',
  };

  /* --------------------------------------------------------------
   * METHODS
   * ------------------------------------------------------------ */
  
  var _initialize = function() {
    _bind();
  };

  /* --------------------------------------------------------------
   * EVENTS
   * ------------------------------------------------------------ */

  var _bind = function() {
    $(selectors.body).on('click', selectors.btnToggle, function(){
      _toogle();
    });

  };

  /* --------------------------------------------------------------
   * PRIVATE METHODS
   * ------------------------------------------------------------ */


  var _toogle = function() {
    $(selectors.wrapper).toggleClass(classes.visible);
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
  Contact.init();
});

