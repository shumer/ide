<?php

/**
 * @file
 * Contains \Drupal\config_pages\Plugin\Block\ConfigPagesBlock.
 */

namespace Drupal\config_pages\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\config_pages\Entity\ConfigPages;
use Drupal\config_pages\Entity\ConfigPagesType;
use Drupal\Core\Config\Entity\Query\Query;
use Drupal\Component\Utility\Xss;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a generic ConfigPages block.
 *
 * @Block(
 *   id = "config_pages_block",
 *   admin_label = @Translation("ConfigPages Block"),
 * )
 */
class ConfigPagesBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['config_page_type'])) {
      $config_page = ConfigPages::config($config['config_page_type']);
      $build = \Drupal::entityManager()->getViewBuilder('config_pages')
        ->view($config_page, 'full', NULL);
      return $build;
    }

    return array();
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $settings = parent::defaultConfiguration();

    if ($this->displaySet) {
      $settings += $this->view->display_handler->blockSettings($settings);
    }

    // Set custom cache settings.
    if (isset($this->pluginDefinition['cache'])) {
      $settings['cache'] = $this->pluginDefinition['cache'];
    }

    return $settings;
  }

  /**
   * {@inheritdoc}
   */
  public function getMachineNameSuggestion() {
    return 'config_pages';
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();
    $config_pages_types = ConfigPagesType::loadMultiple();
    $options = array();
    foreach ($config_pages_types as $cp_type) {
      $id = $cp_type->id();
      $label = $cp_type->label();
      $options[$id] = $label;
    }
    $form['config_page_type'] = array (
      '#type' => 'select',
      '#title' => $this->t('Select ConfigPage type to show'),
      '#description' => $this->t('Text to show in banner on front page.'),
      '#options' => $options,
      '#default_value' => isset($config['config_page_type']) ? $config['config_page_type'] : ''
    );

    return $form;
  }


  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('config_page_type', $form_state->getValue('config_page_type'));
  }

}
