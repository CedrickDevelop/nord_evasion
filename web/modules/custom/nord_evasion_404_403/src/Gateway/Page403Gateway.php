<?php

namespace Drupal\nord_evasion_404_403\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeStorageInterface;
use Drupal\nord_evasion_404_403\Entity\ErrorPageNodeInterface;
use Drupal\nord_evasion_404_403\Entity\Page403NodeInterface;
use Drupal\nord_evasion_global\Gateway\GetLastChangedPublishedNodeTrait;

class Page403Gateway implements ErrorPageGatewayInterface {

  use GetLastChangedPublishedNodeTrait;

  protected NodeStorageInterface $nodeStorage;

  public function __construct(
    protected readonly EntityTypeManagerInterface $entityTypeManager,
    protected readonly LanguageService $languageService
  ) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->nodeStorage = $this->entityTypeManager->getStorage('node');
  }

  public function getErrorPage(): ?Page403NodeInterface {
    /** @var \Drupal\nord_evasion_404_403\Entity\Page403NodeInterface $page403 */
    $page403 = $this->getLastModifiedPublishedNode();
    return $page403;
  }

  protected function getNodeBundle(): string {
    return Page403NodeInterface::NODE_BUNDLE;
  }

  protected function getLanguageService(): LanguageService {
    return $this->languageService;
  }

  protected function getNodeStorage(): NodeStorageInterface {
    return $this->nodeStorage;
  }

}
