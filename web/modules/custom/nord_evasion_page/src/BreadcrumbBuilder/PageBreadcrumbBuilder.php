<?php

namespace Drupal\nord_evasion_page\BreadcrumbBuilder;

use Drupal;
use Drupal\adimeo_abstractions\BreadcrumbBuilder\NodeBundleNodeListBreadcrumbBuilderBase;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Drupal\node\NodeInterface;
use Drupal\nord_evasion_page\Entity\PageNodeInterface;
use Drupal\nord_evasion_page\Manager\PageManager;

class PageBreadcrumbBuilder extends NodeBundleNodeListBreadcrumbBuilderBase{

  public function __construct(
    UrlGeneratorInterface $urlGenerator,
    protected PageManager $pageManager
  ) {
    parent::__construct($urlGenerator);
  }

  protected function getNodeBundle(): string {
    return PageNodeInterface::NODE_BUNDLE;
  }

  protected function getListNode(): ?NodeInterface {
    /* @var \Drupal\nord_evasion_page\Entity\PageNodeInterface $currentNode */
    $currentNode = Drupal::routeMatch()->getParameter('node');
    if (!$currentNode || !$currentNode->hasField(PageNodeInterface::FIELD_THEMATIC)) {
      return NULL;
    }

    return  !empty($thematicId = $currentNode->get(PageNodeInterface::FIELD_THEMATIC)->getValue()[0]['target_id']) ? $this->pageManager->getVocabularyNode($thematicId) : NULL;
  }

}
