<?php

/**
 * @file
 * Contains Drupal\mks_custom_entity\Entity\MKSCustomEntity.
 */

namespace Drupal\mks_custom_entity\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\mks_custom_entity\MKSCustomEntityInterface;
use Drupal\user\UserInterface;

/**
 * Defines the MKSCustomEntity entity.
 *
 * @ingroup mks_custom_entity
 *
 * @ContentEntityType(
 *   id = "m_k_s_custom_entity",
 *   label = @Translation("MKSCustomEntity entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\mks_custom_entity\Entity\Controller\MKSCustomEntityListController",
 *     "views_data" = "Drupal\mks_custom_entity\Entity\MKSCustomEntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\mks_custom_entity\Entity\Form\MKSCustomEntityForm",
 *       "add" = "Drupal\mks_custom_entity\Entity\Form\MKSCustomEntityForm",
 *       "edit" = "Drupal\mks_custom_entity\Entity\Form\MKSCustomEntityForm",
 *       "delete" = "Drupal\mks_custom_entity\Entity\Form\MKSCustomEntityDeleteForm",
 *     },
 *     "access" = "Drupal\mks_custom_entity\MKSCustomEntityAccessControlHandler",
 *   },
 *   base_table = "m_k_s_custom_entity",
 *   admin_permission = "administer MKSCustomEntity entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/m_k_s_custom_entity/{m_k_s_custom_entity}",
 *     "edit-form" = "/admin/m_k_s_custom_entity/{m_k_s_custom_entity}/edit",
 *     "delete-form" = "/admin/m_k_s_custom_entity/{m_k_s_custom_entity}/delete"
 *   },
 *   field_ui_base_route = "m_k_s_custom_entity.settings"
 * )
 */
class MKSCustomEntity extends ContentEntityBase implements MKSCustomEntityInterface {
  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getChangedTime() {
    return $this->get('changed')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the MKSCustomEntity entity.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the MKSCustomEntity entity.'))
      ->setReadOnly(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of the MKSCustomEntity entity author.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDefaultValueCallback('Drupal\node\Entity\Node::getCurrentUserId')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the MKSCustomEntity entity.'))
      ->setSettings(array(
        'max_length' => 50,
        'text_processing' => 0,
      ))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code of MKSCustomEntity entity.'));

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
