// Anniversary logo positioning
(function() {
  function updateLogoPosition() {
    const splash = document.querySelector('.splash--anniversary');
    if (splash) {
      const left = splash.getBoundingClientRect().left;
      document.documentElement.style.setProperty('--anniversary-logo-left', left + 'px');
    }
  }

  // Run on load and resize
  window.addEventListener('load', updateLogoPosition);
  window.addEventListener('resize', updateLogoPosition);
  
  // Also run immediately in case DOM is already ready
  if (document.readyState !== 'loading') {
    updateLogoPosition();
  }
})();
