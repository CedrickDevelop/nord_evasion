<?php

namespace Drupal\nord_evasion_global\Entity;

use Drupal\taxonomy\TermInterface;

interface ThematicTermInterface extends ThematicInterface, TermInterface {
  public const ALIAS_FIELD = "field_alias";
}
