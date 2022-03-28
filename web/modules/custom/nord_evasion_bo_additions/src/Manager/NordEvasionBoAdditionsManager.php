<?php

namespace Drupal\nord_evasion_bo_additions\Manager;

use Drupal\nord_evasion_vocabulary\VocabularyOptionsEnum;

class NordEvasionBoAdditionsManager {

  protected const VOCABULARY_WIDGET_TYPE = 'radios';

  protected const VOCABULARY_WIDGET_TITLE = 'Vocabulaire';

  public function alterMenuLinksWithAdditions($links) {
    return $links;
  }

  /**
   * @param array $element
   *
   * @return array
   */
  public function alterVocabularyOptionsButtonsWidget(array $element): array {
    if ($this->getElementType($element) !== self::VOCABULARY_WIDGET_TYPE
      && $this->getElementTitle($element) !== self::VOCABULARY_WIDGET_TITLE) {
      return $element;
    }

    $element = $this->filterVocabularyOptions($element);

    return $element;
  }

  protected function filterVocabularyOptions($element) {
    /* @var \Drupal\Core\Field\FieldFilteredMarkup $option */
    foreach ($element['#options'] as $key => $option) {
      if (VocabularyOptionsEnum::tryFrom($option->__toString()) === NULL) {
        unset($element['#options'][$key]);
      }
    }
    return $element;
  }

  protected function getElementTitle($element) {
    return $element['#title'] ?? NULL;
  }

  protected function getElementType($element) {
    return $element['#type'] ?? NULL;
  }

}
