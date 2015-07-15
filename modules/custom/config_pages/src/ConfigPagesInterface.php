<?php

/**
 * @file
 * Contains \Drupal\config_pages\ConfigPagesInterface.
 */

namespace Drupal\config_pages;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a custom config page entity.
 */
interface ConfigPagesInterface extends ContentEntityInterface, EntityChangedInterface {

  /**
   * Returns the config page revision log message.
   *
   * @return string
   *   The revision log message.
   */
  public function getRevisionLog();

  /**
   * Sets the config page description.
   *
   * @param string $info
   *   The config page description.
   *
   * @return \Drupal\config_pages\ConfigPagesInterface
   *   The class instance that this method is called on.
   */
  public function setInfo($info);

  /**
   * Sets the config page revision log message.
   *
   * @param string $revision_log
   *   The revision log message.
   *
   * @return \Drupal\config_pages\ConfigPagesInterface
   *   The class instance that this method is called on.
   */
  public function setRevisionLog($revision_log);

  /**
   * Sets the theme value.
   *
   * When creating a new config page content config page from the config page library, the user is
   * redirected to the configure form for that config page in the given theme. The
   * theme is stored against the config page when the config page content add form is shown.
   *
   * @param string $theme
   *   The theme name.
   *
   * @return \Drupal\config_pages\ConfigPagesInterface
   *   The class instance that this method is called on.
   */
  public function setTheme($theme);

  /**
   * Gets the theme value.
   *
   * When creating a new config page content config page from the config page library, the user is
   * redirected to the configure form for that config page in the given theme. The
   * theme is stored against the config page when the config page content add form is shown.
   *
   * @return string
   *   The theme name.
   */
  public function getTheme();

}
