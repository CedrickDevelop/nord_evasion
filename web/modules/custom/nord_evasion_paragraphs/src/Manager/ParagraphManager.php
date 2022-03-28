<?php

namespace Drupal\nord_evasion_paragraphs\Manager;

use Drupal\paragraphs\ParagraphInterface;

class ParagraphManager {

  const PREPROCESS_PARAGRAPH_PID = 'pid';

  public function __construct(
    protected readonly AgendaManager $agendaParagraphManager,
    protected readonly DynamicMapManager $dynamicMapManager,
    protected readonly MediaPhotoAlbumManager $mediaParagraphManager,
    protected readonly SuggestedArticlesManager $suggestedArticlesManager,
    protected readonly ThematicManager $thematicManager
  ) {
  }

  public function addParagraphVariablesToPreprocessParagraph($variables): array {

    foreach ($this->getParagraphTypeManagers() as $paragraphManager) {
      $variables = $paragraphManager->alterPreprocessParagraphVariables($variables);
    }

    $paragraph = $this->getParagraphFromPreprocessVariables($variables);
    if (!$paragraph instanceof ParagraphInterface) {
      return $variables;
    }
    $variables[self::PREPROCESS_PARAGRAPH_PID] = (int) $paragraph->id();

    return $variables;
  }

  protected function getParagraphFromPreprocessVariables($variables): ?ParagraphInterface {
    return $variables['paragraph'] ?: NULL;
  }

  /**
   * @return ParagraphManagerInterface[]
   */
  protected function getParagraphTypeManagers(): array {
    return [
      $this->dynamicMapManager,
      $this->agendaParagraphManager,
      $this->mediaParagraphManager,
      $this->suggestedArticlesManager,
      $this->thematicManager
    ];
  }

}
