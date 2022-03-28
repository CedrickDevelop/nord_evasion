<?php

namespace Drupal\nord_evasion_event\Gateway;

use Drupal\nord_evasion_event\Form\EventFiltersInterface;

interface EventGatewayInterface {

  public function getFilteredEventList(EventFiltersInterface $eventFilterDTO);

  public function getFilteredEventListCount(EventFiltersInterface $eventFilterFormDTO): int;

}
