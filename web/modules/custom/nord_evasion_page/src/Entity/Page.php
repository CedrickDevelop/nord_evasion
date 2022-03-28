<?php

namespace Drupal\nord_evasion_page\Entity;

use Drupal\node\Entity\Node;

class Page extends Node implements PageNodeInterface {

  /**
   * Get the id of destination term id
   * @return int|null
   */
  public function getDestinationTarget(): ?int
  {
    $termDestinationId = $this->get(PageNodeInterface::FIELD_DESTINATION)->target_id;
    return $termDestinationId ? $termDestinationId : NULL;
  }
}
