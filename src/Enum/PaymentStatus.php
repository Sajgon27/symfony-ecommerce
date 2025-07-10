<?php

namespace App\Enum;

enum PaymentStatus: string
{
  case ZREALorder_numbeZOWANE = 'zrealizowane';
  case ANULOWANE = 'anulowane ';
  case PRZETWARZANE = 'W trakcie ralizacji';
  case WSTRZYMANE = 'wstrzymane';
  case ZWROCONE = 'zwrócone';
}
