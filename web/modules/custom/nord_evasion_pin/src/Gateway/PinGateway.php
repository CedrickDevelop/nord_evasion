<?php

namespace Drupal\nord_evasion_pin\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeStorageInterface;
use Drupal\nord_evasion_global\Gateway\GetLastChangedPublishedNodeTrait;
use Drupal\nord_evasion_pin\Entity\PinNodeInterface;

class PinGateway implements PinGatewayInterface {

  use GetLastChangedPublishedNodeTrait;

  protected NodeStorageInterface $nodeStorage;

  public function __construct(
    protected readonly EntityTypeManagerInterface $entityTypeManager,
    protected readonly LanguageService $languageService
  ) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->nodeStorage = $this->entityTypeManager->getStorage('node');
  }

  public function getLastModifiedPublishedPin(): ?PinNodeInterface {
    /** @var PinNodeInterface $pin */
    $pin = $this->getLastModifiedPublishedNode();
    return $pin;
  }

  protected function getNodeBundle(): string {
    return PinNodeInterface::NODE_BUNDLE;
  }

  protected function getLanguageService(): LanguageService {
    return $this->languageService;
  }

  protected function getNodeStorage(): NodeStorageInterface {
    return $this->nodeStorage;
  }

}
