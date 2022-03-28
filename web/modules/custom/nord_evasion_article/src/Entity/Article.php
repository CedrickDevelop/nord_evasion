<?php

namespace Drupal\nord_evasion_article\Entity;

use Drupal\node\Entity\Node;
use Drupal\paragraphs\ParagraphInterface;

class Article extends Node implements ArticleNodeInterface {

  public const FIELD_PARAGRAPHS = 'field_paragraphs';

  const RICH_TEXT_PARAGRAPH_TYPE = 'rich_text';

  /**
   * @var \Drupal\nord_evasion_article\Entity\ArticleSummary
   */
  protected ArticleSummaryInterface $summary;

  public function __construct(array $values, $entity_type, $bundle = FALSE, $translations = []) {
    parent::__construct($values, $entity_type, $bundle, $translations);

    $this->summary = new ArticleSummary(... $this->getParagraphs());
  }

  public function getInternalSummary() {
    return $this->summary;
  }

  /**
   * @return ParagraphInterface[]
   */
  protected function getParagraphs(): array {
    /** @var \Drupal\entity_reference_revisions\EntityReferenceRevisionsFieldItemList $paragraphsItemList */
    $paragraphsItemList = $this->get(self::FIELD_PARAGRAPHS);
    return $paragraphsItemList->referencedEntities();
  }

}
