<?php

namespace Drupal\nord_evasion_404_403\Manager;

use Drupal\nord_evasion_404_403\Entity\Page404NodeInterface;

class Page404Manager extends ErrorPageManagerBase {

  public function getCurrentPage(): ?Page404NodeInterface {
    /** @var Page404NodeInterface $currentPage404 */
    $currentPage404 = parent::getCurrentPage();
    return $currentPage404;
  }

}
