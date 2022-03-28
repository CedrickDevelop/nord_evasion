<?php

namespace Drupal\nord_evasion_pin\Gateway;

use Drupal\nord_evasion_pin\Entity\PinNodeInterface;

interface PinGatewayInterface {
  public function getLastModifiedPublishedPin(): ?PinNodeInterface;
}
