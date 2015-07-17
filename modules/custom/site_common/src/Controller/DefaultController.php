<?php

/**
 * @file
 * Contains Drupal\site_common\Controller\DefaultController.
 */

namespace Drupal\site_common\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\site_common\Helpers\SiteCommonNode;
use GuzzleHttp\Message\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Render\MainContent\AjaxRenderer;

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
    $node = Node::load($nid);
    $title = $node->field_title->value;
    $body = $node->body->value;

    $view_builder = \Drupal::entityManager()
      ->getViewBuilder('node');
    $build = $view_builder
      ->view($node, 'default');
    $html = $view_builder->build($build);

    $content = [
      'title' => $title,
      'body' => $body,
    ];

    $renderer = \Drupal::service('renderer')->render($build);

    return new JsonResponse($renderer);
  }

}
