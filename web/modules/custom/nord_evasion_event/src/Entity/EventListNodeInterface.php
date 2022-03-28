<?php

namespace Drupal\nord_evasion_event\Entity;

use Drupal\node\NodeInterface;

interface EventListNodeInterface extends EventListInterface, NodeInterface {

  public const NODE_BUNDLE = 'event_list';

}
