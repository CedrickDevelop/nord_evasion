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
 *   id = "from_info_lenord_event_description"
 * )
 */
class FromInfoLenordEventDescriptionProcess extends ProcessPluginBase implements ContainerFactoryPluginInterface {

  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    $url = $this->getContentUrl($row);
    $content = $this->extractContentFromUrl($url);
    return $content;
  }

  private function getContentUrl(Row $row): string {
    return 'https://' . $row->getSource()['content_url'];
  }

  private function extractContentFromUrl(string $url): ?string {
    return json_decode(file_get_contents($url), TRUE)['content'] ?: NULL;
  }

}
