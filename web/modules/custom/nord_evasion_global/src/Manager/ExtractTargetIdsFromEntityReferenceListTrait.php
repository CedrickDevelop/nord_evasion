<?php

namespace Drupal\nord_evasion_global\Manager;

use Drupal\Core\Field\FieldItemListInterface;

trait ExtractTargetIdsFromEntityReferenceListTrait {

  protected function extractTargetIdsFromEntityReferenceList(FieldItemListInterface $rawData): array {
    $values = $rawData->getValue();
    $ids = [];
    foreach ($values as $value) {
      $ids[] = $value['target_id'];
    }
    return $ids;
  }

}
