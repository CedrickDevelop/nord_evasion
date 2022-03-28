<?php

namespace Drupal\nord_evasion_article\Entity;

use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\paragraphs\ParagraphInterface;
use JetBrains\PhpStorm\ArrayShape;

class ArticleSummary implements ArticleSummaryInterface {

  const RICH_TEXT_PARAGRAPH_TYPE = 'rich_text';

  const TEMPLATE = 'article_summary';

  protected array $paragraphs = [];

  public function __construct(?ParagraphInterface ... $paragraphs) {
    $this->paragraphs = $this->filterParagraphs(... $paragraphs);
  }

  /**
   * @param \Drupal\paragraphs\ParagraphInterface|null ...$paragraphs
   *
   * @return ?ParagraphInterface[]
   */
  protected function filterParagraphs(?ParagraphInterface ... $paragraphs): array {
    $filteredParagraphs = [];
    foreach ($paragraphs as $paragraph) {
      if ($this->isParagraphEligibleForSummary($paragraph)) {
        $filteredParagraphs[] = $paragraph;
      }
    };

    return $filteredParagraphs;
  }

  protected function isParagraphEligibleForSummary(ParagraphInterface $paragraph): bool {
    return $paragraph->getType() === self::RICH_TEXT_PARAGRAPH_TYPE;
  }

  public function toRenderable() {
    return [
      '#theme' => self::TEMPLATE,
      '#links' => $this->getLinks()
    ];
  }

  protected function getLinks(): array {
    $links = [];
    foreach ($this->paragraphs as $paragraph) {
      $title = $paragraph->get('field_displayed_title')->value;
      $url = Url::fromUserInput('#summary-' . $paragraph->id());
      $links[] = new Link($title, $url);
    }

    return $links;
  }

}
