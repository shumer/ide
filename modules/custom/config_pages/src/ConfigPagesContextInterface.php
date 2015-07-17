<?php
namespace Drupal\config_pages;

use Drupal\Component\Plugin\PluginInspectionInterface;

interface ConfigPagesContextInterface extends PluginInspectionInterface {

  /**
   * Return the label of the context.
   *
   * @return string
   */
  public function getLabel();

}