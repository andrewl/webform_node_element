<?php

namespace Drupal\webform_node_element\Plugin\WebformElement;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Mail\MailFormatHelper;
use Drupal\webform\Plugin\WebformElement\WebformMarkupBase;

/**
 * Provides a 'webform_node_element' element.
 *
 * @WebformElement(
 *   id = "webform_node_element",
 *   label = @Translation("Node"),
 *   description = @Translation("Provides an element that renders a node"),
 *   category = @Translation("Markup elements"),
 *   states_wrapper = TRUE,
 * )
 */
class WebformNodeElement extends WebformMarkupBase {

  /**
   * {@inheritdoc}
   */
  public function getDefaultProperties() {
    return parent::getDefaultProperties() + [
      'markup' => '',
      'nid' => NULL,
    ];
  }

  /**
   * {@inheritdoc}
  public function buildText(array &$element, $value, array $options = []) {
    $element['#markup'] = MailFormatHelper::htmlToText("<h2>Hello, World!!!!!</h2>");
    return parent::buildText($element, $value, $options);
  }
   */

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $form['markup']['markup'] = [
      '#type' => 'webform_html_editor',
      '#title' => $this->t('HTML markup'),
      '#description' => $this->t('Enter custom HTML into your webform.'),
    ];
    $form['node_element'] = [
      '#title' => $this->t('Node Information'),
      '#type' => 'fieldset',
    ];
    $form['node_element']['nid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Node ID'),
      '#description' => $this->t('The ID of the node to render. Leave empty to listen to an event (tbd). Use a custom display mode called "webform_element".'),
    ];
    return $form;
  }

}
