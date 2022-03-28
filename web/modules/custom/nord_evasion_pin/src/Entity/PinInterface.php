<?php

namespace Drupal\nord_evasion_pin\Entity;

use Drupal\nord_evasion_pin\PinDisplayedOnEnum;

interface PinInterface {

  /**
   * @return PinDisplayedOnEnum[]
   */
  public function getDisplayedOn(): array;
}
