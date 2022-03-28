<?php

namespace Drupal\nord_evasion_article\BreadcrumbBuilder;

use Drupal\adimeo_abstractions\BreadcrumbBuilder\NodeBundleNodeListBreadcrumbBuilderBase;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Drupal\node\NodeInterface;
use Drupal\nord_evasion_article\Entity\ArticleNodeInterface;
use Drupal\nord_evasion_article\Manager\ArticleListManager;

class ArticleBreadcrumbBuilder extends NodeBundleNodeListBreadcrumbBuilderBase {

  public function __construct(
    UrlGeneratorInterface $urlGenerator,
    protected ArticleListManager $articleListManager
  ) {
    parent::__construct($urlGenerator);
  }

  protected function getNodeBundle(): string {
    return ArticleNodeInterface::NODE_BUNDLE;
  }

  protected function getListNode(): NodeInterface {
    return $this->articleListManager->getArticleListNode();
  }

}
