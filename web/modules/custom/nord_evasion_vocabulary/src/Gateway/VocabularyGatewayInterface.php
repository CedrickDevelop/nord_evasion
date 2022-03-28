<?php

namespace Drupal\nord_evasion_vocabulary\Gateway;

use Drupal\nord_evasion_vocabulary\Entity\VocabularyNodeInterface;

interface VocabularyGatewayInterface {

  public function fetchVocabularyPageByVid(string $vid): ?VocabularyNodeInterface;

}
