<?php
namespace Drupal\site_common\Helpers;


use Behat\Mink\Exception\Exception;
use Drupal\Core\Entity\Entity;

class SiteCommonEntity {

  /**
   *  Delete entity by type
   */
  public static function deleteAllByType($entity_type, $bundle = '') {
    if(!$entity_type) {
      return;
    }

    try {
      $query = \Drupal::entityQuery($entity_type);
      if($bundle) {
        $query->condition('type', $bundle);
      }
      $entities = $query->execute();

      $entityStorage = \Drupal::entityManager()->getStorage($entity_type);
      $entities = $entityStorage->loadMultiple(array_keys($entities));
      foreach ($entities as $entity) {
        $entity->delete();
      }
    }
    catch(\Exception $e){
      watchdog_exception('helper_exeption', $e, $e->getMessage());
    }
  }

}
