<?php

namespace Drupal\nord_evasion_global\Manager;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;
use Drupal\node\NodeStorageInterface;
use Drupal\nord_evasion_article\Entity\ArticleInterface;
use Drupal\nord_evasion_article\Entity\ArticleNodeInterface;
use Drupal\nord_evasion_event\Entity\EventInterface;
use Drupal\nord_evasion_event\Entity\EventNodeInterface;
use Drupal\nord_evasion_page\Entity\PageNodeInterface;
use Drupal\nord_evasion_vocabulary\Entity\VocabularyNodeInterface;

class SearchResultManager {

  public const VIEW_MODE = 'search_result_inline';

  public const NODE_TRAIL = 'node_trail';

  protected NodeStorageInterface $nodeStorage;

  public function __construct(protected readonly EntityTypeManagerInterface $entityTypeManager) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->nodeStorage = $this->entityTypeManager->getStorage('node');
  }

  public function addSearchResultVariablesToPreprocessNode(array $variables): array {
    if (!$this->isNodeDisplayedAsSearchResult($variables)) {
      return $variables;
    }

    $variables[self::NODE_TRAIL] = $this->getNodeTrailFromVariables($variables);

    return $variables;
  }

  protected function getNodeFromVariables($variables): ?NodeInterface {
    /** @var \Drupal\node\NodeInterface $currentNode */
    return $variables['node'] ?: NULL;
  }

  protected function isNodeDisplayedAsSearchResult(array $variables): bool {
    return $variables['view_mode'] == self::VIEW_MODE;
  }

  protected function getNodeTrailFromVariables(array $variables): string {
    $siteName = $this->getSiteName();
    $node = $this->getNodeFromVariables($variables);
    $trail = $this->getNodeTrail($node);

    return sprintf('%s > %s ', $siteName, $trail);
  }

  protected function getSiteName(): string {
    $config = \Drupal::config('system.site');
    return $config->get('name');
  }

  protected function getNodeTrail(NodeInterface $node): string {
    return match($node->bundle()) {
      ArticleNodeInterface::NODE_BUNDLE => ArticleInterface::SEARCH_RESULT_TYPE,
      EventNodeInterface::NODE_BUNDLE => EventInterface::SEARCH_RESULT_TYPE,
      VocabularyNodeInterface::NODE_BUNDLE => $node->label(),
      PageNodeInterface::NODE_BUNDLE => $this->getPageNodeTrail($node),
      default => NULL
    };
  }

  protected function getPageNodeTrail(NodeInterface $node): string {
    /* @var \Drupal\nord_evasion_vocabulary\Entity\VocabularyNodeInterface $thematic */
    $thematic = $this->nodeStorage->load($node->get(PageNodeInterface::FIELD_THEMATIC)->getValue()[0]['target_id']);
    return sprintf('%s > %s', $thematic->label(), $node->label());
  }


}
