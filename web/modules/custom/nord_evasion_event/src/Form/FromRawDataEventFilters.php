<?php

namespace Drupal\nord_evasion_event\Form;

use DateTime;

class FromRawDataEventFilters implements EventFiltersInterface {

  protected const GET_PARAMETER_FROM_DAY = EventListFilterForm::FIELD_FROM_DAY;

  protected const GET_PARAMETER_FROM_MONTH = EventListFilterForm::FIELD_FROM_MONTH;

  protected const GET_PARAMETER_FROM_YEAR = EventListFilterForm::FIELD_FROM_YEAR;

  protected const TO_INT_PARAMETERS = [
    self::GET_PARAMETER_FROM_DAY,
    self::GET_PARAMETER_FROM_MONTH,
    self::GET_PARAMETER_FROM_YEAR,
  ];

  const GET_PARAMETER_DESTINATION = EventListFilterForm::FIELD_DESTINATION;

  const GET_PARAMETER_EVENT_TYPE = EventListFilterform::FIELD_EVENT_TYPE;

  protected array $data;

  protected ?DateTime $fromDateTime;


  public function __construct(
    array          $rawRequestData = [],
    protected int  $numberOfElementsDisplayed = 15,
    protected bool $isPaged = FALSE
  ) {
    $this->data = $this->sanitizeValues($rawRequestData);
  }

  protected function sanitizeValues(array $data): array {
    foreach (self::TO_INT_PARAMETERS as $key) {
      if (!empty($data[$key])) {
        $data[$key] = (int) $data[$key];
      }
    }

    return $data;
  }

  public function getNumberOfElementsDisplayed(): int {
    return $this->numberOfElementsDisplayed;
  }

  public function isPaged(): bool {
    return $this->isPaged;
  }

  public function getSingleDestination(): ?string {
    $destinations = $this->getDestinations();
    return reset($destinations) ?: NULL;
  }

  public function getDestinations(): array {
    return !empty($this->data[self::GET_PARAMETER_DESTINATION])
      ? [$this->data[self::GET_PARAMETER_DESTINATION]]
      : [];
  }

  public function getSingleEventType(): ?string {
    $eventTypes = $this->getEventTypes();
    return reset($eventTypes) ?: NULL;
  }

  public function getEventTypes(): array {
    return !empty($this->data[self::GET_PARAMETER_EVENT_TYPE])
      ? [$this->data[self::GET_PARAMETER_EVENT_TYPE]]
      : [];
  }

  public function getFromDay(): int {
    return (int) $this->getFromDate()->format('d');
  }

  public function getFromMonth(): int {
    return (int) $this->getFromDate()->format('m');
  }

  public function getFromYear(): int {
    return (int) $this->getFromDate()->format('Y');
  }

  public function getFromDate(): DateTime {
    if (empty($this->fromDateTime)) {
      $this->setFromDateTime();
    }

    return $this->fromDateTime;
  }

  protected function areAllFromFieldsValid(): bool {
    return $this->isFromDayValid()
      && $this->isFromMonthValid()
      && $this->isFromYearValid();
  }

  protected function isFromDayValid(): bool {
    return !empty($this->data[self::GET_PARAMETER_FROM_DAY])
      && $this->isValueComprisedBetween($this->data[self::GET_PARAMETER_FROM_DAY], 1, 31);
  }

  protected function isFromMonthValid(): bool {
    return !empty($this->data[self::GET_PARAMETER_FROM_MONTH])
      && $this->isValueComprisedBetween($this->data[self::GET_PARAMETER_FROM_MONTH], 1, 12);
  }

  protected function isFromYearValid(): bool {
    return !empty($this->data[self::GET_PARAMETER_FROM_YEAR])
      && $this->isValueComprisedBetween($this->data[self::GET_PARAMETER_FROM_YEAR], 1980, 2100);
  }

  protected function isValueComprisedBetween(int $value, int $min, int $max): bool {
    return $min <= $value && $value <= $max;
  }

  protected function setFromDateTime() {
    $this->fromDateTime = $this->areAllFromFieldsValid()
      ? $this->computeFromDateTime()
      : new DateTime();
  }

  protected function computeFromDateTime(): DateTime|bool {
    return DateTime::createFromFormat(
      'Y-m-d',
      sprintf(
        '%d-%d-%d',
        $this->data[self::GET_PARAMETER_FROM_YEAR],
        $this->data[self::GET_PARAMETER_FROM_MONTH],
        $this->data[self::GET_PARAMETER_FROM_DAY],
      )
    );
  }

}
