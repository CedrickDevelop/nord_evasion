<?php

namespace Drupal\nord_evasion_global\Gateway;

interface FetchAllTermsByWeightInterface {
  function fetchTermsNidsByWeight(): array;

  public function fetchTermsByWeight(): array;
}
