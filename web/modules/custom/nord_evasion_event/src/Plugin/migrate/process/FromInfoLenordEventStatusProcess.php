<?php

namespace Drupal\nord_evasion_event\Plugin\migrate\process;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\Annotation\MigrateProcessPlugin;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;
use Drupal\paragraphs\Plugin\migrate\process\ProcessPluginBase;

/**
 * Configure field instance settings for paragraphs.
 *
 * @MigrateProcessPlugin(
 *   id = "from_info_lenord_event_status"
 * )
 */
class FromInfoLenordEventStatusProcess extends ProcessPluginBase implements ContainerFactoryPluginInterface {

  const PARAM_INFO_LENORD_EVENT_STATUS = 'info_lenord_event_status';

  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $infoLenordStatus = $this->getInfoLenordStatus($row);
    return (int) $this->isActiveStatus($infoLenordStatus);
  }

  private function getInfoLenordStatus(Row $row): int {
    return (int) $row->getSource()['info_lenord_status'];
  }

  private function isActiveStatus(int $infoLenordStatus) {
    return $infoLenordStatus === 4;
  }

}
