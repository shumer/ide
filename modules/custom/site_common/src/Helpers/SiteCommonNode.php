<?php
namespace Drupal\site_common\Helpers;

use Drupal\node\Entity\Node;

class SiteCommonNode {

  /**
   *  Load node with access check
   */
  public static function load($nid) {

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

  /**
   *  Delete node by bundle.
   */
  public static function deleteAllByType($type = '') {
    if(!$type) {
      return;
    }

    SiteCommonEntity::deleteAllByType('node', $type);
  }

}
