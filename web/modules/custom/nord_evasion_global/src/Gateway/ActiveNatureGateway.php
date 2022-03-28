<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\nord_evasion_global\Entity\ActiveNatureTermInterface;
use Drupal\taxonomy\TermStorageInterface;

class ActiveNatureGateway extends TermGatewayBase implements ActiveNatureGatewayInterface {

  protected function getVocabularyId(): string {
    return ActiveNatureTermInterface::TERM_VOCABULARY;
  }

  /**
   * @return ActiveNatureTermInterface[]
   */
  public function getAllTerms(): array {
    return $this->fetchAllTerms();
  }

}
