/**
 * @file
 * Attaches behaviors for Drupal's active link marking.
 */

(function ($, Drupal, drupalSettings) {

  "use strict";

  // Namespace.
  var worthy_custom = worthy_custom || {
    _inited: false,
    _windows: {},
  };

  /**
   * Attach and detach behaviors dispatcher.
   */
  Drupal.behaviors.worthy_custom = {
    attach: function (context, settings) {
      worthy_custom.attach($(context), settings);
    },
    detach: function (context, settings, trigger) {
    }
  };

/**
 * Attach behavior handler.
 */
worthy_custom.attach = function ($context, settings) {

  // Attach home page banner.
  worthy_custom.attach_home_page_banner($context, settings);

  // Attach main menu.
  worthy_custom.attach_main_menu($context, settings);
}

worthy_custom.attach_home_page_banner = function ($context, settings) {
  $(".banner-image").backstretch(drupalSettings.path.path_to_theme + '/images/banner.jpg');
}

worthy_custom.attach_main_menu = function ($context, settings) {
  $(".header .navbar ul").first().addClass('nav navbar-nav navbar-right');
}

  $('.modal').on('show.bs.modal', function (event) {
    var el = $(event.relatedTarget);
    var nid = el.data('nid');
    var data;
    var modal = $(this);
    $.get('/site_common/ajax/node/' + nid, function(resp, status) {
      console.log(status, resp);
      data = resp;

      //modal.find('.modal-title').text(data.title);
      modal.find('.modal-body-text').html(data)
    });


  })

})(jQuery, Drupal, drupalSettings);
