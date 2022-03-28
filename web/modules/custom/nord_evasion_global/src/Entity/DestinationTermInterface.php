<?php

namespace Drupal\nord_evasion_global\Entity;

use Drupal\taxonomy\TermInterface;

interface DestinationTermInterface extends DestinationInterface, TermInterface {
  public const TERM_VOCABULARY = 'destination';
}
