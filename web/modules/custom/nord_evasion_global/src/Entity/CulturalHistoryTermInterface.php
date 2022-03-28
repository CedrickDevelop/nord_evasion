<?php

namespace Drupal\nord_evasion_global\Entity;

use Drupal\taxonomy\TermInterface;

interface CulturalHistoryTermInterface extends CulturalHistoryInterface, ThematicTermInterface {
  public const TERM_VOCABULARY = 'cultural_history';

  // hardcoded to prevent useless calls to DB, must be translated before use on front
  public const TERM_NAME = 'Culture et Patrimoine';
}
