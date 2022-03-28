<?php

namespace Drupal\nord_evasion_event\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeStorageInterface;
use Drupal\nord_evasion_event\Entity\EventNodeInterface;

class EventGateway implements EventGatewayInterface {

  use FilteredEventGatewayTrait;

  protected NodeStorageInterface $nodeStorage;

  public function __construct(
    protected readonly EntityTypeManagerInterface $entityTypeManager,
    protected readonly LanguageService $languageService
  ) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->nodeStorage = $this->entityTypeManager->getStorage('node');
  }

  protected function getNodeBundle(): string {
    return EventNodeInterface::NODE_BUNDLE;
  }

  protected function getLanguageService(): LanguageService {
    return $this->languageService;
  }

  protected function getNodeStorage(): NodeStorageInterface {
    return $this->nodeStorage;
  }

}
