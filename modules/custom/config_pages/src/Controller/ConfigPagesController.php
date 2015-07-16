<?php

/**
 * @file
 * Contains \Drupal\config_pages\Controller\ConfigPagesController.
 */

namespace Drupal\config_pages\Controller;

use Drupal\Component\Plugin\PluginManagerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\config_pages\ConfigPagesTypeInterface;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class ConfigPagesController extends ControllerBase {

  /**
   * The config page storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $ConfigPagesStorage;

  /**
   * The config page type storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $ConfigPagesTypeStorage;

  /**
   * The theme handler.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  protected $themeHandler;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $entity_manager = $container->get('entity.manager');
    return new static(
      $entity_manager->getStorage('config_pages'),
      $entity_manager->getStorage('config_pages_type'),
      $container->get('theme_handler')
    );
  }

  /**
   * Constructs a ConfigPages object.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $config_pages_storage
   *   The config page storage.
   * @param \Drupal\Core\Entity\EntityStorageInterface $config_pages_type_storage
   *   The config page type storage.
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $theme_handler
   *   The theme handler.
   */
  public function __construct(EntityStorageInterface $config_pages_storage, EntityStorageInterface $config_pages_type_storage, ThemeHandlerInterface $theme_handler) {
    $this->ConfigPagesStorage = $config_pages_storage;
    $this->ConfigPagesTypeStorage = $config_pages_type_storage;
    $this->themeHandler = $theme_handler;
  }

  /**
   * Displays add config page links for available types.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request object.
   *
   * @return array
   *   A render array for a list of the config page types that can be added or
   *   if there is only one config page type defined for the site, the function
   *   returns the config page add page for that config page type.
   */
  public function add(Request $request) {
    $types = $this->ConfigPagesTypeStorage->loadMultiple();
    if ($types && count($types) == 1) {
      $type = reset($types);
      return $this->addForm($type, $request);
    }
    if (count($types) === 0) {
      return array(
        '#markup' => $this->t('You have not created any block types yet. Go to the <a href="!url">block type creation page</a> to add a new block type.', [
          '!url' => Url::fromRoute('config_pages.type_add')->toString(),
        ]),
      );
    }

    return array('#theme' => 'config_pages_add_list', '#content' => $types);
  }

  /**
   * Presents the config page creation form.
   *
   * @param \Drupal\config_pages\ConfigPagesTypeInterface $config_pages_type
   *   The config page type to add.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request object.
   *
   * @return array
   *   A form array as expected by drupal_render().
   */
  public function addForm(ConfigPagesTypeInterface $config_pages_type, Request $request) {
    $config_page = $this->ConfigPagesStorage->create(array(
      'type' => $config_pages_type->id()
    ));
    if (($theme = $request->query->get('theme')) && in_array($theme, array_keys($this->themeHandler->listInfo()))) {
      // We have navigated to this page from the block library and will keep track
      // of the theme for redirecting the user to the configuration page for the
      // newly created block in the given theme.
      $config_page->setTheme($theme);
    }
    return $this->entityFormBuilder()->getForm($config_page);
  }

  /**
   * Provides the page title for this controller.
   *
   * @param \Drupal\config_pages\ConfigPagesTypeInterface $config_pages_type
   *   The config page type being added.
   *
   * @return string
   *   The page title.
   */
  public function getAddFormTitle(ConfigPagesTypeInterface $config_pages_type) {
    return $this->t('Add %type config page', array('%type' => $config_pages_type->label()));
  }

}
