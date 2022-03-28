<?php

namespace Drupal\nord_evasion_paragraphs\Entity;

use Drupal\nord_evasion_event\Entity\EventNodeInterface;
use Drupal\paragraphs\ParagraphInterface;

interface AgendaParagraphInterface extends ParagraphInterface, AgendaInterface {

  public const PARAGRAPH_TYPE = 'agenda';

  public const FIELD_DESTINATION = EventNodeInterface::FIELD_DESTINATION;

  public const FIELD_EVENT_TYPE = EventNodeInterface::FIELD_EVENT_TYPE;

}
