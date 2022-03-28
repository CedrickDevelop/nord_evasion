<?php

namespace Drupal\nord_evasion_article\Filters;

use Drupal\nord_evasion_article\Form\ArticleListFormDTOInterface;
use Drupal\nord_evasion_global\Entity\ActiveNatureTermInterface;
use Drupal\nord_evasion_global\Entity\CulturalHistoryTermInterface;

class FromArticleListFormFilters implements ArticleListFiltersInterface {

  protected ?int $activeNature = NULL;

  protected ?int $culturalHistory = NULL;

  /**
   * @param \Drupal\nord_evasion_article\Form\ArticleListFormDTO $dto
   */
  public function __construct(protected readonly ArticleListFormDTOInterface $dto) {
    $thematic = $this->dto->getThematic();
    if (!$thematic) {
      return;
    }

    [$taxonomy, $value] = $this->getTaxonomyTermAndValueAsArray($thematic);

    match ($taxonomy) {
      ActiveNatureTermInterface::TERM_VOCABULARY => $this->activeNature = (int) $value,
      CulturalHistoryTermInterface::TERM_VOCABULARY => $this->culturalHistory = (int) $value
    };

  }

  public function isPaged(): bool {
    return TRUE;
  }

  public function getNumberOfElementsDisplayed(): int {
    return 15;
  }

  public function getDestinationFilters(): array {
    return $this->dto->getDestination()
      ? [$this->dto->getDestination()]
      : [];
  }

  public function getCulturalHistoryFilters(): array {
    return $this->culturalHistory
      ? [$this->culturalHistory]
      : [];
  }

  public function getActiveNatureFilters(): array {
    return $this->activeNature
      ? [$this->activeNature]
      : [];
  }

  public function getSingleDestination(): ?string {
    return $this->dto->getDestination() ?: NULL;
  }

  public function getSingleThematic(): int|string|null {
    return $this->activeNature ?: $this->culturalHistory ?: $this->dto->getThematic() ?: NULL;
  }

  public function hasActiveNatureFilter(): bool {
    return $this->activeNature === 0 || !empty($this->activeNature);
  }

  public function hasCulturalHistoryFilter(): bool {
    return $this->culturalHistory === 0 || !empty($this->culturalHistory);
  }

  public function hasActiveThematicFilter(): bool {
    return $this->hasActiveNatureFilter() || $this->hasCulturalHistoryFilter();
  }

  public function hasActiveDestinationFilter(): bool {
    return $this->getSingleDestination() !== NULL;
  }

  protected function getTaxonomyTermAndValueAsArray(string $thematic): array {
    return strpos($thematic, '.') ? explode('.', $thematic) : [$thematic, 0];
  }

}
