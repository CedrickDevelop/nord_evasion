<?php

namespace Drupal\nord_evasion_event\Gateway;

use Drupal\nord_evasion_article\Entity\ArticleListNodeInterface;
use Drupal\nord_evasion_event\Entity\EventListNodeInterface;

interface EventListGatewayInterface {

  public function getLastModifiedPublishedEventList(): ?EventListNodeInterface;

}
