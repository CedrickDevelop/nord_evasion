<?php

namespace Drupal\nord_evasion_event\Form;

use DateTime;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\nord_evasion_global\Manager\ExtractTargetIdsFromEntityReferenceListTrait;

class AgendaParagraphEventFilters implements EventFiltersInterface {

  use ExtractTargetIdsFromEntityReferenceListTrait;

  protected const ELEMENTS_DISPLAYED_NUMBER = 3;

  protected DateTime $fromDate;

  protected array $destinations;

  protected array $eventTypes;

  public function __construct(FieldItemListInterface $rawDestinations, FieldItemListInterface $rawEventTypes) {
    $this->fromDate = new DateTime();
    $this->destinations = $this->extractTargetIdsFromEntityReferenceList($rawDestinations);
    $this->eventTypes = $this->extractTargetIdsFromEntityReferenceList($rawEventTypes);
  }

  public function getFromDate(): DateTime {
    return $this->fromDate;
  }

  public function getDestinations(): array {
    return $this->destinations;
  }

  public function getEventTypes(): array {
    return $this->eventTypes;
  }

  public function getNumberOfElementsDisplayed(): int {
    return self::ELEMENTS_DISPLAYED_NUMBER;
  }

  public function isPaged(): bool {
    return FALSE;
  }

  public function getFromDay(): int {
    return 0; // unused in this situation (could be set with 2 interfaces)
  }

  public function getFromMonth(): int {
    return 0; // unused in this situation (could be set with 2 interfaces)
  }

  public function getFromYear(): int {
    return 0; // unused in this situation (could be set with 2 interfaces)
  }

  public function getSingleDestination(): ?string {
    return ''; // unused in this situation (could be set with 2 interfaces)
  }

  public function getSingleEventType(): ?string {
    return ''; // unused in this situation (could be set with 2 interfaces)
  }

}
