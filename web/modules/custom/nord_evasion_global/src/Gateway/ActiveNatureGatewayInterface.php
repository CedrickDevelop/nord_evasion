<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\nord_evasion_global\Entity\ActiveNatureTermInterface;

interface ActiveNatureGatewayInterface {

  /**
   * @return ActiveNatureTermInterface[]
   */
  public function getAllTerms(): array;

}
