<?php

namespace Drupal\nord_evasion_home\Entity;

use Drupal\node\NodeInterface;

interface HomeNodeInterface extends NodeInterface , HomeInterface {

  public const NODE_BUNDLE = 'home';

}
