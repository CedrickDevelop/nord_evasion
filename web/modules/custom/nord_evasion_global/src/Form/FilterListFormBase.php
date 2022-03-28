<?php

namespace Drupal\nord_evasion_global\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

abstract class FilterListFormBase extends FormBase {

  public function buildForm(array $form, FormStateInterface $formState) {
    $formState
      ->setMethod('GET')
      ->setCached(FALSE)
      ->disableRedirect();

    $form['#cache'] = [
      'max-age' => 0,
    ];
    $form['#after_build'][] = [self::class, 'afterBuild'];

    return $form;
  }

  public static function afterBuild(array $form, FormStateInterface $formState) {
    unset($form['form_token']);
    unset($form['form_build_id']);
    unset($form['form_id']);
    unset($form['op']);
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    // do nothing, managers will take care of this
  }

}
