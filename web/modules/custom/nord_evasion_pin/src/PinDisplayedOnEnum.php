<?php

namespace Drupal\nord_evasion_pin;

enum PinDisplayedOnEnum: string {
  case Article = 'Articles et liste d\'articles';
  case Event = 'Evénements et page agenda';
  case Vocabulary = 'Pages rubriques';
  case Editorial = 'Pages éditoriales';
  case Home = 'Page d\'accueil';

  public static function asArray(): array {
    $values = [];
    foreach (self::cases() as $displayedOn) {
      $values[$displayedOn->value] = $displayedOn->value;
    }

    return $values;
  }
}
