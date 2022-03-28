<?php

namespace Drupal\nord_evasion_global\Manager;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\StringTranslation\StringTranslationTrait;

trait DateFullMonthTrait{

  use StringTranslationTrait;

  /**
   * @return string[]
   */
  protected function getMonthValueByKey():array{

    $fullMonthByMonthNumber=[];

    for($i=1;$i<=12;$i++){

      $dateTime=(new DrupalDateTime())->setDate(2020, $i, 1);

      $fullMonthByMonthNumber[$i] = $dateTime->format('F');
    }

    return $fullMonthByMonthNumber;
  }

}
