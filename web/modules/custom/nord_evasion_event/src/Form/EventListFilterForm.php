<?php

namespace Drupal\nord_evasion_event\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\nord_evasion_event\Manager\EventTypeManager;
use Drupal\nord_evasion_global\Form\FilterListFormBase;
use Drupal\nord_evasion_global\Manager\DateFullMonthTrait;
use Drupal\nord_evasion_global\Manager\DestinationManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Nord Evasion Events module form.
 */
class EventListFilterForm extends FilterListFormBase {

  use DateFullMonthTrait;

  public const FORM_ID = 'event_list_filter_form';

  public const FIELD_FROM_DAY = 'day';

  public const FIELD_FROM_MONTH = 'month';

  public const FIELD_FROM_YEAR = 'year';

  public const FIELD_DESTINATION = 'destination';

  const FIELD_EVENT_TYPE = 'type';


  public function __construct(
    protected readonly EventTypeManager $eventTypeManager,
    protected readonly DestinationManager $destinationManager
  ) {

  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get(EventTypeManager::class),
      $container->get(DestinationManager::class)
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return self::FORM_ID;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $formState, EventFiltersInterface $eventFilters = NULL) {
    $form = parent::buildForm($form, $formState);

    $form[self::FIELD_EVENT_TYPE] = $this->buildEventTypeSelect($eventFilters);
    $form[self::FIELD_DESTINATION] = $this->buildDestinationSelect($eventFilters);

    $form['from_container'] = [
      '#type' => 'container',
      // todo place this string when decided where it should be functionally
      //      '#title' => $this->t('À partir du'),
      '#attributes' => [
        'class' => ['from_wrapper'],
      ],
      'title' => [
        '#markup' => $this->t("À partir du"),
      ],
      self::FIELD_FROM_DAY => $this->buildFromDaySelect($eventFilters),
      self::FIELD_FROM_MONTH => $this->buildFromMonthSelect($eventFilters),
      self::FIELD_FROM_YEAR => $this->buildFromYearSelect($eventFilters),
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => $this->buildSubmit(),
    ];


    return $form;
  }

  protected function buildEventTypeSelect(EventFiltersInterface $eventFilterFormDTO) {
    return [
      '#title' => $this->t('Type'),
      '#type' => 'select',
      '#options' => $this->eventTypeManager->getTermsForFilterDisplay(),
      "#empty_option" => $this->t('Tous'),
      '#default_value' => $eventFilterFormDTO->getSingleDestination(),
    ];
  }

  protected function buildDestinationSelect(EventFiltersInterface $eventFilters) {
    return [
      '#title' => $this->t('Destination'),
      '#type' => 'select',
      '#options' => $this->destinationManager->getTermsForFilterDisplay(),
      "#empty_option" => $this->t('Tout le département'),
      '#default_value' => $eventFilters->getSingleDestination(),
    ];
  }

  protected function buildFromDaySelect(?EventFiltersInterface $eventFilters) {
    return [
      '#title' => $this->t('Jour'),
      '#type' => 'select',
      '#options' => $this->getRangeAsBothKeyAndVal(1, 31),
      '#required' => TRUE,
      '#default_value' => $eventFilters->getFromDay(),
    ];
  }

  protected function buildFromMonthSelect(?EventFiltersInterface $eventFilters) {
    return [
      '#title' => $this->t('Mois'),
      '#type' => 'select',
      '#options' => $this->getMonthOptions(),
      '#required' => TRUE,
      '#default_value' => $eventFilters->getFromMonth(),
    ];
  }

  protected function buildFromYearSelect(?EventFiltersInterface $eventFilters) {
    return [
      '#title' => $this->t('Année'),
      '#type' => 'select',
      '#options' => $this->getRangeAsBothKeyAndVal(date('Y'), 2100),
      '#required' => TRUE,
      '#default_value' => $eventFilters->getFromYear(),
    ];
  }

  protected function buildSubmit() {
    return [
      '#type' => 'submit',
      '#value' => $this->t('Filtrer'),
      '#attributes' => [
        'name' => '',
      ],
    ];
  }

  protected function getRangeAsBothKeyAndVal(int $min, int $max) {
    $steps = range($min, $max);
    return array_combine($steps, $steps);
  }

  protected function getMonthOptions() {
    return $this->getMonthValueByKey();
  }

}
