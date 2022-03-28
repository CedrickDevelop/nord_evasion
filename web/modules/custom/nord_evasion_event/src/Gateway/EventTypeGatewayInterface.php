<?php

namespace Drupal\nord_evasion_event\Gateway;

use Drupal\nord_evasion_event\Entity\EventTypeTermInterface;

interface EventTypeGatewayInterface {
  /**
   * @return EventTypeTermInterface[]
   */
  public function getAllTerms(): array;

  public function getTermByLabel(string $label);

}
