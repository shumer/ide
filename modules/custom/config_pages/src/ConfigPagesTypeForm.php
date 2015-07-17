<?php

/**
 * @file
 * Contains \Drupal\config_pages\ConfigPagesTypeForm.
 */

namespace Drupal\config_pages;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\language\Entity\ContentLanguageSettings;
use Drupal\config_pages\Entity\ConfigPages;

/**
 * Base form for category edit forms.
 */
class ConfigPagesTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /* @var \Drupal\config_pages\ConfigPagesTypeInterface $config_pages_type */
    $config_pages_type = $this->entity;

    $form['label'] = array(
      '#type' => 'textfield',
      '#title' => t('Label'),
      '#maxlength' => 255,
      '#default_value' => $config_pages_type->label(),
      '#description' => t("Provide a label for this config page type to help identify it in the administration pages."),
      '#required' => TRUE,
    );
    $form['id'] = array(
      '#type' => 'machine_name',
      '#default_value' => $config_pages_type->id(),
      '#machine_name' => array(
        'exists' => '\Drupal\config_pages\Entity\ConfigPagesType::load',
      ),
      '#maxlength' => EntityTypeInterface::BUNDLE_MAX_LENGTH,
      '#disabled' => !$config_pages_type->isNew(),
    );

    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Save'),
    );

    $options = array();
    $items = \Drupal::service('plugin.manager.config_pages_context')->getDefinitions();

    foreach($items as $plugin_id => $item) {
      $options[$plugin_id] = $item['label'];
    }

    // Menu.
    $form['menu'] = array(
      '#type' => 'details',
      '#title' => t('Menu'),
      '#open' => TRUE,
    );

    $form['menu']['path'] = array(
      '#type' => 'textfield',
      '#description' => t('Consider following context for this configuration'),
      '#default_value' => !empty($config_pages_type->menu['path']) ? $config_pages_type->menu['path'] : array(),
      '#required' => FALSE,
    );

    // Context.
    $form['context'] = array(
      '#type' => 'details',
      '#title' => t('Context'),
      '#tree' => TRUE,
      '#open' => FALSE,
    );

    $form['context']['group'] = array(
      '#type' => 'checkboxes',
      '#description' => t('Consider following context for this configuration'),
      '#options' => $options,
      '#default_value' => !empty($config_pages_type->context['group']) ? $config_pages_type->context['group'] : array(),
      '#required' => FALSE,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $config_pages_type = $this->entity;
    $status = $config_pages_type->save();

    $edit_link = $this->entity->link($this->t('Edit'));
    $logger = $this->logger('config_pages');
    if ($status == SAVED_UPDATED) {
      drupal_set_message(t('Custom config page type %label has been updated.', array('%label' => $config_pages_type->label())));
      $logger->notice('Custom config page type %label has been updated.', array('%label' => $config_pages_type->label(), 'link' => $edit_link));
    }
    else {
      drupal_set_message(t('Custom config page type %label has been added.', array('%label' => $config_pages_type->label())));
      $logger->notice('Custom config page type %label has been added.', array('%label' => $config_pages_type->label(), 'link' => $edit_link));
    }

    $form_state->setRedirectUrl($this->entity->urlInfo('collection'));
  }

}
