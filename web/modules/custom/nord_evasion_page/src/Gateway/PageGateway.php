<?php

namespace Drupal\nord_evasion_page\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;
use Drupal\node\NodeStorageInterface;
use Drupal\nord_evasion_page\Entity\PageNodeInterface;

class PageGateway implements PageGatewayInterface {

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
    return PageNodeInterface::NODE_BUNDLE;
  }

  /**
   * @param int $vocabularyNid
   *
   * @return PageNodeInterface[]|null
   */
  public function fetchEditorialPagesByVocabulary(int $vocabularyNid): ?array {
    $query = $this->nodeStorage->getQuery();
    $query->condition('type', PageNodeInterface::NODE_BUNDLE, '=', $this->languageService->getCurrentLanguageId());
    $query->condition('status', NodeInterface::PUBLISHED);
    $query->condition(PageNodeInterface::FIELD_THEMATIC, $vocabularyNid);
    $query->sort('title', 'DESC');

    $pages = $query->execute();

    return !empty($pages) ? $this->nodeStorage->loadMultiple($pages) : NULL;
  }

  /**
   *
   * @param int[] $termsDestinations
   * @return array|int
   */
  protected function fetchEditorialPagesIdByTermDestinations(array $termsDestinations): ?array {
    $query = $this->nodeStorage->getQuery();
    $query->condition('type', PageNodeInterface::NODE_BUNDLE, '=', $this->languageService->getCurrentLanguageId());
    $query->condition('status', NodeInterface::PUBLISHED);
    $query->condition('field_destination', $termsDestinations, 'IN');
    $query->sort('title', 'DESC');

    $pagesId = $query->execute();

    return !empty($pagesId) ? $pagesId : [];
  }

  /**
   * @param int[] $termsDestinations
   * @return NodeInterface[] | array[]
   */
  public function fetchEditorialPagesByTermDestinations(array $termsDestinations): ?array {
    $pages = $this->fetchEditorialPagesIdByTermDestinations($termsDestinations);
    return !empty($pages) ? $this->nodeStorage->loadMultiple($pages) : [];
  }

}
