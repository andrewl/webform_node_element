<?php

namespace Drupal\webform_node_element\Element;

use Drupal\Core\Render\Element\RenderElement;

/**
 * Provides a render element for webform markup.
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
   * Adds form-specific attributes to a 'date' #type element.
   *
   * @param array $element
   *   An associative array containing the properties of the element.
   *
   * @return array
   *   The $element with prepared variables ready for #theme 'input__time'.
   */
  public static function preRenderWebformNodeElement(array $element) {
    $nodeid = 11496;
    $node = \Drupal::entityManager()->getStorage('node')->load($nodeid);
    $view_builder = \Drupal::entityManager()->getViewBuilder('node');
    $renderarray = $view_builder->view($node, 'full');
    $html = \Drupal::service('renderer')->renderRoot($renderarray);
    $element['#markup'] = $html;
    return $element;
  }

}
