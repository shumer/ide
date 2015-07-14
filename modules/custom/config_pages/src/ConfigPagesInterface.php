<?php

/**
 * @file
 * Contains \Drupal\config_pages\ConfigPagesInterface.
 */

namespace Drupal\config_pages;

use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\UserInterface;

/**
 * Provides an interface defining a config_pages entity.
 */
interface ConfigPagesInterface extends ContentEntityInterface {

  /**
   * Gets the config_pages title.
   *
   * @return string
   *   Title of the config_pages.
   */
  public function getTitle();

}
