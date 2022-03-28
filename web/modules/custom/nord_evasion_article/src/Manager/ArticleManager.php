<?php

namespace Drupal\nord_evasion_article\Manager;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\nord_evasion_article\Entity\ArticleNodeInterface;
use Drupal\nord_evasion_article\Filters\ArticleListFiltersInterface;
use Drupal\nord_evasion_article\Filters\FromArticleListFormFilters;
use Drupal\nord_evasion_article\Gateway\ArticleGatewayInterface;
use Drupal\nord_evasion_pin\Manager\PinManager;

class ArticleManager {

  const VIEW_MODE_LIST = 'teaser';

  protected EntityViewBuilderInterface $viewBuilder;

  public function __construct(
    protected readonly ArticleGatewayInterface $articleListGateway,
    protected readonly PinManager $pinManager,
    protected readonly EntityTypeManagerInterface $entityTypeManager
  ) {
    $this->viewBuilder = $this->entityTypeManager->getViewBuilder('node');
  }

  public function addArticleVariablesToPreprocessNode(array $variables): array {
    if (!$this->isNodeOfCurrentBundle($variables)) {
      return $variables;
    }

    return $variables;
  }

  protected function isNodeOfCurrentBundle(array $variables): bool {
    /** @var \Drupal\node\NodeInterface $currentNode */
    $currentNode = $variables['node'];
    return $currentNode instanceof ArticleNodeInterface;
  }

  public function getRenderedArticlesForArticleList(ArticleListFiltersInterface $filtersObjectValue): array {
    $articleList = $this->articleListGateway->getFilteredArticles($filtersObjectValue);
    return $this->viewBuilder->viewMultiple($articleList, self::VIEW_MODE_LIST);
  }

  public function getFilteredArticlesTotalCount(ArticleListFiltersInterface $filtersObjectValue): int {
    return $this->articleListGateway->getFilteredArticleListCount($filtersObjectValue);
  }

}
