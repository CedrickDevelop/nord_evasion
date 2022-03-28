<?php

namespace Drupal\nord_evasion_global\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\nord_evasion_global\Gateway\FetchAllTermsByVidTrait;
use Drupal\taxonomy\TermStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a social networks taxonomy block.
 *
 * @Block(
 *   id = "nord_evasion_global_social_networks",
 *   admin_label = @Translation("Social networks"),
 *   category = @Translation("Custom")
 * )
 */
class SocialNetworksTaxonomyBlock extends BlockBase implements ContainerFactoryPluginInterface {

  use FetchAllTermsByVidTrait;

  public const TEMPLATE = 'social_networks_block';

  protected const ID = 'social_networks';

  protected const ENTITY_TYPE_ID = 'taxonomy_term';

  protected TermStorageInterface $termStorage;

  /**
   * @var \Drupal\taxonomy\TermInterface[]
   */
  protected array $socialNetworks;

  protected EntityViewBuilderInterface $viewBuilder;

  /**
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, protected readonly EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    /** @noinspection PhpFieldAssignmentTypeMismatchInspection */
    $this->termStorage = $this->entityTypeManager->getStorage(self::ENTITY_TYPE_ID);
    $this->viewBuilder = $this->entityTypeManager->getViewBuilder(self::ENTITY_TYPE_ID);
    $this->socialNetworks = $this->fetchAllTerms();
  }

  /**
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): SocialNetworksTaxonomyBlock|static {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }

  /**
   * @inheritDoc
   */
  public function build(): ?array {
    $builtSocialNetworks = $this->toRenderable();
    return $this->addCacheInfosToBuild($builtSocialNetworks);
  }

  protected function addCacheInfosToBuild(?array $build): ?array {
    return $build;
  }

  public function toRenderable(): array {
    return [
      '#theme' => self::TEMPLATE,
      '#social_networks' => $this->viewBuilder->viewMultiple($this->socialNetworks),
    ];
  }

  protected function getVocabularyId(): string {
    return self::ID;
  }

  protected function getTermStorage(): TermStorageInterface {
    return $this->termStorage;
  }

}
