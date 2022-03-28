<?php

namespace Drupal\nord_evasion_paragraphs\Manager;

interface ParagraphManagerInterface {

  public function alterPreprocessParagraphVariables(array $variables): array;

}
