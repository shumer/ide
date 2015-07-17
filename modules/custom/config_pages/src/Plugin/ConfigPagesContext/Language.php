<?php
namespace Drupal\config_pages\Plugin\ConfigPagesContext;

use Drupal\config_pages\ConfigPagesContextBase;

/**
 * Provides a language config pages context.
 *
 * @ConfigPagesContext(
 *   id = "language",
 *   label = @Translation("Language"),
 * )
 */
class Language extends ConfigPagesContextBase{

  public static function getValue() {
    $lang = \Drupal::service('language_manager')->getCurrentLanguage();
    return $lang->getId();
  }

}
