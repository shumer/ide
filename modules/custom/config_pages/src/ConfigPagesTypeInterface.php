<?php

/**
 * @file
 * Contains \Drupal\config_pages\ConfigPagesTypeInterface.
 */

namespace Drupal\config_pages;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining a custom config page type entity.
 */
interface ConfigPagesTypeInterface extends ConfigEntityInterface {

  /**
   * Returns the description of the config page type.
   *
   * @return string
   *   The description of the type of this config page.
   */
  public function getDescription();

  /**
   * Returns whether a new revision should be created by default.
   *
   * @return bool
   *   TRUE if a new revision should be created by default.
   */
  public function shouldCreateNewRevision();

}
