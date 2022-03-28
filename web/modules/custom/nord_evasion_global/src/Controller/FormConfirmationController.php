<?php

namespace Drupal\nord_evasion_global\Controller;

use Drupal\Core\Controller\ControllerBase;

class FormConfirmationController extends ControllerBase {

  public const ROUTE = 'nord_evasion_global.contact_confirmation';

  public const TWIG_THEME = 'contact_confirmation';

  public function display() {
    return [
      "#theme" => self::TWIG_THEME
    ];
  }
}
