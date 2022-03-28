<?php

namespace Drupal\nord_evasion_paragraphs\Manager;

use Drupal\nord_evasion_paragraphs\Entity\MediaParagraphInterface;
use Drupal\nord_evasion_paragraphs\Entity\PhotoAlbumParagraphInterface;

class MediaPhotoAlbumManager implements ParagraphManagerInterface {

  protected const NB_MEDIAS = 'nb_media';

  public function alterPreprocessParagraphVariables($variables): array {
    if (!($variables['paragraph'] instanceof MediaParagraphInterface) && !($variables['paragraph'] instanceof PhotoAlbumParagraphInterface)) {
      return $variables;
    }

    $variables[self::NB_MEDIAS] = $this->getMediaCountFromParagraph($variables['paragraph']);

    return $variables;
  }

  protected function getMediaFieldNameFromParagraph(MediaParagraphInterface|PhotoAlbumParagraphInterface $paragraph): ?string {
    return match ($paragraph->getType()) {
      MediaParagraphInterface::PARAGRAPH_TYPE => MediaParagraphInterface::FIELD_MEDIA,
      PhotoAlbumParagraphInterface::PARAGRAPH_TYPE => PhotoAlbumParagraphInterface::FIELD_PHOTOS,
      default => NULL
    };
  }

  protected function getMediaCountFromParagraph(MediaParagraphInterface|PhotoAlbumParagraphInterface $paragraph): ?int {
    $fieldName = $this->getMediaFieldNameFromParagraph($paragraph);
    if (!$fieldName) {
      return NULL;
    }

    /* @var \Drupal\Core\Field\EntityReferenceFieldItemListInterface $mediaList */
    $mediaList = $paragraph->get($fieldName);
    return $mediaList?->count();
  }

}
