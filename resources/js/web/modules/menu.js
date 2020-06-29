var Menu = (function() {
	
	// selectors
	var selectors = {
    html:         'html',
    body:         'body',
    menu:         '.js-menu',
    menuBtnShow:  '.js-menu-btn-show',
    menuBtnHide:  '.js-menu-btn-hide'
	};

  // css classes
  var classes = {
    active:   'is-active',
    visible:  'is-visible',
    hidden:   'is-hidden',
    open:     'is-open',
    hasMenu:  'has-menu',
  };

  // Init
  var _initialize = function() {
    _bind();
  };

  // Bind events
  var _bind = function() {
    $(selectors.body).on('click', selectors.menuBtnShow, function(){
      _show($(this));
    });

    $(selectors.body).on('click', selectors.menuBtnHide, function(){
      _hide($(this));
    });
  };

  var _show = function(btn) {
    $(selectors.menuBtnShow).addClass(classes.hidden);
    $(selectors.menu).addClass(classes.open);
    $(selectors.html).addClass(classes.hasMenu);
    $(selectors.body).addClass(classes.hasMenu);
    $(selectors.menuBtnHide).removeClass(classes.hidden);

  };

  var _hide = function(btn) {
    $(selectors.menuBtnShow).removeClass(classes.hidden);
    $(selectors.menu).removeClass(classes.open);
    $(selectors.html).removeClass(classes.hasMenu);
    $(selectors.menuBtnHide).addClass(classes.hidden);

    setTimeout(function(){
      $(selectors.body).removeClass(classes.hasMenu);
    }, 160);
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
  Menu.init();
});

