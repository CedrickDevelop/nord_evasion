<?php

namespace Drupal\nord_evasion_article\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeStorageInterface;
use Drupal\nord_evasion_article\Entity\ArticleListNodeInterface;
use Drupal\nord_evasion_global\Gateway\GetLastChangedPublishedNodeTrait;

class ArticleListGateway implements ArticleListGatewayInterface {

  use GetLastChangedPublishedNodeTrait;

  protected NodeStorageInterface $nodeStorage;

  public function __construct(
    protected readonly EntityTypeManagerInterface $entityTypeManager,
    protected readonly LanguageService $languageService
  ) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->nodeStorage = $this->entityTypeManager->getStorage('node');
  }

  public function getLastEditedArticleList(): ?ArticleListNodeInterface {
    /** @var ArticleListNodeInterface $articleList */
    $articleList = $this->getLastModifiedPublishedNode();
    return $articleList;
  }

  protected function getLanguageService(): LanguageService {
    return $this->languageService;
  }

  protected function getNodeBundle(): string {
    return ArticleListNodeInterface::NODE_BUNDLE;
  }

  protected function getNodeStorage(): NodeStorageInterface {
    return $this->nodeStorage;
  }

}
