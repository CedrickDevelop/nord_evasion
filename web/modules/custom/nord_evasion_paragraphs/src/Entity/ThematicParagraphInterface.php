<?php

namespace Drupal\nord_evasion_paragraphs\Entity;

use Drupal\paragraphs\ParagraphInterface;

interface ThematicParagraphInterface extends ParagraphInterface, ThematicInterface {

  public const PARAGRAPH_TYPE = 'theme';

  public const FIELD_TAXONOMY = 'field_taxonomy';

}
