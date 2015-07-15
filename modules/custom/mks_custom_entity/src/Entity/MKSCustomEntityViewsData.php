<?php

/**
 * @file
 * Contains Drupal\mks_custom_entity\Entity\MKSCustomEntity.
 */

namespace Drupal\mks_custom_entity\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides the views data for the MKSCustomEntity entity type.
 */
class MKSCustomEntityViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['m_k_s_custom_entity']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('MKSCustomEntity'),
      'help' => $this->t('The m_k_s_custom_entity entity ID.'),
    );

    return $data;
  }

}
