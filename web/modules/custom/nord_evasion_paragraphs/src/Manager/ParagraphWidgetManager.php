<?php

namespace Drupal\nord_evasion_paragraphs\Manager;

use Drupal\nord_evasion_vocabulary\VocabularyOptionsEnum;

class ParagraphWidgetManager {

  protected const PARAGRAPH_THEME = 'theme';

  protected const FIELD_TAXONOMY = 'field_taxonomy';

  public function alterWidget(array $element): array {

    $element = $this->alterVocabularyOptionsIfApplicable($element);

    return $element;
  }

  protected function alterVocabularyOptionsIfApplicable(array $element): array {

    if ($this->getElementType($element) !== self::PARAGRAPH_THEME) {
      return $element;
    }

    $element['subform'][self::FIELD_TAXONOMY]['widget']['#options'] = VocabularyOptionsEnum::asArray();

    return $element;
  }

  protected function getElementType($element) {
    return $element['#paragraph_type'] ?? NULL;
  }

}
