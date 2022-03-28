<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\node\NodeStorageInterface;

trait GetGatewayLanguageDependencyTrait {
  abstract protected function getLanguageService(): LanguageService;


}
