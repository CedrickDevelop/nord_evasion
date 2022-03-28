<?php

namespace Drupal\nord_evasion_global\Manager;


use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\nord_evasion_global\Gateway\DestinationGatewayInterface;
use Drupal\nord_evasion_global\Gateway\FetchAllTermsByWeightInterface;
use Drupal\taxonomy\TermStorageInterface;

class DestinationManager {

  use GetTaxonomyTermsForOptionDisplayTrait;

  const DYNAMIC_MAP_VIEW_MODE = 'dynamic_map';

  protected EntityViewBuilderInterface $viewBuilder;

  protected TermStorageInterface $termStorage;

  public function __construct(
    protected readonly DestinationGatewayInterface $destinationGateway,
    protected readonly EntityTypeManagerInterface $entityTypeManager
  ) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->termStorage = $this->entityTypeManager->getStorage('taxonomy_term');
    $this->viewBuilder = $this->entityTypeManager->getViewBuilder('taxonomy_term');
  }

  protected function getFetchAllTermsByWeightGateway(): FetchAllTermsByWeightInterface {
    return $this->destinationGateway;
  }

  /**
   * @return \Drupal\nord_evasion_global\Entity\DestinationTermInterface[]
   */
  public function getAllDestinations(): array {
    return $this->destinationGateway->getAllTerms();
  }

  public function getRenderedDestinationsForDynamicMap(): array {
    return $this->viewBuilder->viewMultiple($this->getAllDestinations(), self::DYNAMIC_MAP_VIEW_MODE);
  }

  public function getDestinationLabel(int $tid): string|TranslatableMarkup|null {
    return $this->termStorage->load($tid)->label();
  }


}
