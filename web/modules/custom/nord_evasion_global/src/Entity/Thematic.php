<?php

namespace Drupal\nord_evasion_global\Entity;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\taxonomy\Entity\Term;

abstract class Thematic extends Term implements ThematicTermInterface {

  use StringTranslationTrait;

  public function getAlias(): string {
    return $this->get(ThematicTermInterface::ALIAS_FIELD)->value;
  }
}
