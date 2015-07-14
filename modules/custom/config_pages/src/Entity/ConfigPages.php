<?php

/**
 * @file
 * Contains \Drupal\config_pages\Entity\ConfigPages.
 */

namespace Drupal\config_pages\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Language\LanguageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\config_pages\ConfigPagesInterface;
use Drupal\user\UserInterface;

/**
 * Defines the node entity class.
 *
 * @ContentEntityType(
 *   id = "config_pages",
 *   label = @Translation("Content"),
 *   bundle_label = @Translation("Config pages"),
 *   handlers = {
 *     "list_builder" = "Drupal\config_pages\ConfigPagesListBuilder",
 *   },
 * )
 */
class ConfigPages extends ContentEntityBase implements ConfigPagesInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->get('title')->value;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['type'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Title'))
      ->setRequired(TRUE)
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setDefaultValue('')
      ->setSetting('max_length', 255);

    return $fields;
  }

}
