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

    $form['description'] = array(
      '#type' => 'textarea',
      '#default_value' => $config_pages_type->getDescription(),
      '#description' => t('Enter a description for this config page type.'),
      '#title' => t('Description'),
    );

    $form['revision'] = array(
      '#type' => 'checkbox',
      '#title' => t('Create new revision'),
      '#default_value' => FALSE,
      '#access' => False,
      '#description' => t('Create a new revision by default for this config page type.')
    );

    if ($this->moduleHandler->moduleExists('language')) {
      $form['language'] = array(
        '#type' => 'details',
        '#title' => t('Language settings'),
        '#group' => 'additional_settings',
      );

      $language_configuration = ContentLanguageSettings::loadByEntityTypeBundle('config_pages', $config_pages_type->id());
      $form['language']['language_configuration'] = array(
        '#type' => 'language_configuration',
        '#entity_information' => array(
          'entity_type' => 'config_pages',
          'bundle' => $config_pages_type->id(),
        ),
        '#default_value' => $language_configuration,
      );

      $form['#submit'][] = 'language_configuration_element_submit';
    }

    $form['actions'] = array('#type' => 'actions');
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Save'),
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
