<?php

namespace Drupal\nord_evasion_event\Entity;

use DateTime;
use Drupal\node\Entity\Node;
use Drupal\nord_evasion_global\Manager\DateRangeDisplayTrait;

class Event extends Node implements EventNodeInterface {

  use DateRangeDisplayTrait;

  /**
   * @throws \Exception
   */
  public function getStartDate(): ?DateTime {
    $dateString = $this->get(EventNodeInterface::FIELD_START_DATE)->value;
    return $dateString ? new DateTime($dateString) : NULL;
  }

  /**
   * @throws \Exception
   */
  public function getEndDate(): ?DateTime {
    $dateString = $this->get(EventNodeInterface::FIELD_END_DATE)->value;
    return $dateString ? new DateTime($dateString) : NULL;
  }

  /**
   * @throws \Exception
   */
  public function getDateRange(): string {
    return $this->getDisplayedDateRangeFromDateTime($this->getStartDate(), $this->getEndDate());
  }

}
