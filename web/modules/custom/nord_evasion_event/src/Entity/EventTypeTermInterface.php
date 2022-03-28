<?php

namespace Drupal\nord_evasion_event\Entity;

use Drupal\taxonomy\TermInterface;

interface EventTypeTermInterface extends EventTypeInterface, TermInterface {
  public const TERM_VOCABULARY = 'event_type';
}
