<?php

namespace Drupal\nord_evasion_event\Gateway;

use DateTime;
use Drupal\adimeo_abstractions\BreadcrumbBuilder\Composition\GetNodeBundleTrait;
use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeItemInterface;
use Drupal\node\NodeInterface;
use Drupal\nord_evasion_event\Entity\EventNodeInterface;
use Drupal\nord_evasion_event\Form\EventFiltersInterface;
use Drupal\nord_evasion_global\Gateway\GetGatewayLanguageDependencyTrait;
use Drupal\nord_evasion_global\Gateway\GetNodeStorageDependencyTrait;

trait FilteredEventGatewayTrait {

  use GetGatewayLanguageDependencyTrait;
  use GetNodeStorageDependencyTrait;
  use GetNodeBundleTrait;

  public function getFilteredEventList(EventFiltersInterface $eventFilterDTO): ?array {
    $nids = $this->getFilteredEventListNids($eventFilterDTO);
    return $this->getLanguageService()->loadMultiple('node', $nids);
  }

  protected function getFilteredEventListNids(EventFiltersInterface $eventFilterFormDTO): array|int {
    $query = $this->getBaseQueryForFilteredEventsList($eventFilterFormDTO);
    if ($eventFilterFormDTO->isPaged()) {
      $query->pager($eventFilterFormDTO->getNumberOfElementsDisplayed());
    }
    else {
      $query->range(0, $eventFilterFormDTO->getNumberOfElementsDisplayed());
    }
    return $query->execute();
  }

  public function getFilteredEventListCount(EventFiltersInterface $eventFilterFormDTO): int {
    $query = $this->getBaseQueryForFilteredEventsList($eventFilterFormDTO);
    return $query->count()->execute();
  }

  protected function getBaseQueryForFilteredEventsList(EventFiltersInterface $eventFilterFormDTO): QueryInterface {
    $query = $this->getNodeStorage()->getQuery();
    $query->condition('status', NodeInterface::PUBLISHED)
      ->condition('type', self::getNodeBundle())
      ->sort(EventNodeInterface::FIELD_START_DATE);

    if (!empty($eventFilterFormDTO->getEventTypes())) {
      $query->condition(EventNodeInterface::FIELD_EVENT_TYPE, $eventFilterFormDTO->getEventTypes(), 'IN');
    }
    if (!empty($eventFilterFormDTO->getDestinations())) {
      $query->condition(EventNodeInterface::FIELD_DESTINATION, $eventFilterFormDTO->getDestinations(), 'IN');
    }

    $date = $eventFilterFormDTO->getFromDate()->format(DateTimeItemInterface::DATE_STORAGE_FORMAT);
    $orGroup = $query->orConditionGroup()
      ->condition(EventNodeInterface::FIELD_END_DATE, $date, '>=')
      ->condition(EventNodeInterface::FIELD_START_DATE, $date, '>=');
    $query->condition($orGroup);

    return $query;
  }

}
