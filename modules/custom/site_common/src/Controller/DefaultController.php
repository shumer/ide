<?php

/**
 * @file
 * Contains Drupal\site_common\Controller\DefaultController.
 */

namespace Drupal\site_common\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Class DefaultController.
 *
 * @package Drupal\site_common\Controller
 */
class DefaultController extends ControllerBase {
  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function hello($name) {
    return [
        '#type' => 'markup',
        '#markup' => $this->t('Hello @name!', ['@name' => $name])
    ];
  }

  public function ajaxGetNode($nid) {
    Node::load($nid);
  }

}
