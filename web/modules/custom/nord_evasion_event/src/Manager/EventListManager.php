<?php

namespace Drupal\nord_evasion_event\Manager;

use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Http\RequestStack;
use Drupal\nord_evasion_event\Entity\EventListNodeInterface;
use Drupal\nord_evasion_event\Form\FromRawDataEventFilters;
use Drupal\nord_evasion_event\Form\EventFiltersInterface;
use Drupal\nord_evasion_event\Form\EventListFilterForm;
use Drupal\nord_evasion_event\Gateway\EventListGatewayInterface;

class EventListManager {

  public const FILTER_FORM_PREPROCESS_KEY = 'filter_form';

  const RESULTS_TITLE_PREPROCESS_KEY = 'results_title';

  const EVENT_LIST_PREPROCESS_KEY = 'filtered_event_list';

  const PAGER_PREPROCESS_KEY = 'pager';

  const EVENTS_PAGINATION = 15;

  public function __construct(
    protected readonly EventListGatewayInterface $eventListGateway,
    protected readonly EventManager $eventManager,
    protected readonly EventListResultsTitleManager $eventListResultsTitleManager,
    protected readonly FormBuilderInterface $formBuilder,
    protected readonly RequestStack $requestStack
  ) {

  }

  public function getCurrentEventList(): EventListNodeInterface {
    /** @var EventListNodeInterface $eventList */
    $eventList = $this->eventListGateway->getLastModifiedPublishedEventList();
    return $eventList;
  }

  public function addEventListVariablesToPreProcessNodeVariables(array $variables): array {
    if (!$this->isNodeOfCurrentBundle($variables)) {
      return $variables;
    }

    $eventFilterDTO = $this->getEventFiltersFromRequest();
    $resultsNumber = $this->eventManager->getFilteredEventsTotalCount($eventFilterDTO);

    $variables[self::FILTER_FORM_PREPROCESS_KEY] = $this->getFilterForm($eventFilterDTO);
    $variables[self::RESULTS_TITLE_PREPROCESS_KEY] = $this->eventListResultsTitleManager->getResultsTitle($eventFilterDTO, $resultsNumber);
    $variables[self::EVENT_LIST_PREPROCESS_KEY] = $this->eventManager->getFilteredEventsRenderArray($eventFilterDTO);

    $variables[self::PAGER_PREPROCESS_KEY] = [
      '#type' => 'pager',
    ];

    return $variables;
  }

  protected function isNodeOfCurrentBundle(array $variables): bool {
    /** @var \Drupal\node\NodeInterface $currentNode */
    $currentNode = $variables['node'];
    return $currentNode instanceof EventListNodeInterface;
  }

  protected function getFilterForm(EventFiltersInterface $eventFilters): array {
    return $this->formBuilder->getForm(EventListFilterForm::class, $eventFilters);
  }

  protected function getEventFiltersFromRequest(): EventFiltersInterface {
    $currentRequest = $this->requestStack->getCurrentRequest();
    $params = $currentRequest->query->all();
    return new FromRawDataEventFilters($params, self::EVENTS_PAGINATION, TRUE);
  }

}
