<?php

namespace Drupal\nord_evasion_article\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\nord_evasion_global\Form\FilterListFormBase;
use Drupal\nord_evasion_global\Manager\DestinationManager;
use Drupal\nord_evasion_global\Manager\ThematicsManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ArticleListFilterForm extends FilterListFormBase {

  const FORM_ID = 'articles_list_filter_form';

  const FIELD_DESTINATION = 'destination';

  const FIELD_THEMATICS = 'thematic';

  public function __construct(
    protected readonly DestinationManager $destinationManager,
    protected readonly ThematicsManager $thematicsManager
  ) {

  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get(DestinationManager::class),
      $container->get(ThematicsManager::class)
    );
  }

  public function getFormId(): string {
    return self::FORM_ID;
  }

  public function buildForm(array $form, FormStateInterface $formState, ?ArticleListFormDTOInterface $dto = NULL): array {
    $form = parent::buildForm($form, $formState);
    $form[self::FIELD_DESTINATION] = $this->buildDestinationSelect($dto);
    $form[self::FIELD_THEMATICS] = $this->buildThematicsSelect($dto);

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => $this->buildSubmit(),
    ];

    return $form;
  }

  protected function buildDestinationSelect(ArticleListFormDTOInterface $dto): array {
    return [
      '#title' => $this->t('Destination'),
      '#type' => 'select',
      '#options' => $this->destinationManager->getTermsForFilterDisplay(),
      "#empty_option" => $this->t('Tout le département'),
      '#default_value' => $dto->getDestination(),
    ];
  }

  protected function buildThematicsSelect(ArticleListFormDTOInterface $dto): array {
    return [
      '#title' => $this->t('Thématique'),
      '#type' => 'select',
      '#options' => $this->thematicsManager->getThematicsForOptions(),
      "#empty_option" => $this->t('Tous les articles'),
      '#default_value' => $dto->getThematic(),
    ];
  }

  protected function buildSubmit(): array {
    return [
      '#type' => 'submit',
      '#value' => $this->t('Filtrer'),
      '#attributes' => [
        'name' => '',
      ],
    ];
  }
}
