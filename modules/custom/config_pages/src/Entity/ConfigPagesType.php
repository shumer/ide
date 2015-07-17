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
 *     "label" = "label",
 *     "context" = "context",
 *     "menu" = "menu"
 *   },
 *   links = {
 *     "delete-form" = "/admin/structure/config_pages/config-pages-content/manage/{config_pages_type}/delete",
 *     "edit-form" = "/admin/structure/config_pages/config-pages-content/manage/{config_pages_type}",
 *     "collection" = "/admin/structure/config_pages/config-pages-content/types",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "context",
 *     "menu"
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
   * Provides the list of config_pages types.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   Storage interface.
   *
   * @param array
   *   Array of entities.
   */
  public static function postDelete(EntityStorageInterface $storage, array $entities) {
    $query = \Drupal::entityQuery('config_pages');

    $type = array_shift($entities);

    $label = $type->label();
    $config_page_id = $query->condition('label', $label)->execute();
    $config_page_id = array_shift($config_page_id);
    $config_page = ConfigPages::load($config_page_id);
    $config_page->delete();
  }

  /**
   * Provides the list of config_pages types.
   *
   * @return array
   *   The array of types.
   */
  public static function getTypes($type = array()) {
    $storage = \Drupal::entityManager()->getStorage('config_pages_type');
    $types = $storage->loadMultipleOverrideFree($type);
    return !empty($type) ? reset($types) : $types;
  }
}
