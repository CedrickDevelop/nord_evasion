<?php

namespace Drupal\nord_evasion_paragraphs\Manager;

use Drupal\nord_evasion_event\Form\AgendaParagraphEventFilters;
use Drupal\nord_evasion_event\Form\EventFiltersInterface;
use Drupal\nord_evasion_event\Manager\EventManager;
use Drupal\nord_evasion_paragraphs\Entity\AgendaParagraphInterface;

class AgendaManager implements ParagraphManagerInterface {

  protected const EVENT_LIST_PREPROCESS_KEY = 'event_list';

  public function __construct(protected readonly EventManager $eventManager) {
  }

  public function alterPreprocessParagraphVariables(array $variables): array {
    if (!($variables['paragraph'] instanceof AgendaParagraphInterface)) {
      return $variables;
    }

    $agendaParagraphEventFilterDTO = $this->getAgendaParagraphEventFilterDTOFromParagraph($variables['paragraph']);
    $variables[self::EVENT_LIST_PREPROCESS_KEY] = $this->eventManager->getAgendaParagraphEventsRenderArray($agendaParagraphEventFilterDTO);

    return $variables;
  }

  protected function getAgendaParagraphEventFilterDTOFromParagraph(AgendaParagraphInterface $paragraph): EventFiltersInterface {
    return new AgendaParagraphEventFilters($paragraph->get(AgendaParagraphInterface::FIELD_DESTINATION), $paragraph->get(AgendaParagraphInterface::FIELD_EVENT_TYPE));
  }

}
