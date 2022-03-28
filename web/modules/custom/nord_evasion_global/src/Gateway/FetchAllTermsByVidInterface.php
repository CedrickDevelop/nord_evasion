<?php

namespace Drupal\nord_evasion_global\Gateway;

interface FetchAllTermsByVidInterface {

  public function fetchAllTermsNids(): array;

  public function fetchAllTerms(): array;

}
