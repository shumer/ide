<?php
namespace Drupal\config_pages;

use Drupal\Component\Plugin\PluginBase;

class ConfigPagesContextBase extends PluginBase implements ConfigPagesContextInterface {

  public function getLabel() {
    return $this->pluginDefinition['label'];
  }

}