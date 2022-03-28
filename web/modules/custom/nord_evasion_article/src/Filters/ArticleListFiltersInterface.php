<?php

namespace Drupal\nord_evasion_article\Filters;

interface ArticleListFiltersInterface {
  public function isPaged(): bool;

  public function getNumberOfElementsDisplayed(): int;

  /**
   * @return int[]
   */
  public function getDestinationFilters(): array;

  /**
   * @return int[]
   */
  public function getCulturalHistoryFilters(): array;

  /**
   * @return int[]
   */
  public function getActiveNatureFilters(): array;

  public function getSingleDestination(): ?string;

  public function getSingleThematic(): int|string|null;

  public function hasActiveNatureFilter(): bool;

  public function hasCulturalHistoryFilter(): bool;

  public function hasActiveThematicFilter(): bool;

  public function hasActiveDestinationFilter(): bool;
}
