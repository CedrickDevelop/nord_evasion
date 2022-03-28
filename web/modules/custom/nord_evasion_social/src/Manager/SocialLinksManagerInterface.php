<?php

namespace Drupal\nord_evasion_social\Manager;

use Drupal\Core\Link;

interface SocialLinksManagerInterface {

  public function getSelectedSocialNetworksAsArray(): array;

  public function prepareLinkBuild(string $socialNetwork): ?Link;

}
