<?php

namespace Drupal\nord_evasion_paragraphs\Entity;

use Drupal\paragraphs\ParagraphInterface;

interface PhotoAlbumParagraphInterface extends ParagraphInterface, PhotoAlbumInterface {

  public const PARAGRAPH_TYPE = 'photo_album';

  public const FIELD_PHOTOS = 'field_photos';

}
