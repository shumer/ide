<?php
namespace Drupal\ide_common\Plugin\Block;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block
 *
 * @Block(
 *   id = "ide_common_banner_block",
 *   admin_label = @Translation("Front page banner"),
 * )
 */
class IdeBannerBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['ide_common_banner_block_text'])) {
      $text = $config['ide_common_banner_block_text'];
    }
    else {
      $text = $this->t('Default text');
    }
    return array(
      '#prefix' => '<div id="banner">',
      '#markup' => $this->t($text),
      '#suffix' => '</div>',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['ide_common_banner_block_text'] = array (
      '#type' => 'textarea',
      '#title' => $this->t('Text'),
      '#description' => $this->t('Text to show in banner on front page.'),
      '#default_value' => isset($config['ide_common_banner_block_text']) ? $config['ide_common_banner_block_text'] : ''
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('ide_common_banner_block_text', $form_state->getValue('ide_common_banner_block_text'));
  }

} 