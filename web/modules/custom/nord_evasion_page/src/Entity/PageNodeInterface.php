<?php

namespace Drupal\nord_evasion_page\Entity;

use Drupal\node\NodeInterface;

interface PageNodeInterface extends PageInterface, NodeInterface {

  public const NODE_BUNDLE = 'page';

  public const FIELD_THEMATIC = 'field_thematic';

  public const FIELD_DESTINATION = 'field_destination';

  public function getDestinationTarget(): ?int;
}
