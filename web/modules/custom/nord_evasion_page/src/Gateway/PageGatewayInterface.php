<?php

namespace Drupal\nord_evasion_page\Gateway;

use Drupal\node\NodeInterface;
use Drupal\nord_evasion_page\Entity\PageNodeInterface;

interface PageGatewayInterface {

  /**
   * @param int $vocabularyNid
   *
   * @return PageNodeInterface[]|null
   */
  public function fetchEditorialPagesByVocabulary(int $vocabularyNid): ?array;

  /**
   * @param int[] $termsDestinations
   * @return NodeInterface[] | array[]
   */
  public function fetchEditorialPagesByTermDestinations(array $termsDestinations): ?array;


}
