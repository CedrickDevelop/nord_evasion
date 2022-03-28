<?php

namespace Drupal\nord_evasion_event\Gateway;

use Drupal\nord_evasion_event\Entity\EventTypeTermInterface;
use Drupal\nord_evasion_global\Gateway\TermGatewayBase;

class EventTypeGateway  extends TermGatewayBase implements EventTypeGatewayInterface {

  protected function getVocabularyId(): string {
    return EventTypeTermInterface::TERM_VOCABULARY;
  }

  /**
   * @return EventTypeTermInterface[]
   */
  public function getAllTerms(): array {
    /** @var EventTypeTermInterface[] $terms */
    $terms = $this->fetchTermsByWeight();
    return $terms;
  }

  public function getTermByLabel(string $label) {
    $query = $this->termStorage->getQuery();
    $nids = $query->condition('vid', $this->getVocabularyId())
      ->condition('name', $label)
      ->execute();

    return (sizeof($nids)) ? $this->termStorage->load(reset($nids)) : NULL;
  }

}
