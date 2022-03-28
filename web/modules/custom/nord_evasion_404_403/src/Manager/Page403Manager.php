<?php

namespace Drupal\nord_evasion_404_403\Manager;

use Drupal\nord_evasion_404_403\Entity\Page403NodeInterface;

class Page403Manager extends ErrorPageManagerBase {

  public function getCurrentPage(): ?Page403NodeInterface {
    /** @var Page403NodeInterface $currentPage403 */
    $currentPage403 = parent::getCurrentPage();
    return $currentPage403;
  }

}
