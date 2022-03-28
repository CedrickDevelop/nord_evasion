<?php

namespace Drupal\nord_evasion_global\Manager;

use Drupal\nord_evasion_global\Gateway\FetchAllTermsByWeightInterface;

trait GetTaxonomyTermsForOptionDisplayTrait {

  public function getTermsForFilterDisplay(): array {
    $terms = $this->getFetchAllTermsByWeightGateway()->getAllTerms();

    $options = [];
    foreach($terms as $term) {
      $options[$term->id()] = $term->label();
    }

    return $options;
  }

  abstract protected function getFetchAllTermsByWeightGateway(): FetchAllTermsByWeightInterface;
}
