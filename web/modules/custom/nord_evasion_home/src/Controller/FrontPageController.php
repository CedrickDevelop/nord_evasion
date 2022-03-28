<?php

namespace Drupal\nord_evasion_home\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\nord_evasion_home\Manager\HomeManager;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FrontPageController extends ControllerBase {

  const ROUTE_NAME = "nord_evasion_home.home";


  public function __construct(
    protected readonly HomeManager $manager
  ) {

  }

  public function content() {

    $home = $this->manager->getFrontPageNodeView();
    if (!empty($home)) {
      return $home;
    }

    throw new NotFoundHttpException();
  }
}
