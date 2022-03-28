<?php

namespace Drupal\nord_evasion_article\Gateway;

use Drupal\nord_evasion_article\Filters\ArticleListFiltersInterface;

interface ArticleGatewayInterface {

  /**
   * @param \Drupal\nord_evasion_article\Filters\ArticleListFiltersInterface $filtersObjectValue
   *
   * @return \Drupal\nord_evasion_article\Entity\ArticleNodeInterface[]
   */
  public function getFilteredArticles(ArticleListFiltersInterface $filtersObjectValue): array;

}
