<?php

namespace Drupal\nord_evasion_404_403\Manager;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\nord_evasion_404_403\Entity\ErrorPageNodeInterface;
use Drupal\nord_evasion_404_403\Gateway\ErrorPageGatewayInterface;

abstract class ErrorPageManagerBase {

  protected EntityViewBuilderInterface $viewBuilder;

  public function __construct(
    protected readonly ErrorPageGatewayInterface $errorPageGateway,
    EntityTypeManagerInterface $entityTypeManager
  ) {
    $this->viewBuilder = $entityTypeManager->getViewBuilder('node');
  }

  protected function getCurrentPage(): ?ErrorPageNodeInterface {
    return $this->errorPageGateway->getErrorPage();
  }

  public function getCurrentPageRenderArray(): ?array {
    $page = $this->getCurrentPage();

    return $page
      ? $this->viewBuilder->view($page)
      : NULL;
  }
}
