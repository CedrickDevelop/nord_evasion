<?php

namespace Drupal\nord_evasion_pin\Manager;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityViewBuilderInterface;
use Drupal\nord_evasion_pin\Entity\PinNodeInterface;
use Drupal\nord_evasion_pin\Gateway\PinGateway;
use Drupal\nord_evasion_pin\Gateway\PinGatewayInterface;
use Drupal\nord_evasion_pin\PinDisplayedOnEnum;

class PinManager {

  protected EntityViewBuilderInterface $viewBuilder;

  public function __construct(
    protected readonly PinGatewayInterface $pinGateway,
    EntityTypeManagerInterface $entityTypeManager
  ) {
    $this->viewBuilder = $entityTypeManager->getViewBuilder('node');
  }

  public function getCurrentPinRenderArrayIfItShouldBeDisplayed(?PinDisplayedOnEnum $context): ?array {
    if (!$context) {
      return NULL;
    }

    $currentPin = $this->getCurrentPin();
    return $currentPin !== NULL && $this->pinIsDisplayedForContext($currentPin, $context) ? $this->prepareForRendering($currentPin) : NULL;
  }

  protected function getCurrentPin(): ?PinNodeInterface {
    return $this->pinGateway->getLastModifiedPublishedPin();
  }

  protected function pinIsDisplayedForContext(PinNodeInterface $currentPin, PinDisplayedOnEnum $context): bool {
    return in_array($context, $currentPin->getDisplayedOn());
  }

  protected function prepareForRendering(PinNodeInterface $currentPin): array {
    return $this->viewBuilder->view($currentPin);
  }

}
