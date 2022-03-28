<?php

namespace Drupal\nord_evasion_vocabulary;

use Drupal\nord_evasion_global\Gateway\ActiveNatureGateway;
use Drupal\nord_evasion_global\Gateway\CulturalHistoryGateway;
use Drupal\nord_evasion_global\Gateway\DestinationGateway;
use Drupal\nord_evasion_global\Manager\ActiveNatureManager;
use Drupal\nord_evasion_global\Manager\CulturalHistoryManager;
use Drupal\nord_evasion_global\Manager\DestinationManager;
use function GuzzleHttp\default_ca_bundle;

enum VocabularyOptionsEnum:string {

  case destination = 'Destination';
  case cultural_history = 'Culture et Patrimoine';
  case active_nature = 'Nature Active';

  public static function asArray(): array {
    $values = [];
    foreach (self::cases() as $vocabulary) {
      $values[$vocabulary->name] = $vocabulary->value;
    }

    return $values;
  }

  public static function getGateway($vid): string {
    return match($vid) {
      self::destination->name => DestinationGateway::class,
      self::cultural_history->name => CulturalHistoryGateway::class,
      self::active_nature->name => ActiveNatureGateway::class
    };
  }


}
