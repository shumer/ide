<?php

/**
 * @file
 * Contains Drupal\mks_custom_entity\MKSCustomEntityInterface.
 */

namespace Drupal\mks_custom_entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a MKSCustomEntity entity.
 *
 * @ingroup mks_custom_entity
 */
interface MKSCustomEntityInterface extends ContentEntityInterface, EntityOwnerInterface {
  // Add get/set methods for your configuration properties here.

}
