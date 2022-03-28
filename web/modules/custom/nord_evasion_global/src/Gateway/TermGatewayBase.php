<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\taxonomy\TermStorageInterface;

abstract class TermGatewayBase implements FetchAllTermsByWeightInterface, FetchAllTermsByVidInterface {

  use FetchAllTermsByWeightTrait;
  use FetchAllTermsByVidTrait;

  protected TermStorageInterface $termStorage;

  public function __construct(
    protected readonly EntityTypeManagerInterface $entityTypeManager,
    protected readonly LanguageService $languageService
  ) {
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->termStorage = $this->entityTypeManager->getStorage('taxonomy_term');
  }

  protected function getTermStorage(): TermStorageInterface {
    return $this->termStorage;
  }

}
