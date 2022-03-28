<?php

namespace Drupal\nord_evasion_event\Plugin\migrate\process;

use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\Annotation\MigrateProcessPlugin;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\nord_evasion_event\Manager\EventTypeManager;
use Drupal\paragraphs\Plugin\migrate\process\ProcessPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure field instance settings for paragraphs.
 *
 * @MigrateProcessPlugin(
 *   id = "from_info_lenord_event_event_type"
 * )
 */
class FromInfoLenordEventEventTypeProcess extends ProcessPluginBase implements ContainerFactoryPluginInterface {

  public function __construct(
    array                         $configuration,
                                  $plugin_id,
                                  $plugin_definition,
    EntityTypeBundleInfoInterface $entity_type_bundle_info,
    protected                     readonly EventTypeManager $eventTypeManager
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $entity_type_bundle_info);
  }

  /**
   * {@inheritdoc}
   * @noinspection PhpParamsInspection
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.bundle.info'),
      $container->get(EventTypeManager::class)
    );
  }

  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) : ?int {
    $eventTypeLabel = $this->getEventTypeLabel($row);
    $term = $this->eventTypeManager->getEventTypeByLabel($eventTypeLabel);
    return $term?->id();
  }

  private function getEventTypeLabel(Row $row): ?string {
    return $row->getSource()['types_event'];
  }

}
