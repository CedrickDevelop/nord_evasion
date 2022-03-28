<?php

namespace Drupal\nord_evasion_global\Manager;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\nord_evasion_global\Entity\ThematicTermInterface;
use Drupal\nord_evasion_vocabulary\Manager\VocabularyManager;
use Drupal\nord_evasion_vocabulary\VocabularyOptionsEnum;
use Drupal\taxonomy\TermStorageInterface;

class ThematicsManager {

  use StringTranslationTrait;

  protected TermStorageInterface $termStorage;

  /**
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(
    protected readonly ActiveNatureManager $activeNatureManager,
    protected readonly CulturalHistoryManager $culturalHistoryManager,
    protected readonly VocabularyManager $vocabularyManager,
    protected readonly EntityTypeManagerInterface $entityTypeManager,
  ) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->termStorage = $this->entityTypeManager->getStorage('taxonomy_term');
  }

  public function getThematicsForOptions(): array {
    $thematics = $this->getAllThematics();

    $options = [];
    foreach($thematics as $thematic) {
      $optgroup = $thematic->getVocabularyLabel();
      $vocabularyKey = $thematic->getVocabularyKey();
      if (!isset($options[$optgroup])) {
        $options[$optgroup] = [
          $vocabularyKey => $this->t("Tous les articles @taxonomy", ['@taxonomy' => $optgroup])
        ];
      }

      $optionKey = $vocabularyKey . '.' . $thematic->id();
      $options[$optgroup][$optionKey] = $thematic->getAlias();
    }

    return $options;
  }

  /**
   * @return ThematicTermInterface[]
   */
  protected function getAllThematics(): array {
    return [
      ... $this->activeNatureManager->getTermsForThematics(),
      ... $this->culturalHistoryManager->getTermsForThematics(),
    ];
  }

  public function getThematicLabel(mixed $thematicId): string|TranslatableMarkup|null {
    if (is_int($thematicId)) {
      return $this->termStorage->load($thematicId)->label();
    }
    return $this->vocabularyManager->getVocabularyNameFromEnum($thematicId);
  }

  public function getThematicVocabulary(int $tid): string {
    return $this->termStorage->load($tid)->bundle();
  }

}
