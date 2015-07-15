<?php

/**
 * @file
 * Contains Drupal\mks_custom_entity\Entity\Controller\MKSCustomEntityListController.
 */

namespace Drupal\mks_custom_entity\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Provides a list controller for MKSCustomEntity entity.
 *
 * @ingroup mks_custom_entity
 */
class MKSCustomEntityListController extends EntityListBuilder {
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('MKSCustomEntityID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\mks_custom_entity\Entity\MKSCustomEntity */
    $row['id'] = $entity->id();
    $row['name'] = \Drupal::l(
      $this->getLabel($entity),
      new Url(
        'entity.m_k_s_custom_entity.edit_form', array(
          'm_k_s_custom_entity' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
