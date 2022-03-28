<?php

namespace Drupal\nord_evasion_global\Manager;

use DateTime;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;

trait DateRangeDisplayTrait {

  use StringTranslationTrait;

  protected function getDisplayedDateRangeFromDrupalDateTime(DrupalDateTime $date1, ?DrupalDateTime $date2 = NULL): TranslatableMarkup {

    if (!$date2) {
      return $this->getOneDayDisplay($date1);
    }

    return $this->areBothDatesTheSame($date1, $date2)
      ? $this->getOneDayDisplay($date1)
      : $this->getDateRangeDisplay($date1, $date2);
  }

  protected function getDisplayedDateRangeFromDateTime(DateTime $date1, ?DateTime $date2 = NULL): TranslatableMarkup {
    $drupalDate1 = DrupalDateTime::createFromDateTime($date1);
    $drupalDate2 = $date2
      ? DrupalDateTime::createFromDateTime($date2)
      : NULL;
    return $this->getDisplayedDateRangeFromDrupalDateTime($drupalDate1, $drupalDate2);
  }

  protected function getOneDayDisplay(DrupalDateTime $date): TranslatableMarkup {
    return $this->t($this->getOneDayTranslationPattern(), ['@date' => $date->format('d F Y')]);
  }

  protected function getDateRangeDisplay(DrupalDateTime $date1, DrupalDateTime $date2): TranslatableMarkup {
    // Make sure the dates are in the right order
    $from = min($date1, $date2);
    $to = max($date1, $date2);

    $separatePartsFormat = $this->getSeparatePartsDateFormat($from, $to);
    $commonPartFormat = $this->getCommonPartDateFormat($from, $to);

    return $this->t($this->getRangeTranslationPattern(), [
      '@from' => $from->format($separatePartsFormat),
      '@to' => $to->format($separatePartsFormat),
      '@common' => $from->format($commonPartFormat),
    ]);

  }

  protected function getSeparatePartsDateFormat(DrupalDateTime $from, DrupalDateTime $to): string {
    if ($this->areBothDateTheSameMonthAndYear($from, $to)) {
      return 'd';
    }

    if ($this->areBothDateTheSameYear($from, $to)) {
      return 'd F';
    }
    return 'd F Y';
  }

  protected function getCommonPartDateFormat(DrupalDateTime $from, DrupalDateTime $to): string {
    if ($this->areBothDateTheSameMonthAndYear($from, $to)) {
      return 'F Y';
    }

    if ($this->areBothDateTheSameYear($from, $to)) {
      return 'Y';
    }
    return '';
  }

  protected function areBothDatesTheSame(DrupalDateTime $from, DrupalDateTime $to): bool {
    return $this->areDateTimeFormatsTheSame($from, $to, 'Y-m-d');
  }

  protected function areBothDateTheSameMonthAndYear(DrupalDateTime $from, DrupalDateTime $to): bool {
    return $this->areDateTimeFormatsTheSame($from, $to, 'Y-m');
  }

  protected function areBothDateTheSameYear(DrupalDateTime $from, DrupalDateTime $to): bool {
    return $this->areDateTimeFormatsTheSame($from, $to, 'Y');
  }

  protected function areDateTimeFormatsTheSame(DrupalDateTime $date1, DrupalDateTime $date2, string $format): bool {
    return $date1->format($format) === $date2->format($format);
  }

  protected function getOneDayTranslationPattern(): string {
    return 'Le @date';
  }

  protected function getRangeTranslationPattern(): string {

    echo '<span>Du </span>';
    return '@from au @to @common';
  }

}
