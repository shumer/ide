<?php

/**
 * @file
 * Contains m_k_s_custom_entity.page.inc.
 *
 * MKSCustomEntity page callback file for the m_k_s_custom_entity entity.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for m_k_s_custom_entity templates.
 *
 * Default template: m_k_s_custom_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_m_k_s_custom_entity(array &$variables) {
  // Fetch MKSCustomEntity Entity Object.
  $m_k_s_custom_entity = $variables['elements']['#m_k_s_custom_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
