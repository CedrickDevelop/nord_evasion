<?php

namespace Drupal\nord_evasion_event\Manager;

use DateTime;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\nord_evasion_event\Form\EventFiltersInterface;
use Drupal\nord_evasion_global\Manager\DestinationManager;

class EventListResultsTitleManager {

  use StringTranslationTrait;

  const PATTERNS = [
    '0000' => EventListResultsTitlePatternsEnum::NoOrOneResultNoFilter,
    '0001' => EventListResultsTitlePatternsEnum::NoOrOneResultTypeFilter,
    '0010' => EventListResultsTitlePatternsEnum::NoOrOneResultDestinationFilter,
    '0011' => EventListResultsTitlePatternsEnum::NoOrOneResultTypeAndDestinationFilter,
    '0100' => EventListResultsTitlePatternsEnum::NoOrOneResultDateFilter,
    '0101' => EventListResultsTitlePatternsEnum::NoOrOneResultTypeAndDateFilter,
    '0110' => EventListResultsTitlePatternsEnum::NoOrOneResultDestinationAndDateFilter,
    '0111' => EventListResultsTitlePatternsEnum::NoOrOneResultTypeDestinationAndDateFilter,
    '1000' => EventListResultsTitlePatternsEnum::MoreThanOneResultNoFilter,
    '1001' => EventListResultsTitlePatternsEnum::MoreThanOneResultTypeFilter,
    '1010' => EventListResultsTitlePatternsEnum::MoreThanOneResultDestinationFilter,
    '1011' => EventListResultsTitlePatternsEnum::MoreThanOneResultTypeAndDestinationFilter,
    '1100' => EventListResultsTitlePatternsEnum::MoreThanOneResultDateFilter,
    '1101' => EventListResultsTitlePatternsEnum::MoreThanOneResultTypeAndDateFilter,
    '1110' => EventListResultsTitlePatternsEnum::MoreThanOneResultDestinationAndDateFilter,
    '1111' => EventListResultsTitlePatternsEnum::MoreThanOneResultTypeDestinationAndDateFilter,
  ];

  public function __construct(
    protected readonly EventTypeManager $eventTypeManager,
    protected readonly DestinationManager $destinationManager,
    protected readonly DateFormatter $DateFormatter
  ) {

  }

  public function getResultsTitle(
    EventFiltersInterface $eventFilterFormDTO,
    int                   $resultsNumber,
    DateTime              $compareFromWith = new Datetime()
  ): TranslatableMarkup {
    $pattern = $this->getPatternCaseFromEnum($eventFilterFormDTO, $resultsNumber, $compareFromWith);
    return $this->t($pattern->value, $this->getTranslationVariables($eventFilterFormDTO, $resultsNumber));
  }

  protected function getTranslationVariables(EventFiltersInterface $eventFilterFormDTO, int $resultsNumber) {
    $dateFormatter = $this->DateFormatter->format($eventFilterFormDTO->getFromDate()->getTimestamp(),'article_node');
    return [
      EventListResultsTitlePatternsEnum::TRANSLATION_VARIABLE_DATE => $dateFormatter,
      EventListResultsTitlePatternsEnum::TRANSLATION_VARIABLE_DESTINATION => $this->getDestinationLabel($eventFilterFormDTO->getSingleDestination()),
      // todo same as above
      EventListResultsTitlePatternsEnum::TRANSLATION_VARIABLE_EVENT_TYPE => $this->getEventTypeLabel($eventFilterFormDTO->getSingleEventType()),
      EventListResultsTitlePatternsEnum::TRANSLATION_VARIABLE_RESULTS_NUMBER => $resultsNumber
    ];
  }

  protected function getPatternCaseFromEnum(EventFiltersInterface $eventFilterFormDTO, int $resultsNumber, DateTime $compareFromWith): EventListResultsTitlePatternsEnum {
    $patternKey = $this->computePatternKey($eventFilterFormDTO, $resultsNumber, $compareFromWith);
    return self::PATTERNS[$patternKey];
  }

  /**
   * The key is the one used in the PATTERNS constant.
   * implode() on int will cast each one of them as string, so [(int) FALSE, (int) TRUE] will return '01'
   *
   * @param \Drupal\nord_evasion_event\Form\EventFiltersInterface $eventFilterFormDTO
   * @param int $resultsNumber
   * @param \DateTime $compareFromWith
   *
   * @return string
   */
  protected function computePatternKey(EventFiltersInterface $eventFilterFormDTO, int $resultsNumber, DateTime $compareFromWith): string {
    return implode('', [
      (int) $this->hasMoreThanOneResult($resultsNumber),
      (int) $this->hasActiveDateFilter($eventFilterFormDTO, $compareFromWith),
      (int) $this->hasActiveDestinationFilter($eventFilterFormDTO),
      (int) $this->hasActiveEventTypeFilter($eventFilterFormDTO)
    ]);
  }

  protected function hasMoreThanOneResult(int $resultsNumber): bool {
    return $resultsNumber > 1;
  }

  protected function formatPlural($count, $singular, $plural, array $args = [], array $options = []) {
  }

  protected function hasActiveDateFilter(EventFiltersInterface $eventFilterFormDTO, DateTime $compareFromWith): bool {
    return $eventFilterFormDTO->getFromDate()->format('Y-m-d') == $compareFromWith->format('Y-m-d');
  }

  protected function hasActiveDestinationFilter(EventFiltersInterface $eventFilterFormDTO): bool {
    return $eventFilterFormDTO->getSingleDestination() !== NULL;
  }

  protected function hasActiveEventTypeFilter(EventFiltersInterface $eventFilterFormDTO): bool {
    return $eventFilterFormDTO->getSingleEventType() !== NULL;
  }

  protected function getDestinationLabel(int|null $tid): string|TranslatableMarkup|null {
    return $tid ? $this->destinationManager->getDestinationLabel($tid) : NULL;
  }

  protected function getEventTypeLabel(mixed $eventTypeId): string|TranslatableMarkup|null {
    return $eventTypeId ? $this->eventTypeManager->getEventTypeLabel($eventTypeId) : NULL;
  }

}
