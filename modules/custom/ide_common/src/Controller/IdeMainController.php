<?php
/**
 * @file
 * Contains \Drupal\ide_common\Controller\IdeMainController.
 */

namespace Drupal\ide_common\Controller;

use Drupal\Core\Controller\ControllerBase;

class IdeMainController extends ControllerBase {
  public function content() {

    $layout = '1col__layout';

    return array(
      '#type' => 'page',
      'content' => [
        'custom' => [
          '#type' => 'markup',
          '#markup' => t('Hello, World!')
        ],
      ],
      '#theme' => 'page__front',
      '#layout' => $layout,
    );
  }
}
?>
