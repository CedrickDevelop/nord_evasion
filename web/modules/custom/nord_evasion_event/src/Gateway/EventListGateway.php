<?php

namespace Drupal\nord_evasion_event\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeStorageInterface;
use Drupal\nord_evasion_event\Entity\EventListNodeInterface;
use Drupal\nord_evasion_global\Gateway\GetLastChangedPublishedNodeTrait;

class EventListGateway implements EventListGatewayInterface {

  use GetLastChangedPublishedNodeTrait;

  protected EntityStorageInterface $nodeStorage;

  public function __construct(
    protected EntityTypeManagerInterface $entityTypeManager,
    protected readonly LanguageService $languageService
  ) {
    $this->nodeStorage = $this->entityTypeManager->getStorage('node');
  }

  public function getLastModifiedPublishedEventList(): ?EventListNodeInterface {
    /** @var EventListNodeInterface $eventList */
    $eventList = $this->getLastModifiedPublishedNode();
    return $eventList;
  }

  protected function getNodeBundle(): string {
    return EventListNodeInterface::NODE_BUNDLE;
  }

  protected function getLanguageService(): LanguageService {
    return $this->languageService;
  }

  protected function getNodeStorage(): NodeStorageInterface {
    return $this->nodeStorage;
  }

}
