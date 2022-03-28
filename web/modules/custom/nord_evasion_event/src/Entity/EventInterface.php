<?php

namespace Drupal\nord_evasion_event\Entity;

interface EventInterface {

  public const SEARCH_RESULT_TYPE = 'Agenda';

  public function getStartDate(): ?\DateTime;

  public function getEndDate(): ?\DateTime;

}
