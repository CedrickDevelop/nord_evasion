<?php

namespace Drupal\nord_evasion_global\Entity;

interface ThematicInterface {
  public function getAlias(): string;

  public function getVocabularyLabel(): string;

  public function getVocabularyKey(): string;
}
