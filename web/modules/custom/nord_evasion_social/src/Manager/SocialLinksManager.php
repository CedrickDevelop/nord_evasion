<?php

namespace Drupal\nord_evasion_social\Manager;

use Drupal\Core\Controller\TitleResolver;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Url;
use Drupal\nord_evasion_social\SocialNetworksEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Route;

class SocialLinksManager implements SocialLinksManagerInterface {

  use StringTranslationTrait;

  protected RequestStack $requestStack;
  protected TitleResolver $titleResolver;

  public function __construct(
    protected RouteMatchInterface $currentRouteMatch,
    RequestStack $requestStack,
    TitleResolver $titleResolver) {
    $this->requestStack = $requestStack;
    $this->titleResolver = $titleResolver;
  }

  public function getSelectedSocialNetworksAsArray(): array {
    return SocialNetworksEnum::asArray();
  }

  /**
   * @throws \Exception
   */
  public function prepareLinkBuild(string $socialNetwork): Link {
    return match ($socialNetwork) {
      SocialNetworksEnum::Facebook->value => $this->buildFacebookLink($socialNetwork),
      SocialNetworksEnum::Twitter->value => $this->buildTwitterLink($socialNetwork),
      SocialNetworksEnum::LinkedIn->value => $this->buildLinkedInLink($socialNetwork),
      SocialNetworksEnum::Email->value => $this->buildEmailLink($socialNetwork),
      default => throw new \Exception('Unexpected social network value'),
    };
  }

  protected function getCurrentNodeTitle(): string|TranslatableMarkup|null {
    return $this->titleResolver->getTitle($this->getCurrentRequest(), $this->getCurrentRoute());
  }

  protected function getCurrentRoute(): ?Route  {
    return $this->currentRouteMatch->getRouteObject();
  }

  protected function getCurrentRequest(): ?Request  {
    return $this->requestStack->getCurrentRequest();
  }

  protected function getCurrentNodeAbsoluteUrlString(): string {
    return Url::fromRoute('<current>', [], ['absolute' => TRUE])->toString();
  }

  protected function getLinkAttributes($socialNetwork): array {
    return [
      'class' => $socialNetwork,
      'target' => '_blank',
    ];
  }

  protected function buildFacebookLink($socialNetwork): Link {
    $options = [
      'query' => [
        'u' => $this->getCurrentNodeAbsoluteUrlString(),
        't' => $this->getCurrentNodeTitle(),
      ],
      'attributes' => $this->getLinkAttributes($socialNetwork),
    ];

    $url = Url::fromUri(SocialNetworksEnum::from($socialNetwork)->uri(), $options);
    return Link::fromTextAndUrl($this->t('Partagez sur Facebook'), $url);
  }

  protected function buildTwitterLink($socialNetwork): Link {
    $options = [
      'query' => [
        'url' => $this->getCurrentNodeAbsoluteUrlString(),
        'text' => $this->getCurrentNodeTitle(),
        'hashtags' => 'NordEvasion',
      ],
      'attributes' => $this->getLinkAttributes($socialNetwork),
    ];
    $url = Url::fromUri(SocialNetworksEnum::from($socialNetwork)->uri(), $options);
    return Link::fromTextAndUrl($this->t('Partagez sur Twitter'), $url);
  }

  protected function buildLinkedInLink($socialNetwork): Link {
    $options = [
      'query' => [
        'mini' => TRUE,
        'url' => $this->getCurrentNodeAbsoluteUrlString(),
      ],
      'attributes' => $this->getLinkAttributes($socialNetwork),
    ];
    $url = Url::fromUri(SocialNetworksEnum::from($socialNetwork)->uri(), $options);
    return Link::fromTextAndUrl($this->t('Partagez sur LinkedIn'), $url);
  }

  protected function buildEmailLink($socialNetwork): Link {
    $subject = sprintf('%s %s', $this->t('Nord Evasion :'), $this->getCurrentNodeTitle());
    $body = sprintf('%s %s', $this->t('Je viens de découvrir ceci sur le site de Nord Evasion :'), $this->getCurrentNodeAbsoluteUrlString());

    $options = [
      'query' => [
        'Subject' => $subject,
        'Body' => $body,
      ],
      'attributes' => $this->getLinkAttributes($socialNetwork),
    ];
    $url = Url::fromUri(SocialNetworksEnum::from($socialNetwork)->uri(), $options);
    return Link::fromTextAndUrl($this->t('Partagez par email'), $url);
  }



}
