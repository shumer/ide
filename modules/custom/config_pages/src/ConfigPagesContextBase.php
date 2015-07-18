<?php

/**
 * @file
 * Contains \Drupal\config_pages\ConfigPagesContextBase.
 */

namespace Drupal\config_pages;

use Drupal\Component\Plugin\PluginBase;

class ConfigPagesContextBase extends PluginBase implements ConfigPagesContextInterface {

  /**
   * Return the label of the context.
   *
   * @return string
   */
  public function getLabel() {
    return $this->pluginDefinition['label'];
  }

}
