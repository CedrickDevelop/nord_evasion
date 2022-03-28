<?php

namespace Drupal\nord_evasion_global\Manager;

use Drupal\nord_evasion_global\Entity\ActiveNatureTermInterface;
use Drupal\nord_evasion_global\Gateway\ActiveNatureGatewayInterface;

class ActiveNatureManager {

  public function __construct(protected readonly ActiveNatureGatewayInterface $activeNatureGateway) {
  }

  /**
   * @return ActiveNatureTermInterface[]
   */
  public function getTermsForThematics(): array {
    return $this->activeNatureGateway->getAllTerms();
  }
}
