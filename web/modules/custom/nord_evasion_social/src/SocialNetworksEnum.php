<?php

namespace Drupal\nord_evasion_social;

enum SocialNetworksEnum: string {

  case Facebook = 'Facebook';

  case Twitter = 'Twitter';

  case LinkedIn = 'LinkedIn';

  case Email = 'Email';


  public static function asArray(): array {
    $values = [];
    foreach (self::cases() as $vocabulary) {
      $values[$vocabulary->name] = $vocabulary->value;
    }

    return $values;
  }

  public function uri(): string {
    return match ($this) {
      self::Facebook => 'https://www.facebook.com/sharer.php',
      self::Twitter => 'https://twitter.com/share',
      self::LinkedIn => 'https://www.linkedin.com/shareArticle',
      self::Email => 'mailto:',
    };
  }

}
