<?php

namespace Drupal\nord_evasion_vocabulary\Manager;

use Drupal;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\nord_evasion_global\Manager\ExtractTargetIdsFromEntityReferenceListTrait;
use Drupal\nord_evasion_page\Entity\PageNodeInterface;
use Drupal\nord_evasion_page\Manager\PageManager;
use Drupal\nord_evasion_vocabulary\Entity\VocabularyNodeInterface;
use Drupal\nord_evasion_vocabulary\Gateway\VocabularyGatewayInterface;
use Drupal\nord_evasion_vocabulary\VocabularyOptionsEnum;

class VocabularyManager {

  use ExtractTargetIdsFromEntityReferenceListTrait;

  protected const TILES_KEY = 'tiles';

  protected const VIEW_MODE_TILE = 'tile';

  protected const VIEW_MODE_LOGO = 'logo';

  /**
   * @var \Drupal\Core\Entity\EntityViewBuilderInterface
   */
  protected EntityViewBuilderInterface $viewBuilder;

  public function __construct(
    protected readonly PageManager $pageManager,
    protected readonly VocabularyGatewayInterface $vocabularyGateway,
    protected readonly EntityTypeManagerInterface $entityTypeManager
  ) {
    $this->viewBuilder = $this->entityTypeManager->getViewBuilder('node');
  }

  public function addVariablesToPreProcessNodeVariables($variables) {
    if (!$this->isNodeOfCurrentBundle($variables)) {
      return $variables;
    }

    $variables[self::TILES_KEY] = $this->getVocabularyEditorialPagesRenderedAsTiles($variables);

    return $variables;
  }

  public function getVocabularyNameFromEnum(string $vid): string {
    $vocabularies = VocabularyOptionsEnum::asArray();
    return $vocabularies[$vid];
  }

  public function getVocabularySplitName(string $vid): array {
    return explode(' ', $this->getVocabularyNameFromEnum($vid), 2);
  }

  public function getVocabularyEditorialPagesRenderedAsLogo(string $vid): array {
    $pages = $this->getVocabularyEditorialPages($vid);
    return !empty($pages) ? $this->viewBuilder->viewMultiple($pages, self::VIEW_MODE_LOGO) : [];
  }

  protected function isNodeOfCurrentBundle($variables): bool {
    /** @var \Drupal\node\NodeInterface $currentNode */
    $currentNode = $variables['node'];
    return $currentNode instanceof VocabularyNodeInterface;
  }

  protected function getVocabularyNodeFromVariables($variables): ?VocabularyNodeInterface {
    return $variables['node'] ?: NULL;
  }

  protected function getVocabularyEditorialPagesRenderedAsTiles(array $variables): array {
    $pages = $this->pageManager->getEditorialPagesByVocabulary($this->getVocabularyNodeFromVariables($variables));
    return !empty($pages) ? $this->viewBuilder->viewMultiple($pages, self::VIEW_MODE_TILE) : [];
  }

  protected function getVocabularyNodeByVid(string $vid): ?VocabularyNodeInterface {
    return $this->vocabularyGateway->fetchVocabularyPageByVid($vid);
  }

  /**
   * @param string $vid
   *
   * @return PageNodeInterface[]|null
   */
  protected function getVocabularyEditorialPages(string $vid): ?array {
    $vocabulary = $this->getVocabularyNodeByVid($vid);
    return $vocabulary ? $this->pageManager->getEditorialPagesByVocabulary($vocabulary) : [];
  }

  /**
   * @param string $vid
   *
   * @return \Drupal\taxonomy\TermInterface[]
   */
  protected function getVocabularyTermsFromNode(string $vid): array {
    $vocabularyGateway = VocabularyOptionsEnum::getGateway($vid);
    return $vocabularyGateway ? Drupal::service($vocabularyGateway)->getAllterms() : [];
  }

}
