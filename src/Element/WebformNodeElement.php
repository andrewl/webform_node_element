<?php

namespace Drupal\webform_node_element\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a render element to display a node.
 *
 * @FormElement("webform_node_element")
 */
class WebformNodeElement extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#pre_render' => [[$class, "preRenderWebformNodeElement"]],
      '#nid' => NULL,
    ];
  }

  /**
   * Add the rendered node to the element.
   *
   * @param array $element
   *   An associative array containing the properties of the element.
   *
   * @return array
   *   The $element.
   */
  public static function preRenderWebformNodeElement(array $element) {
    $element['#markup'] = "";

    // @todo - if nid is not set use an event to get it?
    if (!empty($element['#nid'])) {
      $nodeid = $element['#nid'];
    }

    if ($nodeid) {
      $node = \Drupal::entityManager()->getStorage('node')->load($nodeid);
      $view_builder = \Drupal::entityManager()->getViewBuilder('node');

      if ($node && $view_builder) {
        if ($render_array = $view_builder->view($node, 'webform_element')) {
          $element['#markup'] = \Drupal::service('renderer')->renderRoot($render_array);
        }
      }
    }

    return $element;
  }

}
