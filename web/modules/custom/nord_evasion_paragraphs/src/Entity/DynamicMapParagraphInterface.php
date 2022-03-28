<?php

namespace Drupal\nord_evasion_paragraphs\Entity;

use Drupal\paragraphs\ParagraphInterface;

interface DynamicMapParagraphInterface extends ParagraphInterface, DynamicMapInterface {

  public const PARAGRAPH_TYPE = 'dynamic_map';

}
