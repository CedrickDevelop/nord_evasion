<?php

namespace Drupal\nord_evasion_404_403\Entity;

interface Page403NodeInterface extends Page403Interface, ErrorPageNodeInterface {
  public const NODE_BUNDLE = 'page_403';
}
