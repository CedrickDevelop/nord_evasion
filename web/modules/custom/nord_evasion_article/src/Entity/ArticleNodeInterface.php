<?php

namespace Drupal\nord_evasion_article\Entity;

use Drupal\node\NodeInterface;

interface ArticleNodeInterface extends ArticleInterface, NodeInterface {

  public const NODE_BUNDLE = 'article';

  public const FIELD_CULTURAL_HISTORY = 'field_cultural_history_theme';

  public const FIELD_ACTIVE_NATURE = 'field_active_nature_theme';

  public const FIELD_DESTINATION = 'field_destination';

}
