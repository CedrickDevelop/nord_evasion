<?php

namespace Drupal\nord_evasion_social\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\nord_evasion_social\Manager\SocialLinksManager;
use Drupal\nord_evasion_social\SocialNetworksEnum;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a social links block.
 *
 * @Block(
 *   id = "nord_evasion_social_block",
 *   admin_label = @Translation("Nord Evasion Social share"),
 *   category = @Translation("Custom")
 * )
 */
class SocialBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected const ALLOWED_SOCIAL_NETWORKS_KEY = 'allowed_social_networks';

  public function __construct(array $configuration, $plugin_id, $plugin_definition, protected SocialLinksManager $socialLinksManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): SocialBlock|static {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get(SocialLinksManager::class)
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return parent::defaultConfiguration() + [
        self::ALLOWED_SOCIAL_NETWORKS_KEY => [],
      ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state): array {

    $form = parent::buildConfigurationForm($form, $form_state);

    $form[self::ALLOWED_SOCIAL_NETWORKS_KEY] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Réseaux sociaux'),
      '#options' => SocialNetworksEnum::asArray(),
      '#default_value' => $this->configuration[self::ALLOWED_SOCIAL_NETWORKS_KEY],
    ];

    $form['context_config']['#process'] = [
      [
        $this,
        'updateContextConfigurationForm',
      ],
    ];
    $form['context_config']['#type'] = 'container';
    $form['context_config']['#attributes'] = ['id' => 'context-configuration-form'];

    return $form;
  }

  public function updateContextConfigurationForm($form_element, FormStateInterface $form_state, &$form) {
    return $form_element;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    parent::submitConfigurationForm($form, $form_state);
    if (!$form_state->getErrors()) {
      $this->configuration[self::ALLOWED_SOCIAL_NETWORKS_KEY] = $form_state->getValue(self::ALLOWED_SOCIAL_NETWORKS_KEY);
    }
  }


  public function build(): array {
    $links = [];
    foreach ($this->configuration[self::ALLOWED_SOCIAL_NETWORKS_KEY] as $socialNetwork) {
      if (!empty($socialNetwork)) {
        $links[] = $this->socialLinksManager->prepareLinkBuild($socialNetwork);
      }
    }

    return [
      '#theme' => 'social_block',
      '#links' => $links,
    ];
  }



}
