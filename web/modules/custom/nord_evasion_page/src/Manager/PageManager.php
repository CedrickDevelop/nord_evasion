<?php

namespace Drupal\nord_evasion_page\Manager;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\node\NodeInterface;
use Drupal\nord_evasion_page\Entity\PageNodeInterface;
use Drupal\nord_evasion_page\Gateway\PageGatewayInterface;
use Drupal\nord_evasion_vocabulary\Entity\VocabularyNodeInterface;

class PageManager {

  protected EntityViewBuilderInterface $viewBuilder;

  public function __construct(
    protected readonly PageGatewayInterface $pageGateway,
    protected readonly EntityTypeManagerInterface $entityTypeManager
  ) {
    $this->viewBuilder = $this->entityTypeManager->getViewBuilder('node');
    $this->nodeStorage = $this->entityTypeManager->getStorage('node');
  }

  /**
   * @param VocabularyNodeInterface $vocabulary
   *
   * @return PageNodeInterface[]|null
   */
  public function getEditorialPagesByVocabulary(VocabularyNodeInterface $vocabulary): ?array {
    return $this->pageGateway->fetchEditorialPagesByVocabulary($vocabulary->id());
  }

  public function getVocabularyNode(int $nid): ?VocabularyNodeInterface{
    /* @var \Drupal\nord_evasion_vocabulary\Entity\VocabularyNodeInterface $vocabulary */
    $vocabulary = $this->nodeStorage->load($nid);
    return $vocabulary;
  }

  /**
   * @param array $termsDestinations
   * @return NodeInterface[]|null
   */
  public function getEditorialPagesForDynamicMapByDestinations(array $termsDestinations): ?array{
    return $this->pageGateway->fetchEditorialPagesByTermDestinations($termsDestinations);
  }

}
