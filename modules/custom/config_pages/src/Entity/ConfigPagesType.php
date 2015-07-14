<?php

/**
 * @file
 * Contains \Drupal\config_pages\Entity\ConfigPagesType.
 */

namespace Drupal\config_pages\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\config_pages\ConfigPagesTypeInterface;

/**
 * Defines the config page type entity.
 *
 * @ConfigEntityType(
 *   id = "config_pages_type",
 *   label = @Translation("Config page type"),
 *   handlers = {
 *     "form" = {
 *       "default" = "Drupal\config_pages\ConfigPagesTypeForm",
 *       "add" = "Drupal\config_pages\ConfigPagesTypeForm",
 *       "edit" = "Drupal\config_pages\ConfigPagesTypeForm",
 *       "delete" = "Drupal\config_pages\Form\ConfigPagesTypeDeleteForm"
 *     },
 *     "list_builder" = "Drupal\config_pages\ConfigPagesTypeListBuilder"
 *   },
 *   admin_permission = "administer blocks",
 *   config_prefix = "type",
 *   bundle_of = "config_pages",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
 *   links = {
 *     "delete-form" = "/admin/structure/config_pages/config-pages-content/manage/{config_pages_type}/delete",
 *     "edit-form" = "/admin/structure/config_pages/config-pages-content/manage/{config_pages_type}",
 *     "collection" = "/admin/structure/config_pages/config-pages-content/types",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "revision",
 *     "description",
 *   }
 * )
 */
class ConfigPagesType extends ConfigEntityBundleBase implements ConfigPagesTypeInterface {

  /**
   * The config page type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The config page type label.
   *
   * @var string
   */
  protected $label;

  /**
   * The default revision setting for config pages of this type.
   *
   * @var bool
   */
  protected $revision;

  /**
   * The description of the block type.
   *
   * @var string
   */
  protected $description;

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function shouldCreateNewRevision() {
    return $this->revision;
  }

}
