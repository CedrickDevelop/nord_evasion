<?php

namespace Drupal\nord_evasion_vocabulary\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;
use Drupal\node\NodeStorageInterface;
use Drupal\nord_evasion_page\Entity\PageNodeInterface;
use Drupal\nord_evasion_vocabulary\Entity\VocabularyNodeInterface;

class VocabularyGateway implements VocabularyGatewayInterface {

  protected NodeStorageInterface $nodeStorage;

  /**
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(
    protected readonly EntityTypeManagerInterface $entityTypeManager,
    protected readonly LanguageService $languageService
  ) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->nodeStorage = $this->entityTypeManager->getStorage('node');
  }

  protected function getLanguageService(): LanguageService {
    return $this->languageService;
  }

  protected function getNodeStorage(): NodeStorageInterface {
    return $this->nodeStorage;
  }

  protected function getNodeBundle(): string {
    return VocabularyNodeInterface::NODE_BUNDLE;
  }

  public function fetchVocabularyPageByVid(string $vid): ?VocabularyNodeInterface {
    $query = $this->nodeStorage->getQuery();
    $query->condition('type', VocabularyNodeInterface::NODE_BUNDLE, '=', $this->languageService->getCurrentLanguageId());
    $query->condition('status', NodeInterface::PUBLISHED);
    $query->condition(VocabularyNodeInterface::FIELD_VOCABULARY, $vid);
    $query->sort('title', 'DESC');

    $pages = $query->execute();

    if (!empty($pages)) {
      /* @var \Drupal\nord_evasion_vocabulary\Entity\VocabularyNodeInterface $vocabularyNode */
      $vocabularyNode = $this->nodeStorage->load(reset($pages));
      return $vocabularyNode;
    }
    return NULL;
  }

}
