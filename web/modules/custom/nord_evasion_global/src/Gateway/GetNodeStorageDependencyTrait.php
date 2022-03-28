<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\node\NodeStorageInterface;

trait GetNodeStorageDependencyTrait {
  abstract protected function getNodeStorage(): NodeStorageInterface;
}
