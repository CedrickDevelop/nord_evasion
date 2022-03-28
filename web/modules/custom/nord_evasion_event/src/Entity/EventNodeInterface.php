<?php

namespace Drupal\nord_evasion_event\Entity;

use Drupal\node\NodeInterface;

interface EventNodeInterface extends EventInterface, NodeInterface {

  public const NODE_BUNDLE = 'event';

  public const FIELD_START_DATE = 'field_start_date';

  public const FIELD_END_DATE = 'field_end_date';

  const FIELD_EVENT_TYPE = 'field_event_type';

  const FIELD_DESTINATION = 'field_destination';

}
