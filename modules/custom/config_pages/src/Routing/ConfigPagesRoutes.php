<?php
/**
 * @file
 * Contains \Drupal\config_pages\Routing\ConfigPagesRoutes.
 */

namespace Drupal\config_pages\Routing;
use Symfony\Component\Routing\Route;

/**
 * Defines dynamic routes for Config Pages.
 */
class ConfigPagesRoutes {

  /**
   * {@inheritdoc}
   */
  public function routes() {
    $routes = array();
    // Declares a single route under the name 'example.content'.
    // Returns an array of Route objects.
    $routes['config_pages.test_content'] = new Route(
      // Path to attach this route to:
      '/admin/content/config_page/{config_pages_type}',
      // Route defaults:
      array(
        '_controller' => '\Drupal\config_pages\Controller\ConfigPagesController::classInit',
        '_title' => 'Hello',
        'type' => 'new',
      ),
      // Route requirements:
      array(
        '_permission'  => 'access content',
      )
    );
    return $routes;
  }

}
?>
