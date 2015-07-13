/**
 * @file
 * Attaches behaviors for Drupal's active link marking.
 */

(function ($, Drupal, drupalSettings) {

  "use strict";

  // Namespace.
  var ide_custom = ide_custom || {
    _inited: false,
    _windows: {},
  };

  /**
   * Attach and detach behaviors dispatcher.
   */
  Drupal.behaviors.ide_custom = {
    attach: function (context, settings) {
      ide_custom.attach($(context), settings);
    },
    detach: function (context, settings, trigger) {
      if (trigger === 'unload') {
        var activeLinks = context.querySelectorAll('[data-drupal-link-system-path].is-active');
        var il = activeLinks.length;
        for (var i = 0; i < il; i++) {
          var parentNode = activeLinks[i].parentNode;
          parentNode.classList.remove('current_page_item');
        }
      }
    }
  };

/**
 * Attach behavior handler.
 */
ide_custom.attach = function ($context, settings) {

  // Attach active links.
  ide_custom.attach_activeLinks($context, settings);

  ide_custom.attach_tabs($context, settings);
}

/**
 * Attach active links..
 */
ide_custom.attach_activeLinks = function($context, settings) {

  // Start by finding all potentially active links.
  var path = drupalSettings.path;
  var queryString = JSON.stringify(path.currentQuery);
  var querySelector = path.currentQuery ? "[data-drupal-link-query='" + queryString + "']" : ':not([data-drupal-link-query])';
  var originalSelectors = ['[data-drupal-link-system-path="' + path.currentPath + '"]'];
  var selectors;

  // If this is the front page, we have to check for the <front> path as
  // well.
  if (path.isFront) {
    originalSelectors.push('[data-drupal-link-system-path="<front>"]');
  }

  // Add language filtering.
  selectors = [].concat(
    // Links without any hreflang attributes (most of them).
    originalSelectors.map(function (selector) { return selector + ':not([hreflang])'; }),
    // Links with hreflang equals to the current language.
    originalSelectors.map(function (selector) { return selector + '[hreflang="' + path.currentLanguage + '"]'; })
  );

  // Add query string selector for pagers, exposed filters.
  selectors = selectors.map(function (current) { return current + querySelector; });

  // Query the DOM.
  var activeLinks = $context.find(selectors.join(','));
  var il = activeLinks.length;
  for (var i = 0; i < il; i++) {
    var parentNode = activeLinks[i].parentNode;
    if (parentNode.classList.contains('menu-item')) {
      parentNode.classList.add('current_page_item');
    }
  }
}

ide_custom.attach_tabs = function($context, settings) {
  $(document).ready(function(){
    $('tabs').tabs();
  });
}

})(jQuery, Drupal, drupalSettings);
