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
use Drupal\config_pages\ConfigPagesInterface;

/**
 * Defines the config page entity class.
 *
 * @ContentEntityType(
 *   id = "config_pages",
 *   label = @Translation("Config page"),
 *   bundle_label = @Translation("Config page type"),
 *   handlers = {
 *     "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
 *     "access" = "Drupal\config_pages\ConfigPagesAccessControlHandler",
 *     "list_builder" = "Drupal\config_pages\ConfigPagesListBuilder",
 *     "view_builder" = "Drupal\config_pages\ConfigPagesViewBuilder",
 *     "views_data" = "Drupal\config_pages\ConfigPagesViewsData",
 *     "form" = {
 *       "add" = "Drupal\config_pages\ConfigPagesForm",
 *       "edit" = "Drupal\config_pages\ConfigPagesForm",
 *       "default" = "Drupal\config_pages\ConfigPagesForm"
 *     },
 *     "translation" = "Drupal\config_pages\ConfigPagesTranslationHandler"
 *   },
 *   admin_permission = "administer config pages",
 *   base_table = "config_pages",
 *   revision_table = "config_pages_revision",
 *   data_table = "config_pages_field_data",
 *   links = {
 *     "canonical" = "/config_pages/{config_pages}",
 *     "edit-form" = "/config_pages/{config_pages}",
 *     "collection" = "/admin/structure/config_pages/config-pages-content",
 *   },
 *   translatable = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "revision_id",
 *     "bundle" = "type",
 *     "label" = "info",
 *     "langcode" = "langcode",
 *     "uuid" = "uuid"
 *   },
 *   bundle_entity_type = "config_pages_type",
 *   field_ui_base_route = "entity.config_pages_type.edit_form",
 *   render_cache = FALSE,
 * )
 *
 * Note that render caching of config_pages entities is disabled because they
 * are always rendered as config pages, and config pages already have their own render
 * caching.
 * See https://www.drupal.org/node/2284917#comment-9132521 for more information.
 */
class ConfigPages extends ContentEntityBase implements ConfigPagesInterface {

  use EntityChangedTrait;

  /**
   * The theme the config page is being created in.
   *
   * When creating a new config page from the config page library, the user is
   * redirected to the configure form for that config page in the given theme. The
   * theme is stored against the config page when the config page add form is shown.
   *
   * @var string
   */
  protected $theme;

  /**
   * {@inheritdoc}
   */
  public function createDuplicate() {
    $duplicate = parent::createDuplicate();
    $duplicate->revision_id->value = NULL;
    $duplicate->id->value = NULL;
    return $duplicate;
  }

  /**
   * {@inheritdoc}
   */
  public function setTheme($theme) {
    $this->theme = $theme;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getTheme() {
    return $this->theme;
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(EntityStorageInterface $storage, $update = TRUE) {
    parent::postSave($storage, $update);

  }

  /**
   * {@inheritdoc}
   */
  public function preSaveRevision(EntityStorageInterface $storage, \stdClass $record) {
    parent::preSaveRevision($storage, $record);

    if (!$this->isNewRevision() && isset($this->original) && (!isset($record->revision_log) || $record->revision_log === '')) {
      // If we are updating an existing config_pages without adding a new
      // revision and the user did not supply a revision log, keep the existing
      // one.
      $record->revision_log = $this->original->getRevisionLog();
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Config page ID'))
      ->setDescription(t('The config page ID.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The config page UUID.'))
      ->setReadOnly(TRUE);

    $fields['revision_id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Revision ID'))
      ->setDescription(t('The revision ID.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language'))
      ->setDescription(t('The config page language code.'))
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE)
      ->setDisplayOptions('view', array(
        'type' => 'hidden',
      ))
      ->setDisplayOptions('form', array(
        'type' => 'language_select',
        'weight' => 2,
      ));

    $fields['info'] = BaseFieldDefinition::create('string')
      ->setLabel(t('ConfigPage description'))
      ->setDescription(t('A brief description of your config page.'))
      ->setRevisionable(FALSE)
      ->setTranslatable(FALSE)
      ->setDisplayOptions('view', array(
        'type' => 'hidden',
      ))
      ->setDisplayConfigurable('form', TRUE);

    $fields['type'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('ConfigPage type'))
      ->setDescription(t('The config page type.'))
      ->setSetting('target_type', 'config_pages_type');

    $fields['revision_log'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Revision log message'))
      ->setDescription(t('The log entry explaining the changes in this revision.'))
      ->setRevisionable(TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the config page was last edited.'))
      ->setTranslatable(TRUE)
      ->setRevisionable(TRUE);

    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Revision translation affected'))
      ->setDescription(t('Indicates if the last edit of a translation belongs to current revision.'))
      ->setReadOnly(TRUE)
      ->setRevisionable(TRUE)
      ->setTranslatable(TRUE);

    return $fields;
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
  public function getRevisionLog() {
    return $this->get('revision_log')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setInfo($info) {
    $this->set('info', $info);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setRevisionLog($revision_log) {
    $this->set('revision_log', $revision_log);
    return $this;
  }

  public static function create(array $values = []) {
    return \Drupal::entityManager()
      ->getStorage('config_pages')
      ->create($values);
  }

}
