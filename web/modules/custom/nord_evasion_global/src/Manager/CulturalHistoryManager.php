<?php

namespace Drupal\nord_evasion_global\Manager;

use Drupal\nord_evasion_global\Entity\CulturalHistoryTermInterface;
use Drupal\nord_evasion_global\Gateway\CulturalHistoryGatewayInterface;

class CulturalHistoryManager {

  public function __construct(
    protected readonly CulturalHistoryGatewayInterface $culturalHistoryGateway
  ) {

  }

  /**
   * @return CulturalHistoryTermInterface[]
   */
  public function getTermsForThematics(): array {
    return $this->culturalHistoryGateway->getAllTerms();
  }

}

