<?php

namespace Drupal\nord_evasion_pin\Manager;

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\node\NodeInterface;
use Drupal\nord_evasion_article\Entity\Article;
use Drupal\nord_evasion_article\Entity\ArticleList;
use Drupal\nord_evasion_event\Entity\Event;
use Drupal\nord_evasion_event\Entity\EventList;
use Drupal\nord_evasion_home\Entity\Home;
use Drupal\nord_evasion_page\Entity\Page;
use Drupal\nord_evasion_pin\PinDisplayedOnEnum;
use Drupal\nord_evasion_vocabulary\Entity\Vocabulary;

class PinDisplayedOnManager {

  protected const NODE_CANONICAL_ROUTE = 'entity.node.canonical';

  const ROUTE_PARAMETER_NODE = 'node';

  public function getDisplayedOnValueForRouteMatch(RouteMatchInterface $routeMatch): ?PinDisplayedOnEnum {
    if ($routeMatch->getRouteName() !== self::NODE_CANONICAL_ROUTE) {
      return NULL;
    }

    $node = $this->getNodeFromRouteMatch($routeMatch);
    return $this->getDisplayedOnForNode($node);
  }

  protected function getNodeFromRouteMatch(RouteMatchInterface $routeMatch): NodeInterface {
    return $routeMatch->getParameter(self::ROUTE_PARAMETER_NODE);
  }

  protected function getDisplayedOnForNode(NodeInterface $node): ?PinDisplayedOnEnum {
    return match ($node::class) {
      Article::class, ArticleList::class => PinDisplayedOnEnum::Article,
      Event::class, EventList::class => PinDisplayedOnEnum::Event,
      Vocabulary::class => PinDisplayedOnEnum::Vocabulary,
      Page::class => PinDisplayedOnEnum::Editorial,
      Home::class => PinDisplayedOnEnum::Home,
      default => NULL,
    };
  }

}
