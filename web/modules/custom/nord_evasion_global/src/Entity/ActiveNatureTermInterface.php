<?php

namespace Drupal\nord_evasion_global\Entity;

use Drupal\nord_evasion_global\Gateway\ActiveNatureGatewayInterface;
use Drupal\taxonomy\TermInterface;

interface ActiveNatureTermInterface extends ActiveNatureInterface, ThematicTermInterface {
  public const TERM_VOCABULARY = 'active_nature';

  // hardcoded to prevent useless calls to DB, must be translated before use on front
  public const TERM_NAME = 'Nature Active';
}
