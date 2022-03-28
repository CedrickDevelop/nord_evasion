<?php

namespace Drupal\nord_evasion_404_403\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\nord_evasion_home\Manager\HomeManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ErrorPagesController extends ControllerBase {

  const ROUTE_NAME = "nord_evasion_home.home";

  public function __construct(
    protected readonly Drupal\nord_evasion_404_403\Manager\Page404Manager $page404Manager,
    protected readonly Drupal\nord_evasion_404_403\Manager\Page403Manager $page403Manager,
  ) {

  }

  public function error404() {
    $renderedPage = $this->page404Manager->getCurrentPageRenderArray();
    if ($renderedPage) {
      return $renderedPage;
    }

    // if no content, then we don't even have a 404 page ...
    throw new \Exception();
  }

  public function error403() {
    $renderedPage = $this->page403Manager->getCurrentPageRenderArray();
    if ($renderedPage) {
      return $renderedPage;
    }

    // if no content, then we don't even have a 404 page ...
    throw new NotFoundHttpException();
  }
}
