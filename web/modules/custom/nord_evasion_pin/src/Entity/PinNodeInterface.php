<?php

namespace Drupal\nord_evasion_pin\Entity;

use Drupal\node\NodeInterface;

interface PinNodeInterface extends PinInterface, NodeInterface {
  public const NODE_BUNDLE = 'pin';

  public const FIELD_DISPLAYED_ON = 'field_displayed_on';
}
