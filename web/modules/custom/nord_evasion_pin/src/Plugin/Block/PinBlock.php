<?php

namespace Drupal\nord_evasion_pin\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\nord_evasion_pin\Manager\PinDisplayedOnManager;
use Drupal\nord_evasion_pin\Manager\PinManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a pin block.
 *
 * @Block(
 *   id = "nord_evasion_pin_pin",
 *   admin_label = @Translation("Pin"),
 *   category = @Translation("Custom")
 * )
 */
class PinBlock extends BlockBase implements ContainerFactoryPluginInterface {

  public function __construct(
    array                           $configuration,
                                    $plugin_id,
                                    $plugin_definition,
    protected RouteMatchInterface   $currentRouteMatch,
    protected PinManager        $pinManager,
    protected PinDisplayedOnManager $pinDisplayedOnManager
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    /** @noinspection PhpParamsInspection */
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_route_match'),
      $container->get(PinManager::class),
      $container->get(PinDisplayedOnManager::class)
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $currentDisplayedOnValue = $this->pinDisplayedOnManager->getDisplayedOnValueForRouteMatch($this->currentRouteMatch);
    $builtPin = $this->pinManager->getCurrentPinRenderArrayIfItShouldBeDisplayed($currentDisplayedOnValue);
    $build = $this->addCacheInfosToBuild($builtPin);
    return $build;
  }

  protected function addCacheInfosToBuild(?array $build) {
    $build['#cache']['tags'][] = 'node_list:pin';
    return $build;
  }

}
