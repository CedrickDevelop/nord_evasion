<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\nord_evasion_global\Entity\DestinationTermInterface;

interface DestinationGatewayInterface {

  /**
   * @return DestinationTermInterface[]
   */
  public function getAllTerms(): array;
}
