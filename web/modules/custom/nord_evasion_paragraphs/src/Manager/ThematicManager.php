<?php

namespace Drupal\nord_evasion_paragraphs\Manager;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Pager\PagerManager;
use Drupal\nord_evasion_global\Manager\ExtractTargetIdsFromEntityReferenceListTrait;
use Drupal\nord_evasion_page\Manager\PageManager;
use Drupal\nord_evasion_paragraphs\Entity\ThematicParagraphInterface;
use Drupal\nord_evasion_vocabulary\Manager\VocabularyManager;
use Drupal\taxonomy\TermStorageInterface;

class ThematicManager implements ParagraphManagerInterface {

  use ExtractTargetIdsFromEntityReferenceListTrait;

  protected const THEMATICS_PREPROCESS_KEY = 'thematics';

  protected TermStorageInterface $termStorage;

  /**
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(
    protected readonly VocabularyManager $vocabularyManager,
    protected readonly PageManager $pageManager,
    protected readonly EntityTypeManagerInterface $entityTypeManager
  ) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->termStorage = $this->entityTypeManager->getStorage('taxonomy_term');
  }

  public function alterPreprocessParagraphVariables(array $variables): array {
    if (!($variables['paragraph'] instanceof ThematicParagraphInterface)) {
      return $variables;
    }

    $paragraph = $this->getParagraphFromPreprocessVariables($variables);
    $variables[self::THEMATICS_PREPROCESS_KEY] = $this->getVocabularyEditorialPagesRenderedAsLogoFromParagraph($paragraph);

    return $variables;
  }

  protected function getParagraphFromPreprocessVariables($variables): ?ThematicParagraphInterface {
    return $variables['paragraph'] ?: NULL;
  }

  protected function getVocabularyEditorialPagesRenderedAsLogoFromParagraph(ThematicParagraphInterface $paragraph): array {
    $vids = $this->extractTargetIdsFromEntityReferenceList($paragraph->get(ThematicParagraphInterface::FIELD_TAXONOMY));
    $terms = [];
    foreach ($vids as $vid) {
      $terms[$vid] = [
        'title' => $this->vocabularyManager->getVocabularySplitName($vid),
        'pages' => $this->vocabularyManager->getVocabularyEditorialPagesRenderedAsLogo($vid),
      ];
    }
    return $terms;
  }

}
