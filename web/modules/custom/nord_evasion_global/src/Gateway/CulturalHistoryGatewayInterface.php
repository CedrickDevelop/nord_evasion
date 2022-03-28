<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\nord_evasion_global\Entity\CulturalHistoryTermInterface;

interface CulturalHistoryGatewayInterface {

  /**
   * @return CulturalHistoryTermInterface[]
   */
  public function getAllTerms(): array;
}
