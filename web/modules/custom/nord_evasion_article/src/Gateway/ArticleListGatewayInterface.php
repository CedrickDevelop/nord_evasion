<?php

namespace Drupal\nord_evasion_article\Gateway;

use Drupal\nord_evasion_article\Entity\ArticleListNodeInterface;

interface ArticleListGatewayInterface {

  public function getLastEditedArticleList(): ?ArticleListNodeInterface;

}
