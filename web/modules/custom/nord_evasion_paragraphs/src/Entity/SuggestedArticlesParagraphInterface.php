<?php

namespace Drupal\nord_evasion_paragraphs\Entity;

use Drupal\paragraphs\ParagraphInterface;

interface SuggestedArticlesParagraphInterface extends ParagraphInterface, SuggestedArticlesInterface {

  public const PARAGRAPH_TYPE = 'suggested_articles';

  public const FIELD_DESTINATION = 'field_destination';

  public const FIELD_THEME = 'field_theme';

}
