<?php

namespace Drupal\nord_evasion_paragraphs\Entity;

use Drupal\paragraphs\ParagraphInterface;

interface MediaParagraphInterface extends ParagraphInterface, MediaInterface {

  public const PARAGRAPH_TYPE = 'media';

  public const FIELD_MEDIA = 'field_media';

}
