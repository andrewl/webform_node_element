<?php

namespace Drupal\webform_node_element\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 *
 */
class DynamicNidEvent extends Event {
  const PRERENDER = 'event.pre_render';

  protected $nid = NULL;

  /**
   *
   */
  public function __construct() {
  }

  /**
   *
   */
  public function setNid($nid) {
    $this->nid = $nid;
  }

  /**
   *
   */
  public function getNid() {
    return $nid;
  }

  /**
   *
   */
  public function DynamicNidEventDescription() {
    return "Enables a subscriber to set the NID of a webform_node_element";
  }

}
