<?php

namespace Drupal\nord_evasion_404_403\Gateway;

use Drupal\nord_evasion_404_403\Entity\ErrorPageNodeInterface;

interface ErrorPageGatewayInterface {
  public function getErrorPage(): ?ErrorPageNodeInterface;
}
