<?php
namespace Drupal\site_common\Helpers;

use Drupal\node\Entity\Node;

class HNode {

  /**
   *  Load node with access check
   */
  public static function nodeLoad($nid) {

    if (!is_numeric($nid)) {
      return;
    }

    $node = NULL;

    if (!empty($nid) && is_numeric($nid)) {
      $node = Node::load($nid);
      if (!$node->access('view')) {
        $node = NULL;
      }
    }

    return $node;
  }

}
