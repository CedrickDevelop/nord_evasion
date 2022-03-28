<?php

namespace Drupal\nord_evasion_article\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeStorageInterface;
use Drupal\nord_evasion_article\Entity\ArticleNodeInterface;
use Drupal\nord_evasion_article\Filters\ArticleListFiltersInterface;

class ArticleGateway implements ArticleGatewayInterface {

  use FilteredArticleGatewayTrait;

  protected NodeStorageInterface $nodeStorage;

  /**
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(
    protected readonly EntityTypeManagerInterface $entityTypeManager,
    protected readonly LanguageService $languageService
  ) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->nodeStorage = $this->entityTypeManager->getStorage('node');
  }

  protected function getLanguageService(): LanguageService {
    return $this->languageService;
  }

  protected function getNodeStorage(): NodeStorageInterface {
    return $this->nodeStorage;
  }

  protected function getNodeBundle(): string {
    return ArticleNodeInterface::NODE_BUNDLE;
  }

  /**
   * @param \Drupal\nord_evasion_article\Filters\ArticleListFiltersInterface $filtersObjectValue
   *
   * @return array
   */
  public function getFilteredArticles(ArticleListFiltersInterface $filtersObjectValue): array {
    return $this->getFilteredArticleList($filtersObjectValue);
  }



}
