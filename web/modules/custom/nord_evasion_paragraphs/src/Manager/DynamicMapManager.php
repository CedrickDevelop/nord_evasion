<?php

namespace Drupal\nord_evasion_paragraphs\Manager;


use Drupal\nord_evasion_global\Entity\DestinationTermInterface;
use Drupal\nord_evasion_global\Gateway\DestinationGateway;
use Drupal\nord_evasion_global\Manager\DestinationManager;
use Drupal\nord_evasion_page\Entity\Page;
use Drupal\nord_evasion_page\Manager\PageManager;
use Drupal\nord_evasion_paragraphs\Entity\DynamicMapParagraphInterface;

class DynamicMapManager implements ParagraphManagerInterface {

  public const DESTINATIONS_PREPROCESS_KEY = 'destinations';

  public function __construct(
    public readonly DestinationManager $destinationManager,
    public readonly DestinationGateway $destinationGateway,
    public readonly PageManager $pageManager
  ) {
  }

  public function alterPreprocessParagraphVariables(array $variables): array {
    if (!($variables['paragraph'] instanceof DynamicMapParagraphInterface)) {
      return $variables;
    }
    $variables[self::DESTINATIONS_PREPROCESS_KEY] = $this->getRenderedDestinationsForDynamicMapWithEditoPageLink();
    return $variables;
  }

  /**
   * Get the taxonomy term built for dynamic Map with a link to Edito page
   * @return array
   */
  public function getRenderedDestinationsForDynamicMapWithEditoPageLink(): array
  {
    //Get all the taxonomy terms built
    $builtTerms = $this->destinationManager->getRenderedDestinationsForDynamicMap();

    // Get the pageEdito Id By Term id
    $pageEditoId = $this->getPageEditoIdByTermDestination($this->getDestinationTermsIdFromTermsLoad());

    // Get built terms
    foreach ($this->getDestinationTermsIdFromTermsLoad() as $termId ){
      if(array_key_exists($termId,$pageEditoId) == $termId){
        $builtTerms[$termId]["page_edito_id"] = $pageEditoId[$termId];
      }
    }
    return $builtTerms;
  }

  /**
   *  Get an array of edito Pages id with the term id associated
   * @param DestinationTermInterface[] $termsId
   * @return array
   */
  public function getPageEditoIdByTermDestination(array $termsId): array
  {
    $editoPages = $this->pageManager->getEditorialPagesForDynamicMapByDestinations($termsId);

    return $this->getPageEditoIdByTermId($editoPages);
  }

  /**
   * @param array $editoPages
   * @return array
   */
  public function getPageEditoIdByTermId(array $editoPages): array{
    foreach ($editoPages as $edito ){
      $pageNid = $edito->id();
      $editoPageTermDestination = $edito->getDestinationTarget();
      $editoPagesBytermDestination[$editoPageTermDestination] =  $pageNid ;
    }
    return $editoPagesBytermDestination ? $editoPagesBytermDestination : [];
  }

  /**
   * Get all load Destination terms ids
   * @return array|array[]
   */
  public function getDestinationTermsIdFromTermsLoad(): ?array {
    return $this->destinationGateway->fetchTermsNidsByWeight();
  }



}
