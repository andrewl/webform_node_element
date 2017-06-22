<?php

namespace Drupal\webform_node_element\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\webform_node_element\Event\DynamicNIDEvent;

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

    $nid = $element['#nid'];

    // If a nid has node been set then allow event subscribers to set the nid.
    if (empty($nid)) {
      $dispatcher = \Drupal::service('event_dispatcher');
      $event = new DynamicNidEvent();
      $dispatcher->dispatch(DynamicNidEvent::PRERENDER, $event);
      $nid = $event->getNid();
    }

    if ($nid) {
      $node = \Drupal::entityManager()->getStorage('node')->load($nid);
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
