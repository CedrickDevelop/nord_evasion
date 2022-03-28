<?php

namespace Drupal\nord_evasion_article\Form;

interface ArticleListFormDTOInterface {

  public function getDestination(): ?string;

  public function getThematic(): ?string;
}
