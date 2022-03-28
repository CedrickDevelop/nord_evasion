<?php

namespace Drupal\nord_evasion_global\Entity;

class CulturalHistory extends Thematic implements CulturalHistoryTermInterface {

  public function getVocabularyLabel(): string {
    return $this->t(self::TERM_NAME);
  }

  public function getVocabularyKey(): string {
    return self::TERM_VOCABULARY;
  }

}
