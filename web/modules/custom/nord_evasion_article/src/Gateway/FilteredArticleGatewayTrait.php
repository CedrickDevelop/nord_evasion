<?php

namespace Drupal\nord_evasion_article\Gateway;

use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\node\NodeInterface;
use Drupal\nord_evasion_article\Entity\ArticleNodeInterface;
use Drupal\nord_evasion_article\Filters\ArticleListFiltersInterface;
use Drupal\nord_evasion_global\Gateway\GetGatewayLanguageDependencyTrait;
use Drupal\nord_evasion_global\Gateway\GetNodeStorageDependencyTrait;

trait FilteredArticleGatewayTrait {

  use GetGatewayLanguageDependencyTrait;
  use GetNodeStorageDependencyTrait;

  public function getFilteredArticleList(ArticleListFiltersInterface $filtersObjectValue): ?array {
    $nids = $this->getFilteredArticleListNids($filtersObjectValue);
    return $this->getLanguageService()->loadMultiple('node', $nids);
  }

  protected function getFilteredArticleListNids(ArticleListFiltersInterface $filtersObjectValue): array|int {
    $query = $this->getBaseQueryForFilteredArticlesList($filtersObjectValue);
    if ($filtersObjectValue->isPaged()) {
      $query->pager($filtersObjectValue->getNumberOfElementsDisplayed());
    }
    else {
      $query->range(0, $filtersObjectValue->getNumberOfElementsDisplayed());
    }
    return $query->execute();
  }

  public function getFilteredArticleListCount(ArticleListFiltersInterface $filtersObjectValue): int {
    $query = $this->getBaseQueryForFilteredArticlesList($filtersObjectValue);
    return $query->count()->execute();
  }

  protected function getBaseQueryForFilteredArticlesList(ArticleListFiltersInterface $filtersObjectValue): QueryInterface {
    $query = $this->getNodeStorage()->getQuery();
    $query->condition('status', NodeInterface::PUBLISHED)
      ->condition('type', ArticleNodeInterface::NODE_BUNDLE)
      ->sort('created', 'DESC');

    if ($filtersObjectValue->hasActiveNatureFilter()) {
      $query->condition(ArticleNodeInterface::FIELD_ACTIVE_NATURE, NULL, 'IS NOT NULL');
    }
    if (!empty($filtersObjectValue->getActiveNatureFilters())) {
      $query->condition(ArticleNodeInterface::FIELD_ACTIVE_NATURE, $filtersObjectValue->getActiveNatureFilters(), 'IN');
    }
    if ($filtersObjectValue->hasCulturalHistoryFilter()) {
      $query->condition(ArticleNodeInterface::FIELD_CULTURAL_HISTORY, NULL, 'IS NOT NULL');
    }
    if (!empty($filtersObjectValue->getCulturalHistoryFilters())) {
      $query->condition(ArticleNodeInterface::FIELD_CULTURAL_HISTORY, $filtersObjectValue->getCulturalHistoryFilters(), 'IN');
    }
    if (!empty($filtersObjectValue->getDestinationFilters())) {
      $query->condition(ArticleNodeInterface::FIELD_DESTINATION, $filtersObjectValue->getDestinationFilters(), 'IN');
    }

    return $query;
  }

}
