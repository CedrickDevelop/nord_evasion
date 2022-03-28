<?php

namespace Drupal\nord_evasion_event\Manager;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\nord_evasion_event\Entity\EventTypeTermInterface;
use Drupal\nord_evasion_event\Gateway\EventTypeGatewayInterface;
use Drupal\nord_evasion_global\Gateway\FetchAllTermsByWeightInterface;
use Drupal\nord_evasion_global\Manager\GetTaxonomyTermsForOptionDisplayTrait;
use Drupal\taxonomy\TermStorageInterface;

class EventTypeManager {

  use GetTaxonomyTermsForOptionDisplayTrait;

  protected TermStorageInterface $termStorage;

  public function __construct(
    protected readonly EventTypeGatewayInterface $eventTypeGateway,
    protected readonly EntityTypeManagerInterface $entityTypeManager
  ) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->termStorage = $this->entityTypeManager->getStorage('taxonomy_term');
  }

  protected function getFetchAllTermsByWeightGateway(): FetchAllTermsByWeightInterface {
    return $this->eventTypeGateway;
  }

  public function getEventTypeLabel(int $tid): string|TranslatableMarkup|null {
    return $this->termStorage->load($tid)->label();
  }

  public function getEventTypeByLabel(string $label): ?EventTypeTermInterface {
    return $this->eventTypeGateway->getTermByLabel($label);
  }

}
