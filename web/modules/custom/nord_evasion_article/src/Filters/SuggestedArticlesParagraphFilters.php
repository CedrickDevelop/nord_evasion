<?php

namespace Drupal\nord_evasion_article\Filters;

use Drupal\nord_evasion_global\Entity\ActiveNatureTermInterface;
use Drupal\nord_evasion_global\Entity\CulturalHistoryTermInterface;

class SuggestedArticlesParagraphFilters implements ArticleListFiltersInterface {

  protected const ELEMENTS_DISPLAYED_NUMBER = 3;

  protected array $activeNature;

  protected array $culturalHistory;

  public function __construct(protected readonly array $destinationsFilters, array $thematicsFilters) {
    $this->activeNature = (array) $thematicsFilters[ActiveNatureTermInterface::TERM_VOCABULARY];
    $this->culturalHistory = (array) $thematicsFilters[CulturalHistoryTermInterface::TERM_VOCABULARY];
  }

  public function isPaged(): bool {
    return FALSE;
  }

  public function getNumberOfElementsDisplayed(): int {
    return self::ELEMENTS_DISPLAYED_NUMBER;
  }

  public function getDestinationFilters(): array {
    return $this->destinationsFilters;
  }

  public function getCulturalHistoryFilters(): array {
    return $this->culturalHistory;
  }

  public function getActiveNatureFilters(): array {
    return $this->activeNature;
  }

  public function getSingleDestination(): ?string {
    return null; // unused in this situation (could be set with 2 interfaces)
  }

  public function getSingleThematic(): int|string|null {
    return null; // unused in this situation (could be set with 2 interfaces)
  }

  public function hasActiveNatureFilter(): bool {
    return !empty($this->activeNature);
  }

  public function hasCulturalHistoryFilter(): bool {
    return !empty($this->culturalHistory);
  }

  public function hasActiveThematicFilter(): bool {
    return $this->hasActiveNatureFilter() || $this->hasCulturalHistoryFilter();
  }

  public function hasActiveDestinationFilter(): bool {
    return !empty($this->destinationsFilters);
  }

}
