<?php

/**
 * @file
 * Contains Drupal\mks_custom_entity\Entity\Form\MKSCustomEntitySettingsForm.
 */

namespace Drupal\mks_custom_entity\Entity\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class MKSCustomEntitySettingsForm.
 *
 * @package Drupal\mks_custom_entity\Form
 *
 * @ingroup mks_custom_entity
 */
class MKSCustomEntitySettingsForm extends FormBase {
  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'MKSCustomEntity_settings';
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implementation of the abstract submit class.
  }


  /**
   * Define the form used for MKSCustomEntity  settings.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   Form definition array.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['MKSCustomEntity_settings']['#markup'] = 'Settings form for MKSCustomEntity. Manage field settings here.';
    return $form;
  }

}
