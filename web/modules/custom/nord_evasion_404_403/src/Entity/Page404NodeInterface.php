<?php

namespace Drupal\nord_evasion_404_403\Entity;

interface Page404NodeInterface extends Page404Interface, ErrorPageNodeInterface {
  public const NODE_BUNDLE = 'page_404';
}
