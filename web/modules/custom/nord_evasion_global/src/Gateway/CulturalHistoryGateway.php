<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\nord_evasion_global\Entity\CulturalHistoryTermInterface;
use Drupal\taxonomy\TermStorageInterface;

class CulturalHistoryGateway extends TermGatewayBase implements CulturalHistoryGatewayInterface {

  protected function getVocabularyId(): string {
    return CulturalHistoryTermInterface::TERM_VOCABULARY;
  }

  /**
   * @return CulturalHistoryTermInterface[]
   */
  public function getAllTerms(): array {
    return $this->fetchAllTerms();
  }

}
