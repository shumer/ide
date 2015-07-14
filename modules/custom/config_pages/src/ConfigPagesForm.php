<?php

/**
 * @file
 * Contains \Drupal\config_pages\ConfigPagesForm.
 */

namespace Drupal\config_pages;

use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for the custom config page edit forms.
 */
class ConfigPagesForm extends ContentEntityForm {

  /**
   * The custom config page storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $ConfigPagesStorage;

  /**
   * The custom config page type storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $ConfigPagesTypeStorage;

  /**
   * The language manager.
   *
   * @var \Drupal\Core\Language\LanguageManagerInterface
   */
  protected $languageManager;

  /**
   * The config page content entity.
   *
   * @var \Drupal\config_pages\ConfigPagesInterface
   */
  protected $entity;

  /**
   * Constructs a ConfigPagesForm object.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   * @param \Drupal\Core\Entity\EntityStorageInterface $config_pages_storage
   *   The custom config page storage.
   * @param \Drupal\Core\Entity\EntityStorageInterface $config_pages_type_storage
   *   The custom config page type storage.
   * @param \Drupal\Core\Language\LanguageManagerInterface $language_manager
   *   The language manager.
   */
  public function __construct(EntityManagerInterface $entity_manager, EntityStorageInterface $config_pages_storage, EntityStorageInterface $config_pages_type_storage, LanguageManagerInterface $language_manager) {
    parent::__construct($entity_manager);
    $this->ConfigPagesStorage = $config_pages_storage;
    $this->ConfigPagesTypeStorage = $config_pages_type_storage;
    $this->languageManager = $language_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $entity_manager = $container->get('entity.manager');
    return new static(
      $entity_manager,
      $entity_manager->getStorage('config_pages'),
      $entity_manager->getStorage('config_pages_type'),
      $container->get('language_manager')
    );
  }

  /**
   * Overrides \Drupal\Core\Entity\EntityForm::prepareEntity().
   *
   * Prepares the custom config page object.
   *
   * Fills in a few default values, and then invokes
   * hook_config_pages_prepare() on all modules.
   */
  protected function prepareEntity() {
    $config_pages = $this->entity;
    // Set up default values, if required.
    $config_pages_type = $this->ConfigPagesTypeStorage->load($config_pages->bundle());
    if (!$config_pages->isNew()) {
      $config_pages->setRevisionLog(NULL);
    }
    // Always use the default revision setting.
    $config_pages->setNewRevision($config_pages_type->shouldCreateNewRevision());
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $config_pages = $this->entity;
    $account = $this->currentUser();

    if ($this->operation == 'edit') {
      $form['#title'] = $this->t('Edit custom config page %label', array('%label' => $config_pages->label()));
    }
    // Override the default CSS class name, since the user-defined custom config page
    // type name in 'TYPE-config-page-form' potentially clashes with third-party class
    // names.
    $form['#attributes']['class'][0] = 'config-page-' . Html::getClass($config_pages->bundle()) . '-form';

    return parent::form($form, $form_state, $config_pages);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $config_pages = $this->entity;

    // Save as a new revision if requested to do so.
    if (!$form_state->isValueEmpty('revision')) {
      $config_pages->setNewRevision();
    }

    $insert = $config_pages->isNew();
    $config_pages->save();
    $context = array('@type' => $config_pages->bundle(), '%info' => $config_pages->label());
    $logger = $this->logger('config_pages');
    $config_pages_type = $this->ConfigPagesTypeStorage->load($config_pages->bundle());
    $t_args = array('@type' => $config_pages_type->label(), '%info' => $config_pages->label());

    if ($insert) {
      $logger->notice('@type: added %info.', $context);
      drupal_set_message($this->t('@type %info has been created.', $t_args));
    }
    else {
      $logger->notice('@type: updated %info.', $context);
      drupal_set_message($this->t('@type %info has been updated.', $t_args));
    }

    if ($config_pages->id()) {
      $form_state->setValue('id', $config_pages->id());
      $form_state->set('id', $config_pages->id());
      if ($insert) {
        if (!$theme = $config_pages->getTheme()) {
          $theme = $this->config('system.theme')->get('default');
        }
        $form_state->setRedirect(
          'entity.config_pages.edit_form',
          array(
            'plugin_id' => 'config_pages:' . $config_pages->uuid(),
            'theme' => $theme,
          )
        );
      }
      else {
        $form_state->setRedirectUrl($config_pages->urlInfo('collection'));
      }
    }
    else {
      // In the unlikely case something went wrong on save, the config page will be
      // rebuilt and config page form redisplayed.
      drupal_set_message($this->t('The config page could not be saved.'), 'error');
      $form_state->setRebuild();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($this->entity->isNew()) {
      $exists = $this->ConfigPagesStorage->loadByProperties(array('info' => $form_state->getValue(['info', 0, 'value'])));
      if (!empty($exists)) {
        $form_state->setErrorByName('info', $this->t('A config page with description %name already exists.', array(
          '%name' => $form_state->getValue(array('info', 0, 'value')),
        )));
      }
    }
  }

}
