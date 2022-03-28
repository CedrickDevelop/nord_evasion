<?php

namespace Drupal\nord_evasion_event\Manager;

enum EventListResultsTitlePatternsEnum: string {

  public const TRANSLATION_VARIABLE_RESULTS_NUMBER = '@resultsNumber';

  public const TRANSLATION_VARIABLE_DATE = '@date';

  public const TRANSLATION_VARIABLE_EVENT_TYPE = '@eventType';

  public const TRANSLATION_VARIABLE_DESTINATION = '@destination';

  case NoOrOneResultNoFilter = "@resultsNumber événement";

  case MoreThanOneResultNoFilter = "@resultsNumber événements";

  case NoOrOneResultDateFilter = "@resultsNumber événement à partir du @date";

  case MoreThanOneResultDateFilter = "@resultsNumber événements  à partir du @date";

  case NoOrOneResultTypeFilter = "@resultsNumber événement pour le type d'événement @eventType";

  case MoreThanOneResultTypeFilter = "@resultsNumber événements pour le type d'événement @eventType";

  case NoOrOneResultDestinationFilter = "@resultsNumber événement pour le territoire @destination";

  case MoreThanOneResultDestinationFilter = "@resultsNumber événements pour le territoire @destination";

  case NoOrOneResultDestinationAndDateFilter = "@resultsNumber événement pour le territoire @destination à partir du @date";

  case MoreThanOneResultDestinationAndDateFilter = "@resultsNumber événements pour le territoire @destination à partir du @date";

  case NoOrOneResultTypeAndDestinationFilter = "@resultsNumber événement pour le type d'événement @eventType, le territoire @destination";

  case MoreThanOneResultTypeAndDestinationFilter = "@resultsNumber événements pour le type d'événement @eventType, le territoire @destination";

  case NoOrOneResultTypeAndDateFilter = "@resultsNumber événement pour le type d'événement @eventType à partir du @date";

  case MoreThanOneResultTypeAndDateFilter = "@resultsNumber événements pour le type d'événement @eventType à partir du @date";

  case NoOrOneResultTypeDestinationAndDateFilter = "@resultsNumber événement pour le type d'événement @eventType, le territoire @destination à partir du @date";

  case MoreThanOneResultTypeDestinationAndDateFilter = "@resultsNumber événements pour le type d'événement @eventType, le territoire @destination à partir du @date";
}
