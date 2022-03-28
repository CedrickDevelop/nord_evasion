<?php

namespace Drupal\nord_evasion_event\Form;

use DateTime;

interface EventFiltersInterface {

  public function getFromDate(): DateTime;

  public function getFromDay(): int;

  public function getFromMonth(): int;

  public function getFromYear(): int;

  public function getSingleDestination(): ?string;

  /**
   * @return int[]
   */
  public function getDestinations(): array;

  public function getSingleEventType(): ?string;

  /**
   * @return int[]
   */
  public function getEventTypes(): array;

  public function getNumberOfElementsDisplayed(): int;

  public function isPaged(): bool;

}
