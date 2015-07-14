<?php

/**
 * @file
 * Contains \Drupal\node\Entity\ConfigPagesType.
 */

namespace Drupal\config_pages\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\config_pages\ConfigPagesTypeInterface;

/**
 * Defines the Node type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "config_pages_type",
 *   label = @Translation("Config page type"),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\config_pages\ConfigPagesTypeForm",
 *       "edit" = "Drupal\config_pages\ConfigPagesTypeForm",
 *     },
 *     "list_builder" = "Drupal\config_pages\ConfigPagesTypeListBuilder",
 *   },
 *   admin_permission = "administer content types",
 *   config_prefix = "config_pages_type",
 *   bundle_of = "node",
 *   entity_keys = {
 *     "id" = "type",
 *     "label" = "name"
 *   },
 * )
 */
class ConfigPagesType extends ConfigEntityBundleBase implements ConfigPagesTypeInterface {

  /**
   * The machine name of this node type.
   *
   * @var string
   *
   * @todo Rename to $id.
   */
  protected $type;

  /**
   * The human-readable name of the node type.
   *
   * @var string
   *
   * @todo Rename to $label.
   */
  protected $name;

  /**
   * A brief description of this node type.
   *
   * @var string
   */
  protected $description;

  /**
   * Help information shown to the user when creating a Node of this type.
   *
   * @var string
   */
  protected $help;

  /**
   * Default value of the 'Create new revision' checkbox of this node type.
   *
   * @var bool
   */
  protected $new_revision = FALSE;

  /**
   * The preview mode.
   *
   * @var int
   */
  protected $preview_mode = DRUPAL_OPTIONAL;

  /**
   * Display setting for author and date Submitted by post information.
   *
   * @var bool
   */
  protected $display_submitted = TRUE;

  /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->type;
  }

  /**
   * {@inheritdoc}
   */
  public function label() {
    return $this->name;
  }

  /**
   * {@inheritdoc}
   */
  public function isLocked() {
    $locked = \Drupal::state()->get('node.type.locked');
    return isset($locked[$this->id()]) ? $locked[$this->id()] : FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function isNewRevision() {
    return $this->new_revision;
  }

  /**
   * {@inheritdoc}
   */
  public function setNewRevision($new_revision) {
    $this->new_revision = $new_revision;
  }

  /**
   * {@inheritdoc}
   */
  public function displaySubmitted() {
    return $this->display_submitted;
  }

  /**
   * {@inheritdoc}
   */
  public function setDisplaySubmitted($display_submitted) {
    $this->display_submitted = $display_submitted;
  }

  /**
   * {@inheritdoc}
   */
  public function getPreviewMode() {
    return $this->preview_mode;
  }

  /**
   * {@inheritdoc}
   */
  public function setPreviewMode($preview_mode) {
    $this->preview_mode = $preview_mode;
  }

  /**
   * {@inheritdoc}
   */
  public function getHelp() {
    return $this->help;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(EntityStorageInterface $storage, $update = TRUE) {
    parent::postSave($storage, $update);

    if ($update) {
      // Clear the cached field definitions as some settings affect the field
      // definitions.
      $this->entityManager()->clearCachedFieldDefinitions();
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function postDelete(EntityStorageInterface $storage, array $entities) {
    parent::postDelete($storage, $entities);

    // Clear the node type cache to reflect the removal.
    $storage->resetCache(array_keys($entities));
  }

}
