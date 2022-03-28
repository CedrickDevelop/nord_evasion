<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\taxonomy\TermInterface;
use Drupal\taxonomy\TermStorageInterface;

trait FetchAllTermsByWeightTrait {

  /**
   * @return int[]
   */
  public function fetchTermsNidsByWeight(): array {
    return $this->getTermStorage()
      ->getQuery()
      ->condition('vid', $this->getVocabularyId())
      ->sort('weight', 'ASC')
      ->execute();
  }

  /**
   * @return TermInterface[]
   */
  public function fetchTermsByWeight(): array {
    $nids = $this->fetchTermsNidsByWeight();
    return $this->getTermStorage()->loadMultiple($nids);
  }

  abstract protected function getTermStorage(): TermStorageInterface;

  abstract protected function getVocabularyId(): string;

}
