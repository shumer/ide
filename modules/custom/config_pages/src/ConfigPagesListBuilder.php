<?php

/**
 * @file
 * Contains \Drupal\config_pages\ConfigPagesListBuilder.
 */

namespace Drupal\config_pages;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * Defines a class to build a listing of custom config_pages entities.
 *
 * @see \Drupal\config_pages\Entity\ConfigPages
 */
class ConfigPagesListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = t('Config page description');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['label'] = $this->getLabel($entity);
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultOperations(EntityInterface $entity) {
    $operations = parent::getDefaultOperations($entity);
    if (isset($operations['edit'])) {
      $operations['edit']['query']['destination'] = $entity->url('collection');
    }
    return $operations;
  }

}
