<?php

namespace Drupal\nord_evasion_global\Gateway;

use Drupal\adimeo_tools\Service\LanguageService;
use Drupal\node\NodeInterface;
use Drupal\node\NodeStorageInterface;

trait GetLastChangedPublishedNodeTrait {

  use GetGatewayLanguageDependencyTrait;
  use GetNodeStorageDependencyTrait;

  protected function getLastModifiedPublishedNid(): ?string {
    $query = $this->getNodeStorage()->getQuery();
    $query->condition('type', $this->getNodeBundle(), '=', $this->getLanguageService()->getCurrentLanguageId());
    $query->condition('status', NodeInterface::PUBLISHED);
    $query->sort('changed', 'DESC');
    $query->range(0, 1);

    $queryResult = $query->execute();

    if (!empty($queryResult)) {
      return reset($queryResult);
    }
    return NULL;
  }

  protected function getLastModifiedPublishedNode(): ?NodeInterface {
    $nid = $this->getLastModifiedPublishedNid();
    if ($nid) {
        /** @var NodeInterface $node */
        $node = $this->getNodeStorage()->load($nid);
        return $node;
    }

    return NULL;
  }

  abstract protected function getNodeBundle(): string;
}
