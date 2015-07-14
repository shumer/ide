<?php

/**
 * @file
 * Contains \Drupal\config_pages\Plugin\Menu\LocalAction\ConfigPageContentAddLocalAction.
 */

namespace Drupal\config_pages\Plugin\Menu\LocalAction;

use Drupal\Core\Menu\LocalActionDefault;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Routing\UrlGeneratorTrait;

/**
 * Modifies the 'Add custom block' local action.
 */
class ConfigPageContentAddLocalAction extends LocalActionDefault {
  use UrlGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function getOptions(RouteMatchInterface $route_match) {
    $options = parent::getOptions($route_match);
    // If the route specifies a theme, append it to the query string.
    if ($theme = $route_match->getParameter('theme')) {
      $options['query']['theme'] = $theme;
    }
    // Adds a destination on custom block listing.
    if ($route_match->getRouteName() == 'entity.config_pages.collection') {
      $options['query']['destination'] = $this->url('<current>');
    }
    return $options;
  }

}
