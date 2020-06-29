var Loader = (function() {
	
	// selectors
	var selectors = {
    html: 'html',
    body: 'body',
    btn:  '.js-btn-loader',
    wrap: '.js-loader'
  };
  
  // Init
  var _initialize = function() {
    _bind();
  };

  // Classes
  var classes = {
    visible: 'is-visible'
  };

  // Bind events
  var _bind = function() {
    $(selectors.body).on('click', selectors.btn, function(){
      $(selectors.wrap).addClass(classes.visible);
    });
  };

  return {
    init:  _initialize,
  };
	
})();

// Initialize
$(function() {
  Loader.init();
});

