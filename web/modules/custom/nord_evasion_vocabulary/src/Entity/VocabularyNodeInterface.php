<?php

namespace Drupal\nord_evasion_vocabulary\Entity;

use Drupal\node\NodeInterface;

interface VocabularyNodeInterface extends VocabularyInterface, NodeInterface {

  public const NODE_BUNDLE = 'vocabulary';

  public const FIELD_VOCABULARY = 'field_vocabulary';

}
