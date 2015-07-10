<?php
/**
 * @file
 * Contains \Drupal\ide_common\Controller\IdeMainController.
 */

namespace Drupal\ide_common\Controller;

use Drupal\Core\Controller\ControllerBase;

class IdeMainController extends ControllerBase {
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello, World!'),
    );
  }
}
?>
