<?php

namespace Drupal\nord_evasion_global\Manager;

use Drupal\views\ViewExecutable;

class SearchManager {

  protected const VIEW_ID = 'search';

  protected const VIEW_DISPLAY_ID = 'page';

  public function alterViewPreBuildToForceExposedFilterFormDisplay(ViewExecutable $view) {
    if ($view->id() !== self::VIEW_ID || $view->getDisplay()->getPluginId() !== self::VIEW_DISPLAY_ID) {
      return $view;
    }

    $view->getDisplay()->setOption('exposed_block', FALSE);
    return $view;
  }
}
