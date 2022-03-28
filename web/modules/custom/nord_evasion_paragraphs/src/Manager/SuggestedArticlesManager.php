<?php

namespace Drupal\nord_evasion_paragraphs\Manager;

use Drupal\nord_evasion_article\Filters\SuggestedArticlesParagraphFilters;
use Drupal\nord_evasion_article\Manager\ArticleManager;
use Drupal\nord_evasion_global\Manager\ExtractTargetIdsFromEntityReferenceListTrait;
use Drupal\nord_evasion_global\Manager\ThematicsManager;
use Drupal\nord_evasion_paragraphs\Entity\SuggestedArticlesParagraphInterface;

class SuggestedArticlesManager implements ParagraphManagerInterface {

  use ExtractTargetIdsFromEntityReferenceListTrait;

  protected const SUGGESTED_ARTICLES = 'suggested_articles';

  public function __construct(
    protected readonly ArticleManager $articleManager,
    protected readonly ThematicsManager $thematicsManager
  ) {
  }

  public function alterPreprocessParagraphVariables($variables): array {
    if (!($variables['paragraph'] instanceof SuggestedArticlesParagraphInterface)) {
      return $variables;
    }

    $variables[self::SUGGESTED_ARTICLES] = $this->getSuggestedArticles($variables['paragraph']);

    return $variables;
  }

  protected function getSuggestedArticles(SuggestedArticlesParagraphInterface $paragraph): array {
    $suggestedArticlesParagraphFilterDTO = $this->getSuggestedArticlesParagraphFilterDTOFromParagraph($paragraph);
    return $this->articleManager->getRenderedArticlesForArticleList($suggestedArticlesParagraphFilterDTO);
  }

  protected function getSuggestedArticlesParagraphFilterDTOFromParagraph(SuggestedArticlesParagraphInterface $paragraph): SuggestedArticlesParagraphFilters {
    return new SuggestedArticlesParagraphFilters($this->getDestinationsFromParagraph($paragraph), $this->getThematicsFromParagraph($paragraph));
  }

  protected function getDestinationsFromParagraph(SuggestedArticlesParagraphInterface $paragraph): array {
    return $this->extractTargetIdsFromEntityReferenceList($paragraph->get(SuggestedArticlesParagraphInterface::FIELD_DESTINATION));
  }

  protected function getThematicsFromParagraph(SuggestedArticlesParagraphInterface $paragraph): array {
    $tids = $this->extractTargetIdsFromEntityReferenceList($paragraph->get(SuggestedArticlesParagraphInterface::FIELD_THEME));
    $thematics = [];
    foreach ($tids as $tid) {
      $thematics[$this->thematicsManager->getThematicVocabulary($tid)][] = $tid;
    }
    return $thematics;
  }

}
