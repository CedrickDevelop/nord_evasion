<?php

namespace Drupal\nord_evasion_article\Form;

class ArticleListFormDTO implements ArticleListFormDTOInterface {

  protected const FIELD_DESTINATION = ArticleListFilterForm::FIELD_DESTINATION;

  protected const FIELD_THEMATIC = ArticleListFilterForm::FIELD_THEMATICS;

  /**
   * @param array $params
   */
  public function __construct(protected readonly array $params) {
  }

  public function getDestination(): ?string {
    return $this->params[self::FIELD_DESTINATION] ?? NULL;
  }

  public function getThematic(): ?string {
    return $this->params[self::FIELD_THEMATIC] ?? NULL;
  }

}
