<?php

namespace Drupal\nord_evasion_event\BreadcrumbBuilder;

use Drupal\adimeo_abstractions\BreadcrumbBuilder\NodeBundleNodeListBreadcrumbBuilderBase;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Drupal\node\NodeInterface;
use Drupal\nord_evasion_event\Entity\EventNodeInterface;
use Drupal\nord_evasion_event\Manager\EventListManager;

class EventBreadcrumbBuilder extends NodeBundleNodeListBreadcrumbBuilderBase {

  public function __construct(
    UrlGeneratorInterface $urlGenerator,
    protected EventListManager $eventListManager
  ) {
    parent::__construct($urlGenerator);
  }

  protected function getNodeBundle(): string {
    return EventNodeInterface::NODE_BUNDLE;
  }

  protected function getListNode(): NodeInterface {
    return $this->eventListManager->getCurrentEventList();
  }

}
