<?php

namespace Drupal\nord_evasion_article\Entity;

use Drupal\node\NodeInterface;

interface ArticleListNodeInterface extends ArticleListInterface, NodeInterface {

  public const NODE_BUNDLE = 'article_list';

}
