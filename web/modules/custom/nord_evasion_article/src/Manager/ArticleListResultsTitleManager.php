<?php

namespace Drupal\nord_evasion_article\Manager;

use DateTime;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\nord_evasion_article\Filters\ArticleListFiltersInterface;
use Drupal\nord_evasion_article\Filters\FromArticleListFormFilters;
use Drupal\nord_evasion_global\Manager\DestinationManager;
use Drupal\nord_evasion_global\Manager\ThematicsManager;

class ArticleListResultsTitleManager {

  use StringTranslationTrait;

  const PATTERNS = [
    '000' => ArticleListResultsTitlePatternsEnum::NoOrOneResultNoFilter,
    '001' => ArticleListResultsTitlePatternsEnum::NoOrOneResultThematicFilter,
    '010' => ArticleListResultsTitlePatternsEnum::NoOrOneResultDestinationFilter,
    '011' => ArticleListResultsTitlePatternsEnum::NoOrOneResultThematicAndDestinationFilter,
    '100' => ArticleListResultsTitlePatternsEnum::MoreThanOneResultNoFilter,
    '101' => ArticleListResultsTitlePatternsEnum::MoreThanOneResultThematicFilter,
    '110' => ArticleListResultsTitlePatternsEnum::MoreThanOneResultDestinationFilter,
    '111' => ArticleListResultsTitlePatternsEnum::MoreThanOneResultThematicAndDestinationFilter,
  ];

  public function __construct(
    protected readonly ThematicsManager $thematicsManager,
    protected readonly DestinationManager $destinationManager) {

  }

  public function getResultsTitle(ArticleListFiltersInterface $filtersObjectValue, int $resultsNumber): TranslatableMarkup {
    $pattern = $this->getPatternCaseFromEnum($filtersObjectValue, $resultsNumber);
    return $this->t($pattern->value, $this->getTranslationVariables($filtersObjectValue, $resultsNumber));
  }

  protected function getTranslationVariables(ArticleListFiltersInterface $filtersObjectValue, int $resultsNumber): array {
    return [
      ArticleListResultsTitlePatternsEnum::TRANSLATION_VARIABLE_DESTINATION => $this->getDestinationLabel($filtersObjectValue->getSingleDestination()),
      ArticleListResultsTitlePatternsEnum::TRANSLATION_VARIABLE_THEMATIC => $this->getThematicLabel($filtersObjectValue->getSingleThematic()),
      ArticleListResultsTitlePatternsEnum::TRANSLATION_VARIABLE_RESULTS_NUMBER => $resultsNumber,
    ];
  }

  protected function getPatternCaseFromEnum(ArticleListFiltersInterface $filtersObjectValue, int $resultsNumber): ArticleListResultsTitlePatternsEnum {
    $patternKey = $this->computePatternKey($filtersObjectValue, $resultsNumber);
    return self::PATTERNS[$patternKey];
  }

  /**
   * The key is the one used in the PATTERNS constant.
   * implode() on int will cast each one of them as string, so [(int) FALSE,
   * (int) TRUE] will return '01'
   *
   * @param ArticleListFiltersInterface $filtersObjectValue
   * @param int $resultsNumber
   *
   * @return string
   */
  protected function computePatternKey(ArticleListFiltersInterface $filtersObjectValue, int $resultsNumber): string {
    return implode('', [
      (int) $this->hasMoreThanOneResult($resultsNumber),
      (int) $filtersObjectValue->hasActiveDestinationFilter(),
      (int) $filtersObjectValue->hasActiveThematicFilter(),
    ]);
  }

  protected function hasMoreThanOneResult(int $resultsNumber): bool {
    return $resultsNumber > 1;
  }

  protected function formatPlural($count, $singular, $plural, array $args = [], array $options = []) {
  }

  protected function getDestinationLabel(int|null $tid): string|TranslatableMarkup|null {
    return $tid ? $this->destinationManager->getDestinationLabel($tid) : NULL;
  }

  protected function getThematicLabel(mixed $thematicId): string|TranslatableMarkup|null {
    return $thematicId ? $this->thematicsManager->getThematicLabel($thematicId) : NULL;
  }

}
