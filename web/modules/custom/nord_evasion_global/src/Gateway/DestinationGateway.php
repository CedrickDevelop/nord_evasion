<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\nord_evasion_global\Entity\DestinationTermInterface;

class DestinationGateway extends TermGatewayBase implements DestinationGatewayInterface {

  protected function getVocabularyId(): string {
    return DestinationTermInterface::TERM_VOCABULARY;
  }

  /**
   * @return DestinationTermInterface[]
   */
  public function getAllTerms(): array {
    return $this->fetchTermsByWeight();
  }

}
