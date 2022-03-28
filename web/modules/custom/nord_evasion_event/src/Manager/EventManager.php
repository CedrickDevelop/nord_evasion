<?php

namespace Drupal\nord_evasion_event\Manager;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\node\NodeInterface;
use Drupal\nord_evasion_event\Entity\EventInterface;
use Drupal\nord_evasion_event\Entity\EventNodeInterface;
use Drupal\nord_evasion_event\Form\EventFiltersInterface;
use Drupal\nord_evasion_event\Gateway\EventGatewayInterface;

class EventManager {

  # VARIABLES
  protected const EVENT_DATES = 'event_dates';

  protected const START_DATE = 'start_date';

  protected const END_DATE = 'end_date';

  # FIELDS
  const VIEW_MODE_LIST = 'teaser';

  const VIEW_PARAGRAPH_AGENDA = 'paragraph_agenda';

  # TWIG VARIABLES
  protected const CALENDAR_LINK = 'calendar_link_dates';

  protected EntityViewBuilderInterface $viewBuilder;


  public function __construct(
    protected readonly EntityTypeManagerInterface $entityTypeManager,
    protected readonly EventGatewayInterface $eventGateway,
  ) {
    $this->viewBuilder = $entityTypeManager->getViewBuilder('node');
  }

  public function addEventVariablesToPreprocessNode($variables): array {
    if (!$this->isNodeOfCurrentBundle($variables)) {
      return $variables;
    }

    $event = $this->getEventNodeFromVariables($variables);

    $variables[self::CALENDAR_LINK] = $this->addCalendarLinkDates($event);

    return $variables;
  }

  protected function isNodeOfCurrentBundle($variables): bool {
    $currentNode = $this->getEventNodeFromVariables($variables);
    return $currentNode instanceof EventInterface;
  }

  protected function getEventNodeFromVariables($variables): ?NodeInterface {
    return $variables['node'] ?: NULL;
  }

  protected function addCalendarLinkDates(EventNodeInterface $event): array {
    return [
      self::START_DATE => $event->getStartDate(),
      self::END_DATE => $event->getEndDate(),
    ];
  }

  public function getFilteredEventsRenderArray(EventFiltersInterface $eventFilterDTO): array {
    $events = $this->eventGateway->getFilteredEventList($eventFilterDTO);
    return $this->viewBuilder->viewMultiple($events, self::VIEW_MODE_LIST);
  }

  public function getFilteredEventsTotalCount(EventFiltersInterface $eventFilterFormDTO): int {
    return $this->eventGateway->getFilteredEventListCount($eventFilterFormDTO);
  }

  public function getAgendaParagraphEventsRenderArray(EventFiltersInterface $eventFilterDTO): array {
    $events = $this->eventGateway->getFilteredEventList($eventFilterDTO);
    return $this->viewBuilder->viewMultiple($events, self::VIEW_PARAGRAPH_AGENDA);
  }

}
