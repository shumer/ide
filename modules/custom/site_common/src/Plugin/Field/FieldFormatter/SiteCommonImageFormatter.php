<?php
namespace Drupal\site_common\Plugin\Field\FieldFormatter;

use  Drupal\image\Plugin\Field\FieldFormatter\ImageFormatter;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;
use Drupal\Core\Utility\LinkGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Cache\Cache;

/**
 * Plugin implementation of the 'ide_common_image' formatter.
 *
 * @FieldFormatter(
 *   id = "site_common_image",
 *   label = @Translation("Site Common Image"),
 *   field_types = {
 *     "image",
 *   },
 *   settings = {
 *    "deltas" = "",
 *   }
 * )
 */
class SiteCommonImageFormatter extends ImageFormatter {

  /**
   * Constructs an ImageFormatter object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings settings.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Utility\LinkGeneratorInterface $link_generator
   *   The link generator service.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, AccountInterface $current_user, LinkGeneratorInterface $link_generator, EntityStorageInterface $image_style_storage) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings, $current_user, $link_generator, $image_style_storage);
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'deltas' => '',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $image_styles = image_style_options(FALSE);

    $image_style_setting = $this->getImageStyleSuggestion();
    if (!isset($image_styles[$image_style_setting])) {
      $image_style_setting = "";
    }

    // Preset value cannot be changed.
    $element['image_style'] = array(
      '#type' => 'value',
      '#value' => $image_style_setting,
    );
    $link_types = array(
      'content' => t('Content'),
      'file' => t('File'),
    );
    $element['image_link'] = array(
      '#title' => t('Link image to'),
      '#type' => 'select',
      '#default_value' => $this->getSetting('image_link'),
      '#empty_option' => t('Nothing'),
      '#options' => $link_types,
    );
    $element['deltas'] = array(
      '#type' => 'number',
      '#title' => t('Number of items to render'),
      '#default_value' => $this->getSetting('deltas'),
      '#min' => 0,
    );

    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = array();

    $image_styles = image_style_options(FALSE);

    // Unset possible 'No defined styles' option.
    unset($image_styles['']);

    // Styles could be lost because of enabled/disabled modules that defines
    // their styles in code.
    $image_style_suggestion = $this->getImageStyleSuggestion();
    $summary[] = t('Image style suggested: @style', ['@style' => $image_style_suggestion]);

    $image_style_setting = $this->getSetting('image_style');
    if (isset($image_styles[$image_style_setting])) {
      $summary[] = t('Image style: @style', array('@style' => $image_styles[$image_style_setting]));
    }
    else {
      $summary[] = t('Original image');
    }

    $link_types = array(
      'content' => t('Linked to content'),
      'file' => t('Linked to file'),
    );

    // Display this setting only if image is linked.
    $image_link_setting = $this->getSetting('image_link');
    if (isset($link_types[$image_link_setting])) {
      $summary[] = $link_types[$image_link_setting];
    }

    $deltas = $this->getSetting('deltas');
    if (!empty($deltas)) {
      $summary[] = t('Number of items to show: @deltas', ['@deltas' => $deltas]);
    }


    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items) {

    $elements = parent::viewElements($items);
    $deltas = $this->getSetting('deltas');

    if (is_numeric($deltas) && $deltas < count($elements)) {
      return array_slice($elements, 0, $deltas);
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   * Helper function.
   * Get image style name suggestions.
   */
  public function getImageStyleSuggestion() {
    $instance = $this->fieldDefinition;
    $view_mode = $this->viewMode;

    if ($view_mode == 'default') {
      $view_mode = 'full';
    }

    $style = implode('__', array_filter(array($instance->getTargetEntityTypeId(), $instance->getName(), $view_mode)));
    return $style;
  }

}
