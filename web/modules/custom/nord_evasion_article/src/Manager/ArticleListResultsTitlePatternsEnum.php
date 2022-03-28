<?php

namespace Drupal\nord_evasion_article\Manager;

enum ArticleListResultsTitlePatternsEnum: string {

  public const TRANSLATION_VARIABLE_RESULTS_NUMBER = '@resultsNumber';

  public const TRANSLATION_VARIABLE_THEMATIC = '@thematic';

  public const TRANSLATION_VARIABLE_DESTINATION = '@destination';

  case NoOrOneResultNoFilter = "@resultsNumber article";

  case MoreThanOneResultNoFilter = "@resultsNumber articles";

  case NoOrOneResultThematicFilter = "@resultsNumber article pour la thématique @thematic";

  case MoreThanOneResultThematicFilter = "@resultsNumber articles pour la thématique @thematic";

  case NoOrOneResultDestinationFilter = "@resultsNumber article pour le territoire @destination";

  case MoreThanOneResultDestinationFilter = "@resultsNumber articles pour le territoire @destination";

  case NoOrOneResultThematicAndDestinationFilter = "@resultsNumber article pour la thématique @thematic et le territoire @destination";

  case MoreThanOneResultThematicAndDestinationFilter = "@resultsNumber articles pour la thématique @thematic et le territoire @destination";

}
