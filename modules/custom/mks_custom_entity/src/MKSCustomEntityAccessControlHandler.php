<?php

/**
 * @file
 * Contains Drupal\mks_custom_entity\MKSCustomEntityAccessControlHandler.
 */

namespace Drupal\mks_custom_entity;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the MKSCustomEntity entity.
 *
 * @see \Drupal\mks_custom_entity\Entity\MKSCustomEntity.
 */
class MKSCustomEntityAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, $langcode, AccountInterface $account) {

    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view MKSCustomEntity entity');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit MKSCustomEntity entity');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete MKSCustomEntity entity');
    }

    return AccessResult::allowed();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add MKSCustomEntity entity');
  }

}
