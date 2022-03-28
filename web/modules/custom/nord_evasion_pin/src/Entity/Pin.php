<?php

namespace Drupal\nord_evasion_pin\Entity;

use Drupal\Core\Field\FieldItemList;
use Drupal\node\Entity\Node;
use Drupal\nord_evasion_pin\PinDisplayedOnEnum;

class Pin extends Node implements PinNodeInterface {

  public function getDisplayedOn(): array {
    /** @var FieldItemList $field */
    $field = $this->get(PinNodeInterface::FIELD_DISPLAYED_ON);
    return array_map(function($val) { return PinDisplayedOnEnum::from($val['value']); }, $field->getValue());
  }

}
