<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\taxonomy\TermInterface;
use Drupal\taxonomy\TermStorageInterface;

trait FetchAllTermsByVidTrait {

  /**
   * @return int[]
   */
  public function fetchAllTermsNids(): array {
    return $this->getTermStorage()
      ->getQuery()
      ->condition('vid', $this->getVocabularyId())
      ->execute();
  }

  /**
   * @return TermInterface[]
   */
  public function fetchAllTerms(): array {
    $nids = $this->fetchAllTermsNids();
    return $this->getTermStorage()->loadMultiple($nids);
  }

  abstract protected function getTermStorage(): TermStorageInterface;

  abstract protected function getVocabularyId(): string;

}
