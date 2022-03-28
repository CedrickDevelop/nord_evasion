<?php

namespace Drupal\nord_evasion_article\Entity;

use Drupal\node\Entity\Node;

class ArticleList extends Node implements ArticleListNodeInterface {

  public const NODE_BUNDLE = 'article_list';

}
